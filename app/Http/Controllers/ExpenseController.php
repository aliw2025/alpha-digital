<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
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
        $investors = Investor::all();
        return view('expenses.expense',compact('investors'));
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
        $expense = new Expense();
        $expense->description = $request->description;
        $expense->amount = str_replace(',','',$request->amount);
        $expense->date = $request->date;
        $expense->investor_id = $request->investor_id;
        $expense->save();
        $user = Auth::user();
        $expense->createLeadgerEntry($request->acc_type,$expense->amount,$request->investor_id,$request->date,$user->id);
        $expense->createLeadgerEntry(8,-$expense->amount,$request->investor_id,$request->date,$user->id);
        
        return redirect()->route('show-expenses');
        

    }

    public function showExpenses(){
        
        $expenses = Expense::all();
        return $expenses;
        // view('expenses.expenses',compact('expenses'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
        return view('expenses.expense',compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
