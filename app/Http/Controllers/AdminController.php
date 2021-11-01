<?php

namespace App\Http\Controllers;

use App\Models\Order;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $arr = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = Order::select('sum')->whereYear('created_at', '=', now()->year)
                ->whereMonth('created_at', '=', $i)
                ->groupBy('order_number')->get();
            array_push($arr, $month->sum('sum'));
        }
        $monthly_sells = Order::select('sum')->whereMonth('created_at', '=', now()->month)
            ->groupBy('order_number')->get();
        $monthly_sells = $monthly_sells->sum('sum');

        $yearly_sells = Order::select('sum')->whereYear('created_at', '=', now()->year)
            ->groupBy('order_number')->get();
        $yearly_sells = $yearly_sells->sum('sum');

        return view('admin.dashboard', compact('arr', 'monthly_sells', 'yearly_sells'));
    }
}
