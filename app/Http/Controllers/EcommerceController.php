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
        $products = Product::latest()->get();
        return view('welcome', compact('categories', 'products'));
    }

    public function createOrder(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $pendingOrder = Order::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->latest()
                ->first();

                if (!$pendingOrder) {
                    $order = Order::create([
                        'user_id' => Auth::id(),
                        'total_harga' => 0,
                        'status' => 'pending',
                    ]);
                } else {
                    $order = $pendingOrder;
                }

                $totalHarga = 0;

                if($pendingOrder) {
                    $totalHarga = $pendingOrder->$totalHarga;
                }
                foreach ($request->items as $item) {
                    $product = Product::findOrFail($item['product_id']);
                    $subtotal = $product->harga * $item['quantity'];

                    $existingItem = OrderProduct::where('order_id', $order->id)
                    ->where('product_id', $product->id)
                    ->first();

                    if ($existingItem) {
                        $newQuantity = $existingItem->quantity + $item['quantity'];
                        $newSubtotal = $product->harga * $newQuantity;

                        $existingItem->quantity = $newQuantity;
                        $existingItem->subtotal = $newSubtotal;
                        $existingItem->save();

                        $totalHarga = $totalHarga - $existingItem->subtotal + $newSubtotal;
                    } else {
                        
                    }
                }
            });
        }  catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error: '. $e->getMessage());
        }
    }
     
    public function myOrders()
    {

    }
    
    public function orderDetail($id)
    {

    }

    public function updateQuantity(Request $request)
    {

    }

    public function checkOut(Request $request)
    {

    }

    public function removeItem(Request $request)
    {

    }
}
