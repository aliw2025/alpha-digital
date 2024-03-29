<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Investor;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class InvestmentController extends Controller
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
        $investors = Investor::all();
        $bank_acc = ChartOfAccount::where('owner_type', 'App\Models\Investor')->where(
            function ($query) {
                return
                    $query->where('account_type', '=', 1)->orWhere('account_type', '=', 4);
            }
        )->get();
        return view('capital-investments.add_balance',compact('investors','bank_acc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'amount'=>'required',
            'description'=>'required',
            'date'=>'required'
        ]);
        $investment = new Investment();
        $investment->description = $request->description;
        $investment->amount = str_replace(',','',$request->amount);
        $investment->date = $request->date;
        $investment->investor_id = $request->investor_id;
        $investment->status = 1;
        $investment->account_id = $request->acc_type;
        $investment->save();
    
        return redirect()->route('investment.show',$investment->id)->with('message','Record Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function show(Investment $investment)
    {
        $investors = Investor::all();
        $bank_acc = ChartOfAccount::where('owner_type', 'App\Models\Investor')->where(
            function ($query) {
                return
                    $query->where('account_type', '=', 1)->orWhere('account_type', '=', 4);
            }
        )->get();
       
        return view('capital-investments.add_balance',compact('investors','bank_acc','investment'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function edit(Investment $investment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Investment $investment)
    {
        
        if ($request->input('action') == "post") {

            return redirect()->route('post-investment', $request->all());
        
        }else if ($request->input('action') == "unpost") {
           
            return redirect()->route('unpost-investment', $request->all());
        }
         else if ($request->input('action') == "cancel") {
           
            return redirect()->route('cancel-investment', $request->all());
        }


        $validated = $request->validate([
            'amount'=>'required',
            'description'=>'required',
            'date'=>'required'
        ]);

        $investment->description = $request->description;
        $investment->amount = str_replace(',','',$request->amount);
        $investment->date = $request->date;
        $investment->investor_id = $request->investor_id;
        $investment->account_id = $request->acc_type;
        $investment->save();

        return redirect()->back()->with('message', 'Record Saved');

       


    }
    public function postInvestment(Request $request)
    {
        # code...

      
        $investment = Investment::find($request->investment_id);
        
        if($investment->status != 1){

            return "only transaction with entry status can be posted";
        }

        $investment->status = 3;
        $investment->save();
     
         $user = Auth::user();
         $investment->createLeadgerEntry(  $investment->account_id,$investment->amount,$request->investor_id,$request->date,$user->id);
         $investment->createLeadgerEntry(6,-$investment->amount,$request->investor_id,$request->date,$user->id);
         return redirect()->back()->with('message', 'Record Posted');

    }
    public function unPostInvestment(Request $request)
    {
        $investment = Investment::find($request->investment_id);
        if($investment->status != 3){

            return "only transaction with posted status can be unposted";
        }

        $investment->status = 1;
        $investment->save();
     
         $user = Auth::user();
         $investment->leadgerEntries()->delete();
         return redirect()->back()->with('message', 'Record Un Posted');
        }

    public function cancelInvestment(Request $request)
    {
        # code...

        $investment = Investment::find($request->investment_id);
        if($investment->status != 1){

            return "only transaction with entry status can be cancelled";
        }

        $investment->status = 2;
        $investment->save();
     
        return redirect()->back()->with('message', 'Record Cancelled');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Investment $investment)
    {
        //
    }
}
