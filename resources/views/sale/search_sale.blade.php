@extends('template.header')
@section('section')
<div class="content-wrapper" id="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="">Sales</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form class="" method="GET" autocomplete="on" action="{{ route('search-sales-post') }}">
                        @csrf
                        <div class="row d-flex align-items-center">
                            
                            <div class="col-2">
                                <div class="">
                                    <span class="title">From Date:</span>
                                    <input name="from_date" type="text"
                                        class="form-control invoice-edit-input date-picker flatpickr-input"
                                        readonly="readonly">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="">
                                    <span class="title">To Date:</span>
                                    <input name="to_date" type="text"
                                        class="form-control invoice-edit-input date-picker flatpickr-input"
                                        readonly="readonly">
                                </div>
                            </div>
                            <div class="col-2 ">
                                <span  class="title">Customer Name:</span>
                                <input name="customer_name" type="text" class="form-control">
                            </div>
                            <div class="col-2 ">
                                <span class="title">Customer ID:</span>
                                <input name="customer_id" type="text" class="form-control">
                            </div>
                            <div class="col-2 ">
                                <span class="title">Invoice No:</span>
                                <input name="invoice_no" type="text" class="form-control">
                            </div>
                            <div class="col-2 ">
                                <Button type="submit" class="mt-1 btn btn-relief-primary">Report</Button>
                            </div>

                        </div>


                    </form>
                    <div class="row mt-2">
                   
                        <div  class="col-12 table-responsive ">
                            @if(isset($sales))
                            <table id="investor-table" class="table">
                                <thead class="thead-dark">
                                    <tr style="background-color:red !important;">
                                        <th style="width: 2px !important">#</th>
                                        <th>Customer  Name</th>
                                        <th scope="col">invoice NO</th>  
                                        <th>Staus</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                        {{-- <th scope="col">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="inventory-iems-body" id="inventory-iems-body">
                                    @php
                                        $count = 1
                                    @endphp
                                    
                                    @foreach ($sales as $pur)

                                    <tr>
                                        <td>{{$count}}</td>
                                        <td>{{$pur->customer->customer_name}}</td>
                                        <td>{{$pur->invoice_no}}</td>
                                        <td>{{$pur->transaction_status->desc}}</td>
                                        <td> {{ number_format($pur->total) }}</td>
                                        <td>{{date('d-m-Y', strtotime($pur->sale_date))}}</td>
                                        
                                        <td>
                                            <a style="text-decoration: none;color:black" href="{{route('sale.show',$pur->id)}}"><i data-feather='eye'></i></a>
                                            <a style="text-decoration: none;color:black" href="{{url('sale-return')."?id=".$pur->id}}" ><i data-feather='rotate-ccw'></i></i></a>
                                            <a style="text-decoration: none;color:black" href="{{url('get-sale-instalments')."?id=".$pur->id}}"><i data-feather='dollar-sign'></i></a>
                                            <a style="text-decoration: none;color:black" href="{{route('sale.edit',$pur->id)}}"><i data-feather='edit'></i></a>

                                        </td>
                                    </tr>
                                    @php
                                        $count = $count+1
                                    @endphp

                                    @endforeach
                                   
                                 
                            
                                </tbody>
                            </table>
                            <div class="row my-2">
                                <div class="col-6">
                                    
                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                    {{ $sales->links() }}
                                </div>
                              
                            </div>
                           
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ url('/resources/js/scripts/pages/app-invoice.min.js') }}"></script>

<script type="text/javascript">


    $(document).ready(function() {

        $(document).ready(function() {
            console.log('i am datatable');
            // $('#investor-table').DataTable();
        });

    });
</script>
@endsection