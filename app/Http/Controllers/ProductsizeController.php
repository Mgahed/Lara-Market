<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductsizeController extends Controller
{
    public function add_m(Request $request)
    {
        //add to product size
        $product_size = ProductSize::where('barcode_s', $request->barcodes);
        $product_size->update([
            'barcode_m' => $request->barcodem,
            'quantity_s' => $request->quantity,
            'quantity_m' => 1
        ]);

        //get medium product quantity and update small one
        $s_product = Product::where('barcode', $request->barcodem);
        $final_product_s_quantity = $s_product->first()->quantity * $request->quantity;
        $update_product_s = Product::where('barcode', $request->barcodes)->update([
            'quantity' => $final_product_s_quantity
        ]);

        //update foreign key
        $s_product->update([
            'product_size_id' => $product_size->first()->id
        ]);

        if ($product_size && $update_product_s) {
            return redirect()->back()->with('success2', 'تم ربط العلبة بالفرط');
        }
        return redirect()->back()->with('fail2', 'حدث خطأ');
    }

    public function add_l(Request $request)
    {
        //add to product size
        $product_size = ProductSize::where('barcode_m', $request->barcodem);
        $product_size->update([
            'barcode_l' => $request->barcodel,
            'quantity_m' => $request->quantity,
            'quantity_l' => 1
        ]);

        //get large product quantity and update medium one
        $m_product = Product::where('barcode', $request->barcodel);
        $final_product_m_quantity = $m_product->first()->quantity * $request->quantity;
        $update_product_m = Product::where('barcode', $request->barcodem)->update([
            'quantity' => $final_product_m_quantity
        ]);

        //get medium product quantity and update small one
        $final_product_s_quantity = $m_product->first()->quantity * $product_size->first()->quantity_s;
        $update_product_s = Product::where('barcode', $product_size->first()->barcode_s)->update([
            'quantity' => $final_product_s_quantity
        ]);

        //update foreign key
        $m_product->update([
            'product_size_id' => $product_size->first()->id
        ]);

        if ($product_size && $update_product_m && $update_product_s) {
            return redirect()->back()->with('success2', 'تم ربط العلبة بالفرط');
        }
        return redirect()->back()->with('fail2', 'حدث خطأ');
    }
}
