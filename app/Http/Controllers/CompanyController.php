<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    protected function getRules()
    {
        return [
            'name' => 'required',
            'number' => 'required|numeric',
//            'alternative_number' => 'numeric'
        ];
    }

    protected function getMSG()
    {
        return [
            'name.required' => __('يجب ادخال اسم الموزع'),
            'number.required' => __('يجب ادخال الرقم'),
            'number.numeric' => __('يجب ان يكون ارقام فقط'),
            'alternative_number.numeric' => __('يجب ان يكون ارقام فقط')
        ];
    }

    public function add_companies(Request $request)
    {
        $rules = $this->getRules();
        $customMSG = $this->getMSG();
        $validator = Validator::make($request->all(), $rules, $customMSG);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $add = Company::create($request->all());
        if ($add) {
            return redirect()->back()->with('success', 'تم اضافة الموزع');
        }
        return redirect()->back()->with('fail', 'خطأ! لم يتم اضافة الموزع');
    }

    public function all_companies()
    {
        $companies = Company::all();
        return view('companies.all', compact('companies'));
    }
}
