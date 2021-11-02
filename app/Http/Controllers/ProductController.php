<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    protected function getRules()
    {
        return [
            'name' => 'required',
            'barcode' => 'required|unique:products|numeric',
            'category' => 'required',
//            'quantity' => 'required',
            'price_of_buy' => 'required',
            'price_of_sell' => 'required',
            'size' => 'required',
        ];
    }

    protected function getMSG()
    {
        return [
            'name.required' => __('يجب ادخال اسم المنتج'),
            'barcode.required' => __('يجب ادخال الباركود'),
            'barcode.unique' => __('هذا الباركود مۥسجل'),
            'barcode.numeric' => __('يجب ان يكون ارقام فقط'),
            'category.required' => __('يجب ادخال التصنيف'),
//            'quantity.required' => __('يجب ادخال الكمية'),
            'price_of_buy.required' => __('يجب ادخال سعر الشرلء'),
            'price_of_sell.required' => __('يجب ادخال سعر البيع'),
            'size.required' => __('يجب ادخال قيمه'),
        ];
    }


    public function all()
    {
        $products = Product::all();
        return view('products.getAll', compact('products'));
    }

    public function add_view()
    {
        $products = Product::select('category')->distinct()->get();
        return view('products.add', compact('products'));
    }

    public function add(Request $request)
    {
        $rules = $this->getRules();
        $customMSG = $this->getMSG();
        $validator = Validator::make($request->all(), $rules, $customMSG);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        if ($request->size === 's') {
            $add_product_size = ProductSize::create([
                'barcode_s' => $request->barcode,
                'quantity_s' => 1
            ]);
            $add_product = Product::create([
                'name' => $request->name,
                'barcode' => $request->barcode,
                'category' => $request->category,
                'quantity' => $request->quantity,
                'price_of_buy' => $request->price_of_buy,
                'price_of_sell' => $request->price_of_sell,
                'size' => $request->size,
                'product_size_id' => $add_product_size->id
            ]);
        } else {
            $add_product = Product::create([
                'name' => $request->name,
                'barcode' => $request->barcode,
                'category' => $request->category,
                'quantity' => $request->quantity,
                'price_of_buy' => $request->price_of_buy,
                'price_of_sell' => $request->price_of_sell,
                'size' => $request->size,
                'product_size_id' => 999999999
            ]);
        }
        $products = Product::select('category')->distinct()->get();
        if ($add_product) {
            return redirect()->back()->with('products', $products)->with('success1', 'تم اضافة المنتج')->withInput($request->all());
        }
        return redirect()->back()->with('products', $products)->with('fail1', 'حدث خطأ تأكد من جميع الحقول')->withInput($request->all());
    }

    public function delete_view()
    {
        return "delete";
    }

    public function edit_view(Request $request)
    {
        $product = Product::find($request->id);
        if ($product) {
            return $product;
        }
        return response()->json([
            'error' => 'يوجد خطأ حاول مرة اخرى'
        ]);
    }

    public function edit(Request $request)
    {
        $product = Product::with('productsize')->find($request->id);
        if ($product->size === 's') {
            $s_quantity = $request->quantity;
            $m_quantity = $request->quantity * $product->productsize->quantity_m / $product->productsize->quantity_s;
            $l_quantity = $request->quantity * $product->productsize->quantity_l / $product->productsize->quantity_s;
        } elseif ($product->size === 'm') {
            $s_quantity = $request->quantity * $product->productsize->quantity_s / $product->productsize->quantity_m;
            $m_quantity = $request->quantity;
            $l_quantity = $request->quantity * $product->productsize->quantity_l / $product->productsize->quantity_m;
        } else {
            $s_quantity = $request->quantity * $product->productsize->quantity_s;
            $m_quantity = $request->quantity * $product->productsize->quantity_m;
            $l_quantity = $request->quantity;
        }
        $update_current = $product->update([
            "name" => $request->name,
            "price_of_buy" => $request->price_of_buy,
            "price_of_sell" => $request->price_of_sell
        ]);
        $update_s = Product::where('barcode', $product->productsize->barcode_s)->update([
            "quantity" => $s_quantity
        ]);
        $update_m = Product::where('barcode', $product->productsize->barcode_m)->update([
            "quantity" => $m_quantity
        ]);
        $update_l = Product::where('barcode', $product->productsize->barcode_l)->update([
            "quantity" => $l_quantity
        ]);

        $products = Product::all();
        if ($update_current && ($update_s || $update_m || $update_l)) {
            return redirect()->back()->with('products', $products)->with('success', 'تم تعديل المنتج');
        }
        return redirect()->back()->with('products', $products)->with('fail', 'خطأ في تعديل المنتج');
    }
}