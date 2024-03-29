<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\GLeadger;
use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\Investor;
use App\Models\InvestorLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TransferRequests;
use Illuminate\Support\Facades\Input;
use App\Models\InvestorPayment;

class GLController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\GLeadger  $gLeadger
     * @return \Illuminate\Http\Response
     */
    public function show(GLeadger $gLeadger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GLeadger  $gLeadger
     * @return \Illuminate\Http\Response
     */
    public function edit(GLeadger $gLeadger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GLeadger  $gLeadger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GLeadger $gLeadger)
    {
        //
    }

    public function transferBalances(Request $request)
    {
        // getting all accounts     
        $bank_accounts = ChartOfAccount::where('owner_type', 'App\Models\Investor')->where(
            function ($query) {
                return
                    $query->where('account_type', '=', 1)->orWhere('account_type', '=', 4);
            }
        )->get();
        
        $investors = Investor::all();
        return view('capital-investments.transfer-balances', compact('bank_accounts', 'investors'));
    }

    public function userTransferBalances(Request $request)
    {
        $user = Auth::user();
        $ro_bank_accounts = $user->charOfAccounts;
        $bank_accounts = ChartOfAccount::where('owner_type', 'App\Models\Investor')->where(function ($query) {
            $query->where('account_type', 1)->orWhere('account_type', 4);
        })->get();
        $investors = Investor::all();
        return view('recovery.ro-transfer-balances', compact('bank_accounts', 'investors', 'ro_bank_accounts'));
    }
    public function addTransferRequest(Request $request)
    {

        // dd($request->all());
        $validated = $request->validate(
            [
                'amount' => 'required',
            ]
        );
        $tr = new TransferRequests();
        $tr->sender_account_id = $request->bnk_1;
        $tr->reciever_account_id = $request->bnk_2;
        $tr->amount =  str_replace(',', '', $request->amount);
        $tr->status = 0;
        $tr->owner_investor_id = $request->inv_1;
        if(!TransferRequests:: NegativeCheck($request->bnk_1,str_replace(',', '', $request->amount),$request->inv_1)){
            return redirect()->back()->with('error_m', 'Balance insufficient');
        }
        $tr->save();

        return redirect()->back()->with('message','Request Added');
    }


    public function investorApprovalQueue()
    {

        // $tr = TransferRequests::all();
        $t_pending = TransferRequests::where('status', 0)->get();
        $t_appr = TransferRequests::where('status', 1)->get();
        $t_cancel = TransferRequests::where('status', 2)->get();
        return view('capital-investments.transfer-requests', compact('t_pending', 't_appr', 't_cancel'));
    }

    public function userApprovalQueue()
    {

        $user = Auth::user();

        $t_pending = TransferRequests::whereHas('sender_account', function ($query) use ($user) {
            $query->where('owner_type', 'App\Models\User')->where('owner_id', $user->id);
        })->where('status', 0)->get();

        $t_appr = TransferRequests::whereHas('sender_account', function ($query) use ($user) {
            $query->where('owner_type', 'App\Models\User')->where('owner_id', $user->id);
        })->where('status', 1)->get();

        $t_cancel = TransferRequests::whereHas('sender_account', function ($query) use ($user) {
            $query->where('owner_type', 'App\Models\User')->where('owner_id', $user->id);
        })->where('status', 2)->get();


        return view('recovery.ro-pending-fund-requests', compact('t_pending', 't_cancel', 't_appr'));
    }

    // functino that runs after approving authority approves the request
    public function userApproval(Request $request)
    {
        $user = Auth::user();
        $t = TransferRequests::where('id', $request->tran_id)->first();
        if ($request->input('submit') == 'approve') {

            $t->status = 1;
            $t->save();
            //  leadger entry for debit cash/bank of investory
            $t->createLeadgerEntry($t->reciever_account_id, $t->amount, $t->owner_investor_id, $t->created_at, $user->id);
            $t->createLeadgerEntry($t->sender_account_id, -$t->amount, $t->owner_investor_id, $t->created_at, $user->id);
            //  make leadger entried
        } else {

            $t->status = 2;
            $t->save();
        }

        return redirect()->route('investor-transfer-queue');
    }


    /****
     * function to transfer balance from one company account to other
     *  company account
     */
    public function bankTransfer(Request $request)
    {

        // validate id amount is provided
        $validated = $request->validate(
            [
                'amount' => 'required',
            ]
        );


        $user  = Auth::user();

        // if investor is same no payable will be created ,
        // other wise payable will be created for different kind of investor

        if ($request->inv_1 == $request->inv_2) {

            $t = new TransferRequests();
            $t->sender_account_id = $request->bnk_1;
            $t->reciever_account_id = $request->bnk_2;
            $t->amount =  str_replace(',', '', $request->amount);
            $t->status = 0;
            $t->owner_investor_id = $request->inv_1;
            if(!TransferRequests:: NegativeCheck($request->bnk_1,str_replace(',', '', $request->amount),$request->inv_1)){
                return redirect()->back()->with('error_m', 'Balance insufficient');
            }
            $t->save();
            //leadger entry for debit cash/bank of investory
            // $t->createLeadgerEntry($t->reciever_account_id, $t->amount, $t->owner_investor_id, $t->created_at, $user->id);
            // $t->createLeadgerEntry($t->sender_account_id, -$t->amount, $t->owner_investor_id, $t->created_at, $user->id);
        } else {

            // create a method to deal with payables    
            $inv_loan = new InvestorLoan();
            $inv_loan->inv1_id = $request->inv_1;
            $inv_loan->inv1_account =  $request->bnk_1;
            $inv_loan->inv2_account =  $request->bnk_2;
            $inv_loan->amount = $request->amount;
            $inv_loan->inv2_id = $request->inv_2;
            if(!TransferRequests:: NegativeCheck($request->bnk_1,str_replace(',', '', $request->amount),$request->inv_1)){
                return redirect()->back()->with('error_m', 'Balance insufficient');
            }
            $inv_loan->save();

            //   create leadger entries here.
            $inv_loan->createLeadgerEntry(5,  $inv_loan->amount,  $inv_loan->inv1_id,  $inv_loan->created_at, $user->id);
            $inv_loan->createLeadgerEntry( $inv_loan->inv1_account, - $inv_loan->amount,  $inv_loan->inv1_id,  $inv_loan->created_at, $user->id);

            $inv_loan->createLeadgerEntry( $inv_loan->inv1_account,  $inv_loan->amount,  $inv_loan->inv2_id,  $inv_loan->created_at, $user->id);
            $inv_loan->createLeadgerEntry(7, - $inv_loan->amount,  $inv_loan->inv2_id,  $inv_loan->created_at, $user->id);


        }

        return redirect()->back()->with('message','Request Added');
    }

    public function AccountBalances(Request $request)
    {
        $investors = Investor::all();
        $bank_accounts = ChartOfAccount::where('owner_type', 'App\Models\Investor')->where(function ($query) {
            $query->where('account_type', 1)->orWhere('account_type', 4);
        })->get();
        $transactions = GLeadger::select('investor_id', 'account_id', DB::raw('sum(value) as value'))->where('value', '!=', 0)->whereHas('account', function ($query) {
            $query->where(
                function ($query2) {
                    $query2->where('account_type', 1)->orWhere('account_type', 4);
                }
            );
        })->groupBy('account_id')->groupBy('investor_id')->with('account')->with('investor')->get();

        return view('capital-investments.account-balances', compact('transactions', 'investors', 'bank_accounts'));
    }


    public function userAccountBalances(Request $request)
    {
        $investors = Investor::all();
        $user = Auth::user();
        $bank_accounts = $user->charOfAccounts;
        $transactions = GLeadger::select('investor_id', 'account_id', DB::raw('sum(value) as value'))->where('value', '!=', 0)->whereHas('account', function ($query) {
            $query->where(
                function ($query2) {
                    $query2->where('account_type', 1)->orWhere('account_type', 4);
                }
            );
        })->groupBy('account_id')->groupBy('investor_id')->with('account')->with('investor')->get();

        return view('recovery.ro-account_balances', compact('transactions', 'investors', 'bank_accounts'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GLeadger  $gLeadger
     * @return \Illuminate\Http\Response
     */
    public function destroy(GLeadger $gLeadger)
    {
        //
    }
    public function investorPaymentCreate(Request $request)
    {

        $bank_accounts = ChartOfAccount::where('owner_type', 'App\Models\Investor')->where(
            function ($query) {
                return
                    $query->where('account_type', '=', 1)->orWhere('account_type', '=', 4);
            }
        )->get();
        $investors = Investor::all();
        return view('capital-investments.investors-payments', compact('bank_accounts', 'investors'));
        
    }

    public function investorPaymentStore(Request $request)
    {

        // validate id amount is provided
        $validated = $request->validate(
            [
                'amount' => 'required',
            ]
        );

        $user  = Auth::user();
        // create a method to deal with payables    
        $inv_loan = new InvestorPayment();
        $inv_loan->inv1_id = $request->inv_1;
        $inv_loan->inv1_account =  $request->bnk_1;
        $inv_loan->inv2_account =  $request->bnk_2;
        $inv_loan->amount = str_replace(',', '', $request->amount);
        $inv_loan->inv2_id = $request->inv_2;
        $inv_loan->save();

        if(!TransferRequests:: NegativeCheck($request->bnk_1,str_replace(',', '', $request->amount),$request->inv_1)){
            return redirect()->back()->with('error_m', 'Balance insufficient');
        }

        //   create leadger entries here.
        // debit payable 
        $inv_loan->createLeadgerEntry(7,  $inv_loan->amount,  $inv_loan->inv1_id,  $inv_loan->created_at, $user->id);
        // credit cash or bank
        $inv_loan->createLeadgerEntry( $inv_loan->inv1_account, - $inv_loan->amount,  $inv_loan->inv1_id,  $inv_loan->created_at, $user->id);
        // debit cash or bank
        $inv_loan->createLeadgerEntry( $inv_loan->inv1_account,  $inv_loan->amount,  $inv_loan->inv2_id,  $inv_loan->created_at, $user->id);
        // credit recievable
        $inv_loan->createLeadgerEntry(5, - $inv_loan->amount,  $inv_loan->inv2_id,  $inv_loan->created_at, $user->id);

        return redirect()->back()->with('message','Loan Paid');

    }
    


    
}
