<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Merch;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserShopController extends Controller
{
    public function index(Request $request)
    {
        // Data keranjang dari session
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

        // Data pesanan user
        $orders = Order::with('items')
            ->where('email', Auth::user()->email)
            ->latest()
            ->paginate(10);

        // Data artis untuk sidebar
        $artists = Artist::orderBy('name')->get();

        return view('user.shop.index', compact('cartItems', 'total', 'orders', 'artists'));
    }
}