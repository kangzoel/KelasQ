<?php

namespace App\Http\Controllers;

use App\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Klass;
use App\PaidBill;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $bills = Bill::select('bills.*')
            ->join('klasses', 'bills.klass_id', 'klasses.id')
            ->join('user_klass', 'bills.klass_id', 'user_klass.klass_id')
            ->where('user_klass.user_npm', $user->npm)
            ->get();
            
            return view('bills', ['bills' => $bills,
            'users' => $user
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show($klass_code)
    {
        $user = Auth::user();
        $klass = Klass::where('code', $klass_code)->first();

        if ($klass == NULL) abort(404);
        $bills = Bill::select('bills.*')
            ->join('klasses', 'bills.klass_id', 'klasses.id')
            ->join('user_klass', 'bills.klass_id', 'user_klass.klass_id')
            ->where('user_klass.user_npm', $user->npm)
            ->orderBy('id','desc')
            ->get();
        $paid_bills = PaidBill::select('paid_bills.*')
            ->join('bills','paid_bills.bill_id','bills.id')
            ->where('user_npm', $user->npm)
            ->get();
        return view('bills-show', ['bills' => $bills,
            'users' => $user, 'klass' => $klass, 'paid_bills'=> $paid_bills
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        //
    }
}
