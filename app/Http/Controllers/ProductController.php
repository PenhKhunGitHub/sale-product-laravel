<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
class ProductController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('setup_product/v_product',compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'   => 'required|integer|exists:category,id',
            'product_name'  => 'required|string|max:255',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'unit_price'    => 'required|numeric|min:0',
            'sale_price'    => 'nullable|numeric|min:0|lt:unit_price',
        ]);

        $product = Product::create($data);

        return response()->json(
            [
                'data' => $product,
                'message' => 'Product created successfully',
                'status' => 200,
            ],
        200);
    }

    public function show()
    {
        $product = Product::query()
                    ->leftJoin('category', 'product.category_id', '=', 'category.id')
                    ->select('product.*', 'category.category_name as category_name');

    return DataTables::of($product)
        ->addColumn('action', function ($row) {
            $action = '<a href="javascript:void(0)" onclick="editProduct(' . $row->id . ')" data-bs-toggle="modal" data-bs-target="#productUpdateModal"><i class="fas fa-pencil-alt"></i></a>';
            $action .= '&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="deleteProduct(' . $row->id . ')"><i class="fas fa-trash-alt red-icon"></i></a>';
            return $action;
        })
        ->addColumn('category_name', function ($row) {
            return $row->category_name; // Access the joined column
        })
        ->rawColumns(['action'])
        ->make(true);

    }

    public function edit(string $id)
    {
        $Product = Product::find($id);

        if (!$Product) {
            return response()->json([
                'message' => 'Product not found',
                'error' => 'No query results for model [App\\Models\\Product] with id ' . $id
            ], 404);
        }
        return response()->json(
            [
                'data' => $Product,
                'status' => 200
            ]
        );

    }
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'category_id'   => 'required|integer|exists:category,id',
            'product_name'  => 'required|string|max:255',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'unit_price'    => 'required|numeric|min:0',
            'sale_price'    => 'nullable|numeric|min:0|lt:unit_price',
        ]);

        $Product = Product::findOrFail($id);
        $Product->update($data);
        return response()->json([
            'status' => 200,
            'message' => 'Product updated successfully',
        ]);

    }

    public function destroy($id)
    {
        $product_id = Product::find($id);

        if ($product_id) {
            $product_id->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Product deleted successfully!',
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'Product not found!',
        ]);
    }
}
