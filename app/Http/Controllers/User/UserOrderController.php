<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Merch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')
            ->where('email', Auth::user()->email)
            ->latest()
            ->paginate(10);

        return view('user.order.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items')
            ->where('email', Auth::user()->email)
            ->findOrFail($id);

        return view('user.order.show', compact('order'));
    }

        public function checkout(Request $request)
    {

        $mode = session()->get('checkout_mode');

        // 🔥 Jika ada request dari cart (selected_ids), pastikan mode adalah cart
        if ($request->has('selected_ids')) {
            $mode = 'cart';
            session()->put('checkout_mode', 'cart');
        }

        // =========================
        // ✅ MODE BUY NOW
        // =========================
        if ($mode === 'buynow') {
            $data = session()->get('buynow');

            if (!$data) {
                return redirect()->route('user.cart.index')
                    ->with('error', 'Data buy now tidak ditemukan.');
            }

            $merch = Merch::with('artist')->find($data['merch_id']);

            if (!$merch) {
                return redirect()->route('user.cart.index')
                    ->with('error', 'Produk tidak ditemukan.');
            }

            $qty = $data['qty'];
            $subtotal = $merch->harga * $qty;

            $items = [[
                'merch'    => $merch,
                'qty'      => $qty,
                'subtotal' => $subtotal,
            ]];

            $total = $subtotal;

            return view('user.order.checkout', compact('items', 'total'));
        }

        // =========================
        // 🛒 MODE CART
        // =========================
        session()->put('checkout_mode', 'cart'); // ✅ tambah ini

        $selectedIds = $request->input('selected_ids', []);

        if (empty($selectedIds)) {
            return redirect()->route('user.shop.index')
                ->with('error', 'Pilih minimal satu produk.');
        }

        $cart = session()->get('cart', []);
        $items = [];
        $total = 0;

        foreach ($selectedIds as $id) {
            if (!isset($cart[$id])) continue;

            $merch = Merch::with('artist')->find($id);

            if ($merch) {
                $qty = $cart[$id]['qty'];
                $subtotal = $merch->harga * $qty;

                $items[] = [
                    'merch'    => $merch,
                    'qty'      => $qty,
                    'subtotal' => $subtotal,
                ];

                $total += $subtotal;
            }
        }

        if (empty($items)) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Produk tidak valid.');
        }

        session()->put('checkout_selected_ids', $selectedIds);

        return view('user.order.checkout', compact('items', 'total'));
    }
    /**
     * Simpan pesanan
     */
  public function store(Request $request)
{
    $mode = session()->get('checkout_mode');

    $request->validate([
        'metode_pembayaran' => 'required|string',
        'alamat_lengkap'    => 'required|string|max:500',
        'kota'              => 'required|string|max:100',
        'kode_pos'          => 'required|string|max:10',
    ]);

    $selectedIds = []; // ✅ Definisikan di sini dulu sebagai default

    if ($mode === 'buynow') {
        $data = session()->get('buynow');
        $merch = Merch::find($data['merch_id']);
        $qty = $data['qty'];
        $items = [[
            'merch'    => $merch,
            'qty'      => $qty,
            'subtotal' => $merch->harga * $qty,
        ]];
        $total = $merch->harga * $qty;
    } else {
        $selectedIds = session()->get('checkout_selected_ids', []); // ✅ Timpa di mode cart
        $cart = session()->get('cart', []);
        $items = [];
        $total = 0;

        foreach ($selectedIds as $id) {
            if (isset($cart[$id])) {
                $merch = Merch::find($id);
                if ($merch) {
                    $qty = $cart[$id]['qty'];
                    $subtotal = $merch->harga * $qty;
                    $items[] = ['merch' => $merch, 'qty' => $qty, 'subtotal' => $subtotal];
                    $total += $subtotal;
                }
            }
        }
    }


    if (empty($items)) {
        return redirect()->route('user.shop.index')->with('error', 'Produk tidak valid.');
    }

    // ... sisa kode DB::transaction tetap sama

        $artistName = optional($items[0]['merch']->artist)->name ?? '-';

        DB::transaction(function () use ($request, $items, $total, $artistName, $selectedIds, $mode) {
            $user = Auth::user();

            $order = Order::create([
                'no_pesanan'        => 'ORD-' . now()->format('YmdHis') . '-' . $user->id,
                'pelanggan'         => $user->name,
                'email'             => $user->email,
                'artis'             => $artistName,
                'total'             => $total,
                'status'            => 'pending',
                'alamat_lengkap'    => $request->alamat_lengkap,
                'kota'              => $request->kota,
                'kode_pos'          => $request->kode_pos,
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            foreach ($items as $item) {
                $merch = $item['merch'];

                OrderItem::create([
                    'order_id'     => $order->id,
                    'merch_id'     => $merch->id, // 🔥 improvement
                    'nama_produk'  => $merch->nama,
                    'gambar'       => $merch->foto,
                    'qty'          => $item['qty'],
                    'harga_satuan' => $merch->harga,
                    'subtotal'     => $item['subtotal'],
                ]);

                $merch->decrement('stok', $item['qty']);

                if ($merch->fresh()->stok <= 0) {
                    $merch->update(['status' => 'stok_habis']);
                }
            }

            // hapus item yang sudah di checkout dari cart
            $currentCart = session()->get('cart', []);

            if ($mode !== 'buynow') {
                foreach ($selectedIds as $id) {
                    unset($currentCart[$id]);
                }
            }  

            session()->put('cart', $currentCart);
            session()->forget('checkout_selected_ids');
            session()->forget('checkout_mode'); // 🔥 bersihkan mode checkout
            session()->forget('buynow'); // 🔥 bersihkan data buynow
        });

        return redirect()->route('user.shop.index')
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Batalkan pesanan
     */
    public function cancel($id)
    {
        $order = Order::where('email', Auth::user()->email)
            ->where('status', 'pending')
            ->findOrFail($id);

        DB::transaction(function () use ($order) {

            $order->update(['status' => 'dibatalkan']);

            foreach ($order->items as $item) {

                // 🔥 pakai merch_id (lebih aman)
                $merch = Merch::find($item->merch_id);

                if ($merch) {
                    $merch->increment('stok', $item->qty);

                    if ($merch->status === 'stok_habis') {
                        $merch->update(['status' => 'ready']);
                    }
                }
            }
        });

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
    public function buyNow(Request $request)
    {
        $request->validate([
            'merch_id' => 'required|exists:merches,id',
            'qty'      => 'required|integer|min:1',
        ]);

        session()->put('buynow', [
            'merch_id' => $request->merch_id,
            'qty'      => $request->qty,
        ]);

        session()->put('checkout_mode', 'buynow');

        return redirect()->route('user.order.checkout');
    }
}