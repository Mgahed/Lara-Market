<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Debt;
use App\Models\Order;
use App\Models\PendingOrder;
use App\Models\Product;
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
            $product = Product::with('productsize')->find($item->product_id);
            $current_quantity = $product->quantity - $item->quantity;
            $product->update([
                'quantity' => $current_quantity
            ]);

            /*----------Quantity Update----------*/
            if ($product->size === 'm') {
                $product->update([//update current product(medium)
                    'quantity' => $current_quantity
                ]);
                Product::where('barcode', $product->productsize->barcode_s)
                    ->update([//update small product
                        'quantity' => $product->productsize->quantity_s * ($current_quantity) / $product->productsize->quantity_m
                    ]);
                Product::where('barcode', $product->productsize->barcode_l)
                    ->update([//update large product
                        'quantity' => $product->productsize->quantity_l * ($current_quantity) / $product->productsize->quantity_m
                    ]);
                /*--------------*/
            } elseif ($product->size === 'l') {
                $product->update([//update current product(large)
                    'quantity' => $current_quantity
                ]);
                Product::where('barcode', $product->productsize->barcode_s)
                    ->update([//update small product
                        'quantity' => $product->productsize->quantity_s * ($current_quantity) / $product->productsize->quantity_l
                    ]);
                Product::where('barcode', $product->productsize->barcode_m)
                    ->update([//update medium product
                        'quantity' => $product->productsize->quantity_m * ($current_quantity) / $product->productsize->quantity_l
                    ]);
                /*--------------*/
            } else {
                $product->update([//update current product(small)
                    'quantity' => $current_quantity
                ]);
                Product::where('barcode', $product->productsize->barcode_m)
                    ->update([//update medium product
                        'quantity' => $product->productsize->quantity_m * ($current_quantity) / $product->productsize->quantity_s
                    ]);
                Product::where('barcode', $product->productsize->barcode_l)
                    ->update([//update large product
                        'quantity' => $product->productsize->quantity_l * ($current_quantity) / $product->productsize->quantity_s
                    ]);
            }
            /*----------End Quantity Update----------*/

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

        $message = 'تم تسجيل الطلب';
        if ($request->payed >= $request->sum) {
            $message = 'تم تسجيل الطلب و متبقي للعميل مبغ ' . '<b>' . ($request->payed - $request->sum) . '</b>' . ' جنيه';
        } else {
            /*----------Debt----------*/
            Debt::create([
                'cost' => $request->sum - $request->payed,
                'customer_id' => $customer->id,
                'order_number' => $request->order_id
            ]);
            /*----------Debt----------*/
            $message = 'تم تسجيل الطلب و تسجيل مديونية على العميل ' . '<b>' . $request->customer_name . '</b>' . ' بمبلغ ' . '<b>' . ($request->sum - $request->payed) . '</b>' . ' جنيه';
        }
        $final_order = Order::with('user', 'customer', 'product')->where('order_number', $request->order_id)->get();
        return view('orders.final-order', compact('final_order'))->with('message', $message);
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
