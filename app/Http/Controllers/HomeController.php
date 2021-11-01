<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\PendingOrder;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application admin.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pending_orders = [];
        $number_of_pending_orders = PendingOrder::select('order_number')->distinct()->get();
        foreach ($number_of_pending_orders as $item) {
            $pending_order = PendingOrder::with('product')->where('order_number', $item->order_number)->get();
            array_push($pending_orders, $pending_order);
        }

        $first_order_number = PendingOrder::select('order_number')->first();
        $first_order = [];
        if ($first_order_number) {
            $first_order = PendingOrder::with('product')->where('order_number', $first_order_number->order_number)->get();
        }
        $customers = Customer::select('name')->get();
        return view('home', compact('pending_orders', 'first_order', 'customers'));
    }

    public function sell_new()
    {
        $pending_orders = [];
        $number_of_pending_orders = PendingOrder::select('order_number')->distinct()->get();
        foreach ($number_of_pending_orders as $item) {
            $pending_order = PendingOrder::with('product')->where('order_number', $item->order_number)->get();
            array_push($pending_orders, $pending_order);
        }

        $first_order = 0;

        $customers = Customer::select('name')->get();
        return view('home', compact('pending_orders', 'first_order', 'customers'));
    }

    public function sell_old($order_id)
    {
        $pending_orders = [];
        $number_of_pending_orders = PendingOrder::select('order_number')->distinct()->get();
        foreach ($number_of_pending_orders as $item) {
            $pending_order = PendingOrder::with('product')->where('order_number', $item->order_number)->get();
            array_push($pending_orders, $pending_order);
        }
        $first_order = PendingOrder::where('order_number', $order_id)->get();
        if (!count($first_order)) {
            return redirect()->route('home');
        }

        $customers = Customer::select('name')->get();
        return view('home', compact('pending_orders', 'first_order', 'customers'));
    }

    public function remove(Request $request)
    {
        $find_product = Product::where('barcode', $request->barcode2)->first();
        if (!$find_product) {
            return redirect()->back()->with('fail', 'لا يوجد منتج بهذا الباركود');
        }
        $current_product = PendingOrder::where([['order_number', '=', $request->order_id], ['product_id', '=', $find_product->id]])->first();
        if (!$current_product) {
            return redirect()->back()->with('fail', 'الطلب لا يحتوي على هذا المنتج');
        }
//        return $current_product;
        if ($request->quantity >= $current_product->quantity) {
            $current_product->delete();
        } else {
            $current_product->update([
                'quantity' => $current_product->quantity - $request->quantity
            ]);
        }
        return redirect()->route('sell.old.products', $request->order_id);
    }

    public function delete($order_id)
    {
        $result = PendingOrder::where('order_number', $order_id)->delete();
//        if ($result) {
        return redirect()->route('home');
//        }
    }

    public function sell(Request $request)
    {
        $find_product = Product::where('barcode', $request->barcode)->first();
        if (!$find_product) {
            return response()->json([
                'fail' => 'لا يوجد منتج بهذا الباركود'
            ]);
        }
        $total_product_quantity = PendingOrder::where('product_id', $find_product->id)->sum('quantity') + $request->quantity;
        if ($total_product_quantity > $find_product->quantity) {
            return response()->json([
                'fail' => 'لا يوجد كميه كافيه لهذا المنتج'
            ]);
        }

        $order_number = $request->order_id;
        if ($request->order_id === 'none') {
            $max_order_number = PendingOrder::max('order_number');
            $max_order = Order::max('order_number');
            if ($max_order && ($max_order > $max_order_number)) {
                $max_order_number = $max_order;
            }
            if (!$max_order_number) { //lw order gdeed//
                $max_order_number = 1;
            } else {
                $max_order_number++;
            }
            $order_number = $max_order_number;
        }
        $current_product = PendingOrder::where([['order_number', '=', $request->order_id], ['product_id', '=', $find_product->id]])->first();

        if ($current_product) {
            PendingOrder::where('id', $current_product->id)->update([
                'quantity' => $request->quantity + $current_product->quantity,
            ]);
        } else {
            PendingOrder::create([
                'user_id' => \Auth::user()->id,
                'product_id' => $find_product->id,
                'quantity' => $request->quantity,
                'order_number' => $order_number
            ]);
        }

        ///////////////////////////////
        /// /////////////////////////////
        $sum = 0.0;
        if ($order_number) {
            $current_order = PendingOrder::where('order_number', $order_number)->get();
            $ndhtml = '';
            foreach ($current_order as $order) {
                $ndhtml .= '<div class="d-flex"><span>' . $order->quantity . '.x' . $order->product->name . '</span><div class="ml-auto">' . $order->product->price_of_sell * $order->quantity . '</div></div><hr style="margin-bottom: 0; border-color: rgba(0, 0, 0, .3);">';
                $sum += $order->product->price_of_sell * $order->quantity;
            }
            $ndhtml .= '<div class="d-flex mt-2"><span>المجموع</span><div class="ml-auto">' . $sum . '</div></div>';
            return response()->json([
                'order_number' => $order_number,
                'ndhtml' => $ndhtml
            ]);
        }
        ///////////////////////////////
        /// /////////////////////////////
        return response()->json([
            'order_number' => $order_number
        ]);
    }
}
