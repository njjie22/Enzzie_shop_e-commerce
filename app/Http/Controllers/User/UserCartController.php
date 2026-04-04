<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Merch;
use Illuminate\Http\Request;

class UserCartController extends Controller
{
    /**
     * Tampilkan isi cart dari session
     */
    public function index()
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

        return view('user.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Tambah item ke cart (session-based)
     */
    public function add(Request $request)
    {
        $request->validate([
            'merch_id' => 'required|exists:merches,id',
            'qty'      => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        $id   = $request->merch_id;
        $qty  = $request->qty;

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
        } else {
            $cart[$id] = ['qty' => $qty];
        }

        session()->put('cart', $cart);

        // Jika dari tombol pembelian, redirect langsung ke checkout
        if ($request->redirect_checkout) {
            return redirect()->route('user.order.checkout');
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    /**
     * Update qty item di cart
     */
    public function update(Request $request, $id)
    {
        $request->validate(['qty' => 'required|integer|min:1|max:10']);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $request->qty;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    /**
     * Hapus item dari cart
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    /**
     * Kosongkan seluruh cart
     */
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan.');
    }
}