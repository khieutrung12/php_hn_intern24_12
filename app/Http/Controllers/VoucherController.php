<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Voucher\StoreRequest;
use App\Http\Requests\Voucher\UpdateRequest;

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
            'code' => 200,
            'message' => __('messages.add-success'),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $voucher = Voucher::find($request->voucher_id);

        return response()->json([
            'voucher' => $voucher,
        ]);
    }

    public function update(UpdateRequest $request)
    {
        $voucher = Voucher::find($request->cid);
        if ($voucher->name == $request->name) {
            $code = $voucher->code;
        } else {
            $code = createCode($request->name);
        }

        $result = Voucher::where('id', $request->cid)
            ->update([
                'code' => $code,
                'name' => $request->name,
                'quantity' => $request->quantity,
                'value' => $request->value,
                'condition_min_price' => $request->condition_min_price,
                'maximum_reduction' => $request->maximum_reduction,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
        ]);

        return response()->json([
            'code' => 200,
            'message' => __('messages.edit-success'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $order = Order::where('voucher_id', $request->voucher_id)->first();

        if ($order == null) {
            $result = Voucher::find($request->voucher_id)->delete();

            if ($result) {
                return response()->json([
                    'code' => 200,
                    'message' => __('messages.delete-success'),
                ], 200);
            }
        }

        return response()->json([
            'code' => 403,
            'message' => __('messages.cant-delete'),
        ], 403);
    }

    public function deleteList(Request $request)
    {
        foreach ($request->voucher_id as $id) {
            if (Order::where('voucher_id', $id)->first() != null) {
                return response()->json([
                    'code' => 403,
                    'message' => __('messages.cant-delete'),
                ], 403);
            }
        }

        $result = Voucher::whereIn('id', $request->voucher_id)->delete();

        if ($result) {
            return response()->json([
                'code' => 200,
                'message' => __('messages.success-delete'),
            ], 200);
        }
    }

    public function walletVoucher()
    {
        $orders = Order::select('voucher_id')
            ->where('user_id', Auth()->user()->id)
            ->whereNotNull('voucher_id')->get();

        $array = [];
        foreach ($orders as $order) {
            array_push($array, $order->voucher_id);
        }

        $vouchers = Voucher::whereNotIn('id', $array)
            ->where([
                ['start_date', '<=', date('Y-m-d')],
                ['end_date', '>=', date('Y-m-d')],
                ['quantity', '>', 0],
            ])->get();

        return view('user.profile.voucher.index', [
            'vouchers' => $vouchers,
        ]);
    }

    public function useVoucher($code)
    {
        if (Session()->get('data')) {
            Session()->forget('code');
        }
        Session()->put('code', $code);

        return redirect()->route('shop');
    }

    public function showVoucher(Request $request)
    {
        $voucher = Voucher::where('code', $request->code)->first();

        return view('user.profile.voucher.show', [
            'voucher' => $voucher,
        ]);
    }
}
