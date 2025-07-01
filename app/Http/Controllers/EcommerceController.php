<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EcommerceController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('welcome', compact('categories', 'products'));
    }

   public function createOrder(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $existingPendingOrder = Order::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->latest()
                ->first();

                if (!$existingPendingOrder) {
                    $order = Order::create([
                        'user_id' => Auth::id(),
                        'total_harga' => 0,
                        'status' => 'pending',
                    ]);
                } else {
                    $order = $existingPendingOrder;
                }

                $totalHarga = 0;
                if ($existingPendingOrder) {
                    $totalHarga = $existingPendingOrder->total_harga;
                }

                foreach ($request->items as $item) {
                    $product = Product::findOrFail($item['product_id']);
                    $subtotal = $product->harga * $item['quantity'];

                    $existingItem = OrderProduct::where('order_id', $order->id)
                        ->where('product_id', $product->id)
                        ->first();

                    if ($existingItem) {
                        $oldSubtotal = $existingItem->subtotal;
                        $newQuantity = $existingItem->quantity + $item['quantity'];
                        $newSubtotal = $product->harga * $newQuantity;

                        $existingItem->quantity = $newQuantity;
                        $existingItem->subtotal = $newSubtotal;
                        $existingItem->save();

                        $totalHarga = $totalHarga - $oldSubtotal + $newSubtotal;
                    } else {
                        OrderProduct::create([
                            'order_id' => $order->id, // le mineral jumlah 5,kopi 2, baygon 8
                            'product_id' => $product->id,
                            'quantity' => $item['quantity'],
                            'subtotal' => $subtotal,
                        ]);

                        $totalHarga += $subtotal;
                    }
                }

                $order->total_harga = $totalHarga;
                $order->save();
            });

            $productName = Product::findOrFail($request->items[0]['product_id'])->nama;
            $quantity = $request->items[0]['quantity'];
            return redirect()->route('home')->with('success', "$quantity x $productName Berhasil ditambahkan ke keranjang!");
        } catch (\Throwable $e) {
            return redirect()->route('home')->with('error', 'Error: ' . $e->getMessage());
        }
    }
     
    public function myOrder()
    {
     $orders = Order::with('orderProduct.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));   
    }
    
    public function orderDetail($id)
    {
       $order = Order::with(['orderProduct.product'])
        ->where('user_id',  Auth::id())
        ->findOrFail($id);

        return view('orders.detail', compact('order'));
    }

    public function updateQuantity(Request $request)
    {
        try {
            $request->validate([
                'order_product_id' => 'required|exists:order_products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            DB::transaction(function () use ($request) {
                $orderProduct = OrderProduct::findOrFail($request->order_product_id);
                $product = Product::findOrFail($orderProduct->product_id);
                $order = Order::findOrFail($orderProduct->order_id);

                if ($order->user_id !== Auth::id()) {
                    throw new \Exception('Akses Tidak Sah untuk pesanan ini.');
                }

                if ($order->status !== 'pending') {
                     throw new \Exception('Tidak dapat mengubah pesanan yang telah selesai.');
                }

                if ($request->quantity > $product->stok) {
                      throw new \Exception("Maaf, hanya tersedia {$product->stok} barang untuk {$product->nama}.");
                }

                $oldSubtotal = $orderProduct->subtotal;
                $newSubtotal = $product->harga * $request->quantity;

                $orderProduct->quantity = $request->quantity;
                $orderProduct->subtotal = $newSubtotal;
                $orderProduct->save();

                $order->total_harga = $order->total_harga - $oldSubtotal + $newSubtotal;
                $order->save();
            });

            return redirect()->back()->with('success', 'Jumlah produk berhasil di perbarui.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }

    public function checkOut(Request $request)
    {
        try{
            return DB::transaction(function () use ($request) {
                $order = Order::with('orderProduct.product')->findOrFail($request->order_id);

                if ($order->user_id !== Auth::id()) {
                    return redirect()->route('order.my')->with('error', 'Akses tidak sah untuk halaman ini.');
                }

                   if ($order->status === 'completed') {
                    return redirect()->route('orders.detail')->with('error', 'Pesanan ini sudah selesai.');
                }

                   if ($order->orderProduct->isEmpty()) {
                    return redirect()->route('order.my')->with('error', 'Tidak dapat melakukan chekout untuk pesanan kosong.');
                }

                $insufficientStock = [];

                foreach ($order->orderProduct as $item) {
                    $product = $item->product;
                    if ($product->stok < $item->quantity) {
                        $insufficientStock[] = "{$product->nama} (requested: {$item->quantity}, available: {$product->stok})";
                    }
                }

                if (!empty($insufficientStock)) {
                    $productList = implode(', ', $insufficientStock);
                    return redirect()->route('orders.detail', $order->id)->with('error', "Stok Tidak Mencukupi untuk: {$productList}");
                }

                foreach ($order->orderProduct as $item) {
                    $product = $item->product;
                    $product->stok -= $item->quantity;
                    $product->save();
                }

                $order->status = 'completed';
                $order->save();
                return redirect()->route('orders.detail', $order->id)->with('success', 'Pembayaran berhasil! Order anda sedang diproses');
            });
        } catch (\Exception $e) {
             return redirect()->route('orders.my')->with('error', 'Terjadi kesalahan saat checkout: ' . $e->getMessage());
        }
    }

  public function removeItem(Request $request)
{
    try {
        $request->validate([
            'order_product_id' => 'required|exists:order_products,id',
        ]);

        $orderDeleted = false;
        $message = '';

        DB::transaction(function () use ($request, &$orderDeleted, &$message) {
            $orderProduct = OrderProduct::findOrFail($request->order_product_id);
            $order = Order::findOrFail($orderProduct->order_id);
            $productName = Product::findOrFail($orderProduct->product_id)->nama;

            if ($order->user_id !== Auth::id()) {
                throw new \Exception('Akses tidak sah untuk pesanan ini.');
            }

            if ($order->status !== 'pending') {
                throw new \Exception('Tidak dapat mengubah pesanan yang sudah selesai.');
            }

            $orderId = $order->id;
            $order->total_harga -= $orderProduct->subtotal;
            $order->save();

            $orderProduct->delete();

            $remainingCount = OrderProduct::where('order_id', $orderId)->count();

            if ($remainingCount === 0) {
                $order->delete();
                $orderDeleted = true;
                $message = 'Pesanan dihapus karena tidak ada produk di dalamnya.';
            }
        });

        if ($orderDeleted) {
            return redirect()->route('orders.my')->with('info', $message);
        }
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari pesanan.');
    } catch (\Exception $e) {
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('orders.my')->with('error', $e->getMessage());
    }

}
}

