<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function add_quantity(Request $request)
    {
        $rules = [
            'quantity2' => 'required|numeric|min:0'
        ];
        $customMSG = [
            'quantity2.required' => __('يجب ادخال الكمية'),
            'quantity2.numeric' => __('يجب ان يكون ارقام فقط'),
            'quantity2.min' => __('يجب ان يكون اكبر من 0')
        ];
        $validator = Validator::make($request->all(), $rules, $customMSG);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with(['fail' => 'اضغط على زر اضافة كمية لترى الخطأ']);
        }
        if ($request->quantity2 > 0) {

            $product = Product::with('productsize')->find($request->id2);
//            return $product;
            $current_quantity = $product->quantity + $request->quantity2;
            Expense::create([
                'expense_details' => 'اضافة كميه لمنتج',
                'cost' => $product->price_of_buy * $request->quantity2,
                'product_id' => $request->id2,
                'product_quantity' => $request->quantity2,
                'user_id' => auth()->user()->id
            ]);

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
            return redirect()->back()->with(['success' => 'تم اضافة الكمية']);
        }
        return redirect()->back()->with(['success' => 'لم يحدث تغيير']);
    }

    public function add_other(Request $request)
    {
        $rules = [
            'expense_details' => 'required',
            'cost' => 'required|numeric|min:0'
        ];
        $customMSG = [
            'expense_details.required' => __('يجب ادخال الكمية'),
            'cost.required' => __('يجب ادخال المبلغ'),
            'cost.numeric' => __('يجب ان يكون ارقام فقط'),
            'cost.min' => __('يجب ان يكون اكبر من 0')
        ];
        $validator = Validator::make($request->all(), $rules, $customMSG);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        Expense::create([
            'expense_details' => $request->expense_details,
            'cost' => $request->cost,
            'user_id' => auth()->user()->id
        ]);
        return redirect()->back()->with('success','تم اضافة المصروف');
    }
}
