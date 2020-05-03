<?php

namespace App\Http\Controllers;

use App\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Klass;
use App\PaidBill;
use App\Subject;
use App\UserKlass;
use App\User;
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
    public function create($klass_code)
    {
        $user=Auth::user();
        $klass = Klass::where('code', $klass_code)->first();

        if($user->cant('create_bill', [$klass, $user]))
            return redirect(route('bill.show',['klass_code'=>$klass_code]))->with('message', [
                'type' => 'danger',
                'content' => 'Anda bukan bendahara kelas ini.'
            ]);

        return view('bills-create',['users' => $user,
        'klass' => $klass]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($klass_id, Request $request)
    {
        $v = $request->validate([
            'name' => 'required',
            'subject_id' => 'exists:subjects,id',
            'subject_id' => '',
            'amount' => 'required'
        ]);

        $user = Auth::user();
        $klass = Klass::find($klass_id)->first();

        $bill = new Bill();
        $bill->klass_id = $klass_id;
        $bill->name = $v['name'];
        $bill->subject_id = $v['subject_id'];
        $bill->amount = $v['amount'];
        $bill->save();

        return redirect(route('bill.show', ['klass_code' => $klass->code]))->with('message', [
            'type' => 'success',
            'content' => 'Tagihan berhasil dibuat'
        ]);
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

        $bills = Bill::select('bills.*')
            ->join('klasses', 'bills.klass_id', 'klasses.id')
            ->join('user_klass', 'bills.klass_id', 'user_klass.klass_id')
            ->where('user_klass.user_npm', $user->npm)
            ->where('bills.klass_id', $klass->id)
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
     * Display the specified resource.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function info($bill_id)
    {
        $user = Auth::user();
        $bills = Bill::where('id', $bill_id)
            ->first();
        $klass = Klass::where('id', $bills->klass_id)->first();
        $paid_bills = PaidBill::select('paid_bills.*')
            ->where('bill_id', $bill_id)
            ->get();
        return view('bills-info',['bills' => $bills, 'paid_bills' => $paid_bills
        , 'klass' => $klass
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit($bill_id)
    {
        $user = Auth::user();
        $bills = Bill::where('id', $bill_id)
            ->first();
        $klass = Klass::where('id', $bills->klass_id)->first();
        $subject = Subject::where('id', $bills->subject_id)->first();

        return view('bills-edit',['bills'=>$bills, 'klass'=>$klass,
        'users'=>$user, 'subject'=>$subject
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $v = $request->validate([
            'name' => 'required',
            'subject_id' => 'exists:subjects,id',
            'subject_id' => '',
            'amount' => 'required'
        ]);

        $user = Auth::user();
        $bill = Bill::find($id);
        $klass = Klass::where('id',$bill->klass_id)->first();

        $bill->name = $v['name'];
        $bill->subject_id = $v['subject_id'];
        $bill->amount = $v['amount'];
        $bill->save();

        return redirect(route('bill.show', ['klass_code' => $klass->code]))->with('message', [
            'type' => 'success',
            'content' => 'Tagihan berhasil diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy($bill_id)
    {
        $user = Auth::user();
        $bill = Bill::find($bill_id);
        $klass = Klass::where('id',$bill->klass_id)->first();

        try {
            $bill->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect(route('bill.show', ['klass_code' => $klass->code]))
            ->with('message', [
                'type' => 'success',
                'content' => 'Tugas berhasil dihapus'
            ]);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paid($bill_id, $user_npm, Request $request)
    {
        $user = Auth::user();
        $paid_bill = new PaidBill();
        $paid_bill->bill_id = $bill_id;
        $paid_bill->user_npm = $user_npm;
        $paid_bill->save();

        return redirect(route('bill.info',['id' => $bill_id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function unpaid($paid_id, $bill_id, $npm)
    {
        $user = Auth::user();
        $paid_bill = PaidBill::select('paid_bills.id')
            ->where('bill_id',$bill_id)
            ->where('user_npm',$npm)
            ->get();
        $unpaid = PaidBill::find($paid_id);
        try {
            $unpaid->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect(route('bill.info',['id' => $bill_id]));
    }
}
