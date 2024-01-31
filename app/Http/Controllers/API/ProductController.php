<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Product list with filter options
     */
    public function index(Request $request)
    {
        try {
            $query = Product::query();

                    if ($request->has('category')) {
                        $query->where('category_id', $request->category);
                    }
            
                    if ($request->has('min_price')) {
                        $query->where('price', '>=', $request->min_price);
                    }
            
                    if ($request->has('max_price')) {
                        $query->where('price', '<=', $request->max_price);
                    }

            $products = $query->get();

            return response()->json([
                'status' => config('constantapiresponse.success_status'),
                'message' => __('product list!'),
                'data' => $products ?? [],
            ], config('constantapiresponse.success_status_code'));
        } catch (\Throwable $th) {
            Log::error('--------something went wrong with product list index api ----------', [
                'Message' => $th->getMessage(),
                'Line' => $th->getLine(),
                'File' => $th->getFile(),
                'code' => $th->getCode(),
            ]);
        }
    }
}
