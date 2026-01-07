<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        return view('setup_product/v_order');
    }

    public function store(Request $request)
    {
        $data = $request->validate( [
            'user_id' => 'required|integer',
            'order_id' => 'required|integer',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
            'address' => 'required|string',
            'counpon' => 'required|string',
            'status' => 'required|string',
        ]);
        $order = Order::create($data);
        return response()->json([
            'data' => $order,
            'message' => 'Order has been save.',
            'status' => 200
        ]);
    }

    public function show()
    {
        $order = Order::query();
        return DataTables::of($order)
            ->addColumn('action', function ($row) {
            $action = '<a href="javascript:void(0)" onclick="editProduct(' . $row->id . ')" data-bs-toggle="modal" data-bs-target="#productUpdateModal"><i class="fas fa-pencil-alt"></i></a>';
            $action .= '&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="deleteProduct(' . $row->id . ')"><i class="fas fa-trash-alt red-icon"></i></a>';
            return $action;
            })
            ->addColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('Y-m-d');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
