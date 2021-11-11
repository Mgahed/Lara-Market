<?php

namespace App\Http\Controllers;

use App\Models\Debt;

class DebtController extends Controller
{
    public function all_debts()
    {
        $debts = Debt::with('customer:id,name')->get();
        return view('debts.all', compact('debts'));
    }

    public function pay_debt($id)
    {
        $debt = Debt::find($id)->delete();
        if ($debt) {
            return redirect()->back()->with('success','تم تسديد الدين');
        }
        return redirect()->back()->with('fail','خطأ حاول مرة اخرى');
    }
}
