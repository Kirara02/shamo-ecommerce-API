<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\API\TransactionController;

class ProductCategoryController extends Controller
{
    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $show_product = $request->input('show_product');

        if($id){
            $kategory = ProductCategory::with(['products'])->find($id);

            if($kategory){
                return ResponseFormatter::success(
                    $kategory,
                    'Data kategory berhasil diambil'
                );
            }
            else {
                return ResponseFormatter::error(
                    null,
                    'Data kategory tidak ada',
                    404
                );
            }

        }
        $kategory = ProductCategory::query();
    
        if($name){
            $kategory->where('name', 'like', '%'.$name.'%');
        }

        if($show_product){
            $kategory->with('products');
        }
        
        return ResponseFormatter::success(
            $kategory->paginate($limit),
            'Data list kategori berhasil diambil'
        );
    }
}
