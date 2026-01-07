<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class CategoryController extends Controller
{

    public function index()
    {
        return view('setup_product/v_category');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'required',
        ]);

        $category = Category::create($data);

        return response()->json(
            [
                'data' => $category,
                'message' => 'Category created successfully',
                'status' => 200,
            ],
        200);
    }

    public function show()
    {
        $categories = Category::query();

    return DataTables::of($categories)
        ->addColumn('created_at', function ($row) {
            return Carbon::parse($row->created_at)->format('Y-m-d');
        })
        ->addColumn('action', function ($row) {
            $action = '<a href="javascript:void(0)" onclick="editCategory(' . $row->id . ')" data-bs-toggle="modal" data-bs-target="#categoryUpdateModal"><i class="fas fa-pencil-alt"></i></a>';
            $action .= '&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="deleteCategory(' . $row->id . ')"><i class="fas fa-trash-alt red-icon"></i></a>';
            return $action;
        })
        ->rawColumns(['action'])
        ->make(true);

    }

    public function edit(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
                'error' => 'No query results for model [App\\Models\\Category] with id ' . $id
            ], 404);
        }
        return response()->json(
            [
                'data' => $category,
                'status' => 200
            ]
        );

    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'category_name' => $request->category_name,
            'description' => $request->description,
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Category updated successfully',
        ]);

    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Category deleted successfully!',
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'Category not found!',
        ]);
    }
}
