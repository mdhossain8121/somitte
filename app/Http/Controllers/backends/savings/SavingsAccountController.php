<?php

namespace App\Http\Controllers\backends\savings;

use App\Models\savings\SavingsAccount;
use App\Models\savings\SavingsScheme;
use App\Models\person\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\backends\savings\StoreSavingsAccountRequest;
use Auth;

class SavingsAccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backends.pages.savings.account.index');
    }

    /**
     * Display a tables data.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        try {
            $savingsAccounts = SavingsAccount::with(['customer','savingsScheme'])->get();
            return Datatables::of($savingsAccounts)->addIndexColumn()
            ->addColumn('actions', function ($savingsAccount) {
                return (string) view('backends.pages.savings.account.actions', ['savingsAccount' => $savingsAccount]);
            })->rawColumns(['actions','status'])->make();
        } catch (\Exception $th) {
            return back()->withErrors([
                'error'=>'Seek system administrator help',
                'error-dev'=> $th->getMessage()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::where('active_fg',1)->get();
        $savingsSchemes = SavingsScheme::where('active_fg',1)->get();
        return view('backends.pages.savings.account.create',compact('customers','savingsSchemes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSavingsAccountRequest $request)
    {
        try {
            $savingsAccount = new SavingsAccount;
            $savingsAccount->account_no = $request->input('account_no');
            $savingsAccount->first_deposit_amount = trim($request->input('first_deposit_amount'))?:0;
            $savingsAccount->customer_id = Crypt::decrypt($request->input('customer_id'));
            $savingsAccount->savings_scheme_id = Crypt::decrypt($request->input('savings_scheme_id'));
            $savingsAccount->deposit_amount = trim($request->input('deposit_amount'))?:0;
            $savingsAccount->late_fee = trim($request->input('late_fee'))?:0;
            $savingsAccount->profit = $request->input('profit');
            $savingsAccount->start_date = insertDateFormat($request->input('start_date'));
            $savingsAccount->end_date = insertDateFormat($request->input('end_date'));
            $savingsAccount->remarks = $request->input('remarks');
            $savingsAccount->active_fg = 1;
            $savingsAccount->created_by = Auth::user()->id;
            $is_saved = $savingsAccount->save();
            if ($is_saved) {
                return back()->with('message', 'Savings Account has been added');
            } else {
                return back()->withErrors(['error'=>'Savings Account has not been added']);
            }
        } catch (\Exception $th) {
            return back()->withErrors([
                'error'=>'Seek system administrator help',
                'error-dev'=> $th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\savings\SavingsAccount  $savingsAccount
     * @return \Illuminate\Http\Response
     */
    public function show($savingsAccountId)
    {
        $savingsAccounts = SavingsAccount::with(['customer','savingsScheme','activeSavingsDeposits'])->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\savings\SavingsAccount  $savingsAccount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $savingsAccount = SavingsAccount::findorFail($id);
        $customers = Customer::where('active_fg',1)->get();
        $savingsSchemes = SavingsScheme::where('active_fg',1)->get();
        return view('backends.pages.savings.account.edit',compact('savingsAccount','customers','savingsSchemes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\savings\SavingsAccount  $savingsAccount
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSavingsAccountRequest $request, SavingsAccount  $savingsAccount)
    {
        try {
            $id = Crypt::decrypt($request->account);
            $savingsAccount = SavingsAccount::findOrFail($id);
            $savingsAccount->account_no = $request->input('account_no');
            $savingsAccount->first_deposit_amount = trim($request->input('first_deposit_amount'))?:0;
            $savingsAccount->customer_id = Crypt::decrypt($request->input('customer_id'));
            $savingsAccount->savings_scheme_id = Crypt::decrypt($request->input('savings_scheme_id'));
            $savingsAccount->deposit_amount = trim($request->input('deposit_amount'))?:0;
            $savingsAccount->late_fee = trim($request->input('late_fee'))?:0;
            $savingsAccount->profit = $request->input('profit');
            $savingsAccount->start_date = insertDateFormat($request->input('start_date'));
            $savingsAccount->end_date = insertDateFormat($request->input('end_date'));
            $savingsAccount->remarks = $request->input('remarks');
            $savingsAccount->active_fg = $request->input('active_fg');
            $savingsAccount->updated_by = Auth::user()->id;
            $is_saved = $savingsAccount->save();
            if ($is_saved) {
                return back()->with('message', 'Savings Account has been updated');
            } else {
                return back()->withErrors(['error'=>'Savings Account has not been updated']);
            }
        } catch (\Exception $th) {
            return back()->withErrors([
                'error'=>'Seek system administrator help',
                'error-dev'=> $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\savings\SavingsAccount  $savingsAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $id = Crypt::decrypt($id);
            $savingsAccount = SavingsAccount::findOrFail($id);
            $savingsAccount->active_fg=0;
            $savingsAccount->updated_by = Auth::user()->id;
            $result = $savingsAccount->save();
            if ($result) return response()->json(['type'=>'success', 'title'=>'Deleted!', 'msg'=>'Savings Account has been deleted']);
            return response()->json(['type'=>'error', 'title'=>'Sorry!', 'msg'=>'Failed to delete Savings Account']);
        }
        catch (\Exception $e) {
            return response()->json(['type'=>'error', 'title'=>'System Failure!!', 'msg'=>$e->getMessage()], 400);
        }
    }
}
