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

    /**
     * Riwayat pesanan user
     */
    public function index()
    {
        $orders = Order::with('items')
            ->where('email', Auth::user()->email)
            ->latest()
            ->paginate(10);

        return view('user.order.index', compact('orders'));
    }

    /**
     * Detail pesanan
     */
    public function show($id)
    {
        $order = Order::with('items')
            ->where('email', Auth::user()->email)
            ->findOrFail($id);

        return view('user.order.show', compact('order'));
    }

    /**
     * Halaman checkout — ambil dari session cart
     */
    public function checkout()
    {
        $cart      = session()->get('cart', []);
        $cartItems = [];
        $total     = 0;

        foreach ($cart as $id => $item) {
            $merch = Merch::with('artist')->find($id);
            if ($merch) {
                $subtotal    = $merch->harga * $item['qty'];
                $total      += $subtotal;
                $cartItems[] = [
                    'merch'    => $merch,
                    'qty'      => $item['qty'],
                    'subtotal' => $subtotal,
                ];
            }
        }

        if (empty($cartItems)) {
            return redirect()->route('user.shop.index')
                ->with('error', 'Keranjang kosong.');
        }

        return view('user.order.checkout', compact('cartItems', 'total'));
    }

    /**
     * Simpan pesanan
     */
    public function store(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string',
        ]);

        $cart      = session()->get('cart', []);
        $cartItems = [];
        $total     = 0;

        foreach ($cart as $id => $item) {
            $merch = Merch::find($id);
            if ($merch) {
                $subtotal    = $merch->harga * $item['qty'];
                $total      += $subtotal;
                $cartItems[] = [
                    'merch' => $merch,
                    'qty'   => $item['qty'],
                ];
            }
        }

        if (empty($cartItems)) {
            return redirect()->route('user.shop.index')
                ->with('error', 'Keranjang kosong.');
        }

        // Ambil nama artis dari item pertama
        $artistName = optional($cartItems[0]['merch']->artist)->name ?? '-';

        DB::transaction(function () use ($request, $cartItems, $total, $artistName) {
            $user = Auth::user();

            $order = Order::create([
                'no_pesanan'        => 'ORD-' . now()->format('YmdHis') . '-' . $user->id,
                'pelanggan'         => $user->name,
                'email'             => $user->email,
                'artis'             => $artistName,
                'total'             => $total,
                'status'            => 'pending',
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            foreach ($cartItems as $item) {
                $merch = $item['merch'];

                OrderItem::create([
                    'order_id'     => $order->id,
                    'nama_produk'  => $merch->nama,
                    'gambar'       => $merch->foto,
                    'qty'          => $item['qty'],
                    'harga_satuan' => $merch->harga,
                ]);

                // Kurangi stok
                $merch->decrement('stok', $item['qty']);

                // Update status kalau stok habis
                if ($merch->fresh()->stok <= 0) {
                    $merch->update(['status' => 'stok_habis']);
                }
            }

            // Kosongkan cart setelah order
            session()->forget('cart');
        });

        return redirect()->route('user.shop.index')
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Batalkan pesanan (hanya status pending)
     */
    public function cancel($id)
    {
        $order = Order::where('email', Auth::user()->email)
            ->where('status', 'pending')
            ->findOrFail($id);

        $order->update(['status' => 'dibatalkan']);

        // Kembalikan stok
        foreach ($order->items as $item) {
            $merch = Merch::where('nama', $item->nama_produk)->first();
            if ($merch) {
                $merch->increment('stok', $item->qty);
                if ($merch->status === 'stok_habis') {
                    $merch->update(['status' => 'ready']);
                }
            }
        }

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}