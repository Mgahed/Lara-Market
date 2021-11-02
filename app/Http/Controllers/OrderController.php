<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\PendingOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function final_order(Request $request)
    {
        $order = PendingOrder::with('product:id,price_of_sell')->where('order_number', $request->order_id)->get();
        if (!$order->count() || !$request->customer_name) {
            return redirect()->back()->with(['fail2' => 'لا يوجد طلب او لم يتم ادخال اسم العميل']);
        }

        $customer = Customer::where('name', $request->customer_name)->first();
        if (!$customer) {
            $customer = Customer::create([
                'name' => $request->customer_name,
            ]);
        }

        foreach ($order as $item) {
            Order::create([
                'order_number' => $request->order_id,
                'user_id' => $item->user_id,
                'customer_id' => $customer->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'sum' => $request->sum,
                'price' => $item->product->price_of_sell
            ]);
        }
        PendingOrder::where('order_number', $request->order_id)->delete();

        $final_order = Order::with('user', 'customer', 'product')->where('order_number', $request->order_id)->get();
        return view('orders.final-order', compact('final_order'));
    }

    public function all_orders()
    {
        $orders = Order::with('user', 'customer', 'product')->groupBy('order_number')->get();
        return view('orders.all-orders', compact('orders'));
    }

    public function order($order_number)
    {
        $final_order = Order::with('user', 'customer', 'product')->where('order_number', $order_number)->get();
        if (!$final_order->count()) {
            return redirect()->back()->with(['fail' => 'الطلب غير موجود']);
        }
        return view('orders.final-order', compact('final_order'));
    }
}
