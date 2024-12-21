<?php

namespace App\Http\Controllers\Admin\Grocery;

use Throwable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\{AdminProduct, Admin};
use App\Traits\{TemplateTraits, QueryTraits};

class ProductController extends Controller {
    use TemplateTraits,  QueryTraits;
    // public function productList(Request $request) {
        //     try {
        //         $type = $request->get('type');
        //         $filterValue = $request->get('filterValue');

        //         $products = collect();

        //         if ($type === "admin") {
        //             $products = AdminProduct::where('status', 1)->with(['getProductGallery', 'getProductAttribute', 'getCategory'])->get();

        //         } elseif ($type === "vendor") {
        //             $products = VendorProduct::where('status', 1)->with(['getProductGallery', 'getProductAttribute', 'getCategory'])->get();

        //         } elseif ($type === "yearly" && $filterValue) {
        //             $year = $filterValue;
        //             $products = Product::where('status', 1)->whereYear('created_at', $year)->with(['getProductGallery', 'getProductAttribute', 'getCategory'])->get();

        //         } elseif ($type === "monthly" && $filterValue) {
        //             $month = date('m', strtotime($filterValue));
        //             $products = Product::where('status', 1)->whereMonth('created_at', $month)->with(['getProductGallery', 'getProductAttribute', 'getCategory'])->get();
        //         }

        //         $html = view('admin.grocery.products.product-list', compact('products'))->render();

        //         return response()->json([
        //             'status' => true,
        //             'html' => $html,
        //         ]);

        //     } catch (Throwable $th) {
        //         return response()->json([
        //             'status' => false,
        //             'error' => $th->getMessage(),
        //             'line' => $th->getLine(),
        //         ]);
        //     }
    // }

    
    public function productList(Request $request) {
        try {
            $products = $this->adminProductTraits();

            $admin = $this->adminGroceryHeading();

            return view('admin.grocery.products.product-list', [
                'products' => $products,
                'admin' => $admin
            ]);

        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage(),
                'line' => $th->getLine(),
            ]);
        }
    }


}
