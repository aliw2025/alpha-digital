<?php

namespace App\Http\Controllers;

use App\Models\SupplierPayment;
use App\Models\ChartOfAccount;
use App\Models\GLeadger;
use App\Models\Payable;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Expense;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Symfony\Component\Finder\Glob;
use App\Models\Investor;
use App\Models\InvestorLeadger;
use App\Models\Item;
use App\Models\PurchaseItem;
use App\Models\SupplierPaymentAttachment;
use App\Models\TransactionStatus;
use Illuminate\Support\Facades\Auth;
use PDF;


class SupplierPaymentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
    }

    public function payablesRepTem($id){
        
        $leadger = GLeadger::where('investor_id',$id)->whereHas('account',function ($query)  {
            $query->where('account_type',7);
        })->orderBy('account_id')->get()  ;
        $total = $leadger->sum('value');
        return  view('payable.payables2', compact('leadger','total'));
    }

    public function getpayablesg(){
        $investors = Investor::all();
        return view('payable.payables', compact('investors'));   
    }

    public function getPayables(Request $request)
    {   
        $investors = Investor::all();
        $id = $request->investor_id;
        $suppliers = Supplier::whereIn('id', Purchase::select('supplier')->distinct()->pluck('supplier'))->get();
        return view('payable.payables', compact('suppliers', 'id','investors'));
        
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $investors = Investor::all();
        $suppliers = Supplier::all();
        $bank_acc = ChartOfAccount::where('owner_type','App\Models\Investor')->where(
            function($query) {
              return 
              $query->where('account_type', '=', 1)->orWhere('account_type', '=', 4);
             })->get();
        return view('payable.pay', compact('investors', 'suppliers','bank_acc'));

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
        $validate = $request->validate([
            'supplier'=>'required',
            'amount'=>'required'
        ]);
        $user = Auth::user();
        $id = SupplierPayment::max('id');
        if ($id == null) {
            $id = 0;
        }
        $num = str_pad($id + 1, 10, '0', STR_PAD_LEFT); 
        $investor = Investor::find($request->investor_id);
        $supplierPayment = new SupplierPayment();
        //$year = date('y'); // Get the current year in two digits (e.g., 24 for 2024)
        //$supplierPayment->payment_no = $investor->prefix . $year . $num;
        $supplierPayment->payment_no = $investor->prefix . '23' . $num;
        $supplierPayment->investor_id = $request->investor_id;
        $supplierPayment->store_id = 1;
        $supplierPayment->supplier_id = $request->supplier;
        $supplierPayment->amount = str_replace(',','',$request->amount); 
        $supplierPayment->note = $request->note;
        if($request->tran_exp){
            $supplierPayment->transaction_charges = str_replace(',','',$request->tran_exp);
        }
        $supplierPayment->payment_date = $request->payment_date;
        $supplierPayment->status = 1;
        $supplierPayment->account_id = $request->acc_type;
        $supplierPayment->save();

        $fileModel = new SupplierPaymentAttachment();
        // dd($request->all());
        // dd();
        if ($request->hasFile('file_name')) {
            $file = $request->file('file_name');
            // dd($file);s
            $fileModel->db_name  = $request->db_name;
            $fileName = $file->getClientOriginalName();
            $fileModel->supplier_payment_id = $supplierPayment->id;
            $filePath = $request->file('file_name')->storeAs('uploads/supplierPayments', $fileName,  'public');
            $fileModel->name = $file->getClientOriginalName();
            $fileModel->file_path = url('/') . '/public/storage/' . $filePath;
            $fileModel->save();

        }

        return redirect()->route('supplierPayment.show',$supplierPayment)->with('message','Record saved');

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierPayment $supplierPayment)
    {
    
        $investors = Investor::all();
        $suppliers = Supplier::all();
        $bank_acc = ChartOfAccount::where('owner_type','App\Models\Investor')->where(
            function($query) {
              return 
              $query->where('account_type', '=', 1)->orWhere('account_type', '=', 4);
             })->get();

        $attachment = SupplierPaymentAttachment::where('supplier_payment_id', $supplierPayment->id)->latest()->first();
        return view('payable.pay', compact('investors', 'attachment','suppliers','bank_acc','supplierPayment'));


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplierPayment $supplierPayment)
    {
        //
        return view('payable.pay');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplierPayment $supplierPayment)
    {

        if ($request->input('action') == "post") {

            return redirect()->route('post-supplierPayment', $request->all());
        
        }else if ($request->input('action') == "unpost") {
           
            return redirect()->route('unpost-supplierPayment', $request->all());
        }
         else if ($request->input('action') == "cancel") {
           
            return redirect()->route('cancel-supplierPayment', $request->all());
        }


        $validate = $request->validate([
            'supplier'=>'required',
            'amount'=>'required'
        ]);
       
    
        
        $supplierPayment->investor_id = $request->investor_id;
        $supplierPayment->store_id = 1;
        $supplierPayment->supplier_id = $request->supplier;
        $supplierPayment->amount = str_replace(',','',$request->amount); 
        if($request->tran_exp){
            $supplierPayment->transaction_charges = str_replace(',','',$request->tran_exp);
        }
        $supplierPayment->note = $request->note;
        $supplierPayment->payment_date = $request->payment_date;
        $supplierPayment->status = 1;
        $supplierPayment->account_id = $request->acc_type;
        $supplierPayment->save();
        $fileModel = new SupplierPaymentAttachment();
        if ($request->hasFile('file_name')) {
            $file = $request->file('file_name');
            // dd($file);s
            $fileModel->db_name  = $request->db_name;
            $fileName = $file->getClientOriginalName();
            $fileModel->supplier_payment_id = $supplierPayment->id;
            $filePath = $request->file('file_name')->storeAs('uploads/supplierPayments', $fileName,  'public');
            $fileModel->name = $file->getClientOriginalName();
            $fileModel->file_path = url('/') . '/public/storage/' . $filePath;
            $fileModel->save();

        }

        return redirect()->back()->with('message','Record Saved');

    }

    public function searchPayables(Request $request){


        $statuses = TransactionStatus::all();
        $investors = Investor::all();
        $suppliers = Supplier::all(); 
        return view('payable.search-payables',compact('investors','suppliers','statuses'));


    }

    //  search payables
    public function searchPayablesPost(Request $request){

        $request->validate([
            'from_date'=>'required',
            'to_date'=>'required'
        ]);

        $gl = GLeadger::whereBetween('date',[$request->from_date,$request->to_date])->wherehas('account',function($query){
            $query->where('owner_type','like','%supplier%');
        })->where('value','<',0);
        if(isset($request->investor_id)){
            $gl = $gl->where('investor_id',$request->investor_id);
        }
        if(isset($request->supplier_id)){
            $gl = $gl->where('account_id',$request->supplier_id);
        }
        $sum = $gl->sum('value');
        
        $statuses =  TransactionStatus::all();
        $investors = Investor::all();
        $suppliers = Supplier::all();
        $from_date  = $request->from_date;
        $to_date = $request->to_date;
        if ($request->input('action') == "pdf"){
            
            $gl = $gl->get();
            return view('payable.search_payables_report',compact('investors','suppliers','statuses','gl',  'from_date','to_date','sum'));

        }
        $gl = $gl->paginate(25);

        return view('payable.search-payables',compact('investors','suppliers','statuses','gl',  'from_date','to_date','sum'));

    }

    public function cancelSupplierPayment(Request $request){

        $supplierPayment = SupplierPayment::find($request->supplierPayment_id);
        if ($supplierPayment->status != 1) {
            return "transaction with entry status can be cancelled only";
        }
        $supplierPayment->status = 2;
        $supplierPayment->save();

        return redirect()->back()->with('message','Record Cancelled');
    }

    public function postsupplierPayment(Request $request)
    {
        
        $supplierPayment = SupplierPayment::find($request->supplierPayment_id);
        if ($supplierPayment->status == 3) {
            return "supplierPayment alreaddy posted";
        }elseif ($supplierPayment->status == 2) {
            return "supplierPayment cancelled cannot be posted";
        }

        $user = Auth::user();

        $request = new Request([
            'supplier_id' => $supplierPayment->supplier_id, // replace with actual supplier_id
            'investor_id' => $supplierPayment->investor_id, // replace with actual investor_id
        ]);

        // Call the supplierNetPayable method
        $netPayable = $this->supplierNetPayable($request);
        
        if($supplierPayment->amount > $netPayable){
            return redirect()->back()->with('error_m', 'Amount is greater than net payable');
        }
        
       

        if(!SupplierPayment:: NegativeCheck($supplierPayment->account_id,$supplierPayment->amount,$request->investor_id)){
            return redirect()->back()->with('error_m', 'Balance insufficient');
        }

        if($supplierPayment->transaction_charges >0){

            $expense = new Expense();
            $expense->description = "supplier payment no: ".$supplierPayment->payment_no."  bank charges  ";
            $expense->amount = str_replace(',','',$supplierPayment->transaction_charges);
            $expense->date = $supplierPayment->payment_date;
            $expense->head_id = 1;
            $expense->status = 3;
            $expense->investor_id = $supplierPayment->investor_id;
            $expense->save();
            $supplierPayment->expense_id = $expense->id;
            $supplierPayment->save();
            // creating impact of expense on leadger
            $expense->createLeadgerEntry(8,$expense->amount,$supplierPayment->investor_id, $expense->date ,$user->id);
            $expense->createLeadgerEntry($supplierPayment->account_id,-$expense->amount,$supplierPayment->investor_id,$expense->date,$user->id);
        }

       
       
        // // getting supplier supplierPayment account
        $supplier = Supplier::find( $supplierPayment->supplier_id);
        // dd($supplier);
        $sup_acc_id = $supplier->charOfAccounts->where('account_type', 7)->first()->id;
        $total = SupplierPayment::PayableAmount($supplierPayment->investor_id,$sup_acc_id);
        // dd($total);
        if($total-$supplierPayment->amount<0){
            return redirect()->back()->with('error_m','payment exceeded payable amount of '.$total);

        }

        $supplierPayment->status = 3;
        $supplierPayment->save();

        // /************** Leadger Entries **********/
        $supplierPayment->createLeadgerEntry($sup_acc_id,str_replace(',','',$supplierPayment->amount),$supplierPayment->investor_id,$supplierPayment->payment_date,$user->id);
        $supplierPayment->createLeadgerEntry($supplierPayment->account_id,-str_replace(',','',$supplierPayment->amount),$supplierPayment->investor_id,$supplierPayment->payment_date,$user->id);

        $sale_detail = null;
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y'),
            'supplierPayment' => $supplierPayment,
            'sale_detail' => $sale_detail,
            'user_id' => $user->id

        ];
       
        $pdf = PDF::loadView('payable.supplier-payment-inv-pdf', $data);
        return $pdf->stream('my.pdf', array('Attachment' => 0));
       // return redirect()->back()->with('message','Record Posted');
    }

    public function UnpostSupplierPayment(Request $request)
    {
        $supplierPayment = SupplierPayment::find($request->supplierPayment_id);
        if ($supplierPayment->status != 3) {
            return "only posted supplierPayment can be unposted";
        }
        $user = Auth::user();
        $supplierPayment->status = 1;
        $supplierPayment->save();
        $supplierPayment->leadgerEntries()->delete();
        if($supplierPayment->expense_id){
            $expense = Expense::find($supplierPayment->expense_id);
            $expense->status = 2;
            $expense->save();
            $expense->leadgerEntries()->delete();
        }

       
        return redirect()->back()->with('message','Record Un Posted');
    }

    public function showSupplierPayments(Request $request){

        $statuses = TransactionStatus::all();
        $investors = Investor::all();
        $suppliers = Supplier::all();
      
        return view('payable.supplier-payments',compact('investors','suppliers','statuses'));
    }

    public function showSupplierPaymentsPost(Request $request){

        $request->validate([
            'from_date'=>'required',
            'to_date'=>'required'   
        ]);
        
        $supplierPayments = SupplierPayment::showSupplierPayments($request->from_date, $request->to_date, $request->investor_id,$request->supplier_id,$request->status_id);

        $investors = Investor::all();
        $suppliers = Supplier::all();
        $statuses = TransactionStatus::all();
        $from_date = $request->from_date;
        $to_date = $request->to_date;

       

            $sum = SupplierPayment::whereBetween('payment_date',[$from_date,$to_date]);
            if(isset($request->investor_id))
            $sum = $sum->where('investor_id',$request->investor_id);
            if(isset($request->supplier_id))
            $sum = $sum->where('supplier_id',$request->supplier_id);
            if(isset($request->status_id))
            $sum = $sum->where('status',$request->status_id);
            
            $sum=$sum->sum('amount');
                    
        if ($request->input('action') == "pdf"){
            
            $supplierPayments = $supplierPayments->get();
            return view('payable.supplier_payment_report',compact('supplierPayments','investors','suppliers','from_date','to_date','statuses','sum'));

        }

        $supplierPayments = $supplierPayments->paginate(20);
        $supplierPayments->appends([
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'investor_id' => $request->investor_id,
            'supplier_id'=>$request->supplier_id
           
        ]);
       
        return view('payable.supplier-payments',compact('supplierPayments','investors','suppliers','from_date','to_date','statuses','sum'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierPayment $supplierPayment)
    {
        //
    }

    public function supplierNetPayable(Request $request){

        $request->validate([
           'supplier_id'=>'required', 
           'investor_id'=>'required',
        ]);

        try {
            $supplier = Supplier::find($request->supplier_id);
            $sup_acc_id = $supplier->charOfAccounts->where('account_type',7)->first()->id;
            $led =  GLeadger::where('investor_id', '=', $request->investor_id)->where('account_id',$sup_acc_id)->get();
            $sum = $led->sum('value');

            return $sum *-1;

        } catch (\Throwable $th) {
            //throw $th;
            return "failed to get net payable";
        }


    }
}
