<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Voucher\StoreRequest;

class VoucherController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $vouchers = Voucher::all();

        return view('admin.voucher.index', [
            'vouchers' => $vouchers,
        ]);
    }

    public function fetch()
    {
        $vouchers = Voucher::all();

        return Datatables::of($vouchers)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return view('components.action_voucher', ['id' => $row['id']]);
            })
            ->addColumn('checkbox', function ($row) {
                return view('components.checkbox_voucher', ['id' => $row['id']]);
            })
            ->rawColumns(['actions', 'checkbox'])
            ->make(true);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $result = Voucher::insert([
            'code' => createCode($request->name),
            'name' => $request->name,
            'quantity' => $request->quantity,
            'value' => $request->value,
            'condition_min_price' => $request->condition_min_price,
            'maximum_reduction' => $request->maximum_reduction,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        if (!$result) {
            return response()->json([
                'message' => __('messages.something-wrong'),
            ]);
        }

        return response()->json([
            'message' => __('messages.add-success'),
        ]);
    }
}
