<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Expense;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $debts = Debt::with('customer')->get();
        foreach ($debts as $debt) {
            $id = $expenses->max('id');
            $debt_arr = [
                "id" => ++$id,
                "expense_details" => "مديونية على " . $debt->customer->name . " في الطلب رقم " . $debt->order_number,
                "product_id" => null,
                "product_quantity" => null,
                "cost" => $debt->cost,
                "user_id" => null,
                "created_at" => $debt->created_at,
                "updated_at" => $debt->updated_at,
                "user" => null,
                "product" => null
            ];
            $expenses->push($debt_arr);
        }
        return view('admin.generalReport', compact('orders', 'expenses'));
    }

    public function sells_report()
    {
        $orders = Order::with('user:id,name')->groupBy('order_number')->get();
        return view('admin.sellsReport', compact('orders'));
    }

    public function expenses_report()
    {
        $expenses = Expense::with('user:id,name')->with('product:id,name')->get();
        $debts = Debt::with('customer')->get();
        foreach ($debts as $debt) {
            $id = $expenses->max('id');
            $debt_arr = [
                "id" => ++$id,
                "expense_details" => "مديونية على " . $debt->customer->name . " في الطلب رقم " . $debt->order_number,
                "product_id" => null,
                "product_quantity" => null,
                "cost" => $debt->cost,
                "user_id" => null,
                "created_at" => $debt->created_at,
                "updated_at" => $debt->updated_at,
                "user" => null,
                "product" => null
            ];
            $expenses->push($debt_arr);
        }
        return view('admin.expensesReport', compact('expenses'));
    }

    public function pay_user()
    {
        $users = User::select('id', 'name')->where('role', '!=', 'admin')->get();
        return view('admin.payEmployee', compact('users'));
    }

    public function pay_user_post(Request $request)
    {
        $rules = [
            'name' => 'required',
            'price' => 'required|numeric|min:0',
        ];
        $customMSG = [
            'name.required' => 'يجب ان يكون هناك اسم',
            'price.required' => 'يجب ان يكون هناك مبلغ',
            'price.numeric' => 'يجب ان يكون ارقام فقط',
            'price.min' => 'يجب ان يكون اكبر من 0',
        ];
        $validator = Validator::make($request->all(), $rules, $customMSG);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        Expense::create([
            'expense_details' => "دفع راتب ل" . $request->name,
            'cost' => $request->price,
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->back()->with('success', 'تم تسجيل دفع الراتب ل' . $request->name);
    }
}
