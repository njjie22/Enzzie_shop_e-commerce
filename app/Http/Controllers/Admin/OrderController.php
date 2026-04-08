<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.order', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $order->load('items');

        return response()->json([
            'id'                => $order->id,
            'no_pesanan'        => $order->no_pesanan,
            'pelanggan'         => $order->pelanggan,
            'email'             => $order->email,
            'artis'             => $order->artis,
            'total'             => $order->total_rupiah,
            'status'            => $order->status,
            'status_label'      => $order->status_label,
            'metode_pembayaran' => $order->metode_pembayaran,
            'tanggal'           => $order->created_at->format('Y-m-d H:i'),
            'alamat_lengkap'    => $order->alamat_lengkap,
            'kota'              => $order->kota,
            'kode_pos'          => $order->kode_pos,
            'items'             => $order->items->map(fn($item) => [
                'nama'   => $item->nama_produk,
                'gambar' => $item->gambar ? asset('storage/' . $item->gambar) : null,
                'qty'    => $item->qty,
                'harga'  => $item->harga_rupiah,
            ]),
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,dikemas,dikirim,selesai']);
        Order::findOrFail($id)->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }
}