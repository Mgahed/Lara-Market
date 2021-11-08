<?php

namespace App\Http\Controllers;

use App\Models\Expense;
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
            $month_sell = Order::select('sum')->whereYear('created_at', '=', now()->year)
                ->whereMonth('created_at', '=', $i)
                ->groupBy('order_number')->get();

            $month_expense = Expense::select('cost')->whereYear('created_at', '=', now()->year)
                ->whereMonth('created_at', '=', $i);

            array_push($arr, $month_sell->sum('sum') - $month_expense->sum('cost'));
        }
        /*------------For sells------------*/
        $monthly_sells = Order::select('sum')->whereMonth('created_at', '=', now()->month)
            ->groupBy('order_number')->get();
        $monthly_sells = $monthly_sells->sum('sum');

        $yearly_sells = Order::select('sum')->whereYear('created_at', '=', now()->year)
            ->groupBy('order_number')->get();
        $yearly_sells = $yearly_sells->sum('sum');

        /*------------For expenses------------*/
        $monthly_expense = Expense::select('cost')->whereMonth('created_at', '=', now()->month)->get();
        $monthly_expense = $monthly_expense->sum('cost');

        $yearly_expense = Expense::select('cost')->whereYear('created_at', '=', now()->year)->get();
        $yearly_expense = $yearly_expense->sum('cost');

        return view('admin.dashboard', compact('arr', 'monthly_sells', 'yearly_sells', 'monthly_expense', 'yearly_expense'));
    }

    public function general_report()
    {
        $orders = Order::with('user:id,name')->groupBy('order_number')->get();
        $expenses = Expense::with('user:id,name')->with('product:id,name')->get();
//        return $expenses;
        return view('admin.generalReport', compact('orders','expenses'));
    }
}
