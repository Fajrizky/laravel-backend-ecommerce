<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $show_product = $request->input('show_product');
        if($id)
        {
            $category = ProductCategory::with('products')->find($id);
            if($category) {
                return ResponseFormatter::success(
                    $category,
                    'Data Has Been Get By Id'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data No Found',
                    404
                );
            }
        }

        $category = ProductCategory::query();

        if($name) {
            $category->where('name', 'Like', '%'.$name.'%');
        }
        if($show_product) {
            $category->with('products');
        }

        return ResponseFormatter::success(
            $category->paginate($limit),
            'Product Data Get Successfully'
        );
    }
}
