@extends('template.header')
@section('section')
<div class="content-wrapper" id="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="">Instalments</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <form action="">
                                <div class="row my-1">
                                    <div class="col-6">
                                        <label class="mb-1">Sale Invoice no</label>
                                        <input readonly id="invoice_no" onkeyup="getInvoices()" value="{{ isset($sale) ? $sale->invoice_no : '' }}" class="form-control" type="text">
                                        <!-- <div class="list-type" id="list" style="position: absolute; z-index: 1;"
                                                class="card mb-4">
                                                <div style="
                                                    height:150px;
                                                    overflow-y: scroll;"
                                                    id="listBody" class="list-group ">
                                                </div>
                                            </div> -->
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-6 d-flex justify-content-end ">
                            <a class="mt-2 me-2" style="text-decoration: none;" href="{{url('get-sale-instalments')."?id=".$sale->id}}">View All</a>
                        </div>
                    </div>
                    @if (isset($user_exception))
                    <div class="alert alert-danger"> {{ $user_exception }}</div>
                    @endif
                    <div class="row ">

                        <div style="overflow: scroll;" class="col-12 table-responsive ">
                            <table id="investor-table" class="table">
                                <thead class="thead-dark">
                                    <tr style="background-color:red !important;">
                                        <th style="width: 2px !important">#</th>
                                        <th scope="col">Instalment #</th>
                                        <th>instalment Id</th>
                                        <th scope="col">Due Date</th>
                                        <th scope="col">Due Amount</th>
                                        <th scope="col">Amount Paid</th>
                                        <th scope="col">Remaining Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="inventory-iems-body" id="inventory-iems-body">
                                    @php
                                    $count = 1;
                                    $total = 0;
                                    $paid = 0;
                                    $rem = 0;
                                    @endphp
                                    @if (isset($instalments))
                                    @foreach ($instalments as $pur)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td>{{$pur->instalment_no}}</td>
                                        <td>{{$pur->id}}</td>
                                        <td>
                                            <a id="change_time" data-date1="{{($pur->due_date)}}" data-id="{{$pur->id}}" data-saleid="{{$pur->sale_id}}" data-bs-toggle="modal" data-bs-target="#timeCard" href="#">{{date("d-m-Y", strtotime($pur->due_date))}}</a>
                                        </td>
                                        <!-- <td> <input type="date" class="form-control" value="{{$pur->due_date}}"> -->
                                        </td>
                                        <td>{{ number_format($pur->amount) }}</td>
                                        <td> {{ number_format($pur->amount_paid) }}</td>
                                        @php
                                        $rem = $pur->amount - $pur->amount_paid;
                                        @endphp
                                        <td> {{ number_format($rem) }}</td>

                                        <td>
                                            @if ($pur->instalment_paid)
                                            @php
                                            $paid = $paid + $pur->amount;
                                            @endphp
                                            <div class="badge-wrapper me-1">
                                                <span class="p-1 px-2 badge rounded-pill badge-light-success">Paid</span>
                                            </div>
                                            @else
                                            <div class="badge-wrapper me-1">
                                                <span class="p-1 badge rounded-pill badge-light-danger">Pending</span>
                                            </div>
                                            @endif
                                        </td>
                                        <td >

                                            <!-- <button @if ($pur->instalment_paid) disabled @endif
                                                data-rem={{ $rem }} data-id="{{ $pur->id }}"
                                                class="abc btn btn-success waves-effect waves-float waves-light"
                                                data-bs-toggle="modal" data-bs-target="#addNewCard">
                                                Pay
                                            </button> -->
                                            <a @if ($pur->instalment_paid) aria-disabled="true" @endif class="btn btn-success waves-effect waves-float waves-light" href="{{ url('instalment/pay-instalment-new?instalment_id='.$pur->id) }}">
                                                Pay 
                                            </a>
                                            <a class=" abc btn btn-secondary waves-effect waves-float waves-light" href="{{ route('show-instalment-payments', $pur->id) }}">
                                                Details
                                            </a>
                                            <!-- <a class=" abc btn btn-primary waves-effect waves-float waves-light" href="{{ route('show-instalment-payments', $pur->id) }}">
                                                Details
                                            </a>
                                            <a style="background-color: coral;color:white" class=" abc btn btn-alert waves-effect waves-float waves-light" href="#">
                                                Extend
                                            </a> -->

                                            {{-- <a href="{{ route('recieve-instalment',$pur->id) }}" >pay</a> --}}
                                        </td>
                                    </tr>
                                    @php
                                    $total = $total + $pur->amount;
                                    $count = $count + 1;
                                    @endphp
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <div class="me-2">
                                <p>Total : {{ number_format($total) }}</p>
                                <p>Paid : {{ number_format($paid) }}</p>
                                <p>Remaining : {{ number_format($total - $paid) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row container">
                <h4 class="text-center">Instalment Payment</h4>
                <form method="POST" action="{{ route('pay-instalment') }}">
                    @csrf
                    <input id="ins_id" type="hidden" name="id" type="text" class="form-control">

                    <div class="col-12 my-1 ">
                        <label> Account: </label>
                        <select class="form-control" name="account" id="">
                            {{-- <option value="1"> Cash</option> --}}
                            @foreach ($bank_acc as $acc)
                            <option value="{{ $acc->id }}">
                                {{ $acc->account_name }}
                            </option>
                            @endforeach
                            {{-- <option value="4">Bank Account</option> --}}
                        </select>
                    </div>

                    <div class="col-12 my-1 ">
                        <label> Amount Pending </label>
                        <input id="rem_amount" name="rem_ammount" type="text" class="number-separator form-control">
                    </div>

                    <div class="col-12 my-1 ">
                        <label> Amount: </label>
                        <input id="amount" name=" amount_paid" type="text" class="number-separator   form-control">
                    </div>

                    <div class="col-12 my-1 form-check">
                        <input name="move_to_next" class="form-check-input" type="checkbox" value="1" id="move_to_next">
                        <label class="form-check-label" for="flexCheckDefault">
                            Add Remaining amount to next instalment?
                        </label>
                    </div>

                    <div class="col-12 my-1">
                        <label> Note: </label>
                        <textarea class="form-control" name="notes" id="" cols="30" rows="3"></textarea>
                    </div>

                    <div lass="col-12 my-1">
                        <label> Date: </label>
                        <input name="pay_date" type="text" class="form-control invoice-edit-input date-picker flatpickr-input" readonly="readonly">
                    </div>

                    <div class="col-12 my-1 d-flex justify-content-end">
                        <button data-bs-dismiss="modal" type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<!-- time card -->
<div class="modal fade" id="timeCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-modal="true" role="dialog">
    <div style="height:100px" class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="row container">
                <h4 class="text-center">Instalment Extention</h4>
                <form method="POST" action="{{ route('extend-instalment') }}">
                    @csrf
                    <input id="ext_sale_id" type="hidden" name="sale_id" type="text" class="form-control">
                    <input id="ext_ins_id" type="hidden" name="id" type="text" class="form-control">

                    <div class="col-12 my-1 ">
                        <label> Current Due Date</label>
                        <input id="cur_date" name="cur_date" type="date" readonly class="number-separator form-control">
                    </div>

                    <div class="col-12 my-1 ">
                        <label> Updated Due Date: </label>
                        <input id="up_due_date" name="new_date" type="date" class="number-separator form-control">
                    </div>

                    <div class="col-12 my-1">
                        <label> Note: </label>
                        <textarea class="form-control" name="note" id="" cols="30" rows="3"></textarea>
                    </div>

                    <div class="col-12 my-1 d-flex justify-content-end">
                        <button data-bs-dismiss="modal" type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
               
                <div class="accordion" id="accordionExample">
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button onclick="checkClick()" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Extention History
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            <table id="investor-table" class="table">
                                <thead class="thead-dark">
                                    <tr style="background-color:red !important;">
                                        <th style="width: 2px !important">#</th>
                                        <th scope="col">Due Date</th>
                                        <th scope="col">Extented Date</th>
                                        <th scope="col">Note</th>
                                       
                                    </tr>
                                </thead>
                                <tbody id="ext_hist_body" >
                                   
                                </tbody>
                            </table>    
                            </div>
                        </div>
                    </div>
                    
                </div>

            </div>

        </div>
    </div>
</div>
<script src="{{ url('/resources/js/scripts/pages/app-invoice.min.js') }}"></script>


<script type="text/javascript">
    $(document).on("click", ".abc", function() {
        var insId = $(this).data('id');
        var rem_amount = $(this).data('rem');

        // alert(insId);
        $("#ins_id").val(insId);
        $("#rem_amount").val(rem_amount.toLocaleString('en-US'));

    });

    function checkClick(){
         var insId = $('#ext_ins_id').val();
        
         
         console.log("ssd : "+insId);
        $.ajax({
            url: "{{ route('get-instalment-extentions') }}",
            type: "GET",
            data: { 
                id: insId,
            },
            success: function(dataResult) {
               
                console.log('recv');
                console.log(dataResult);
                var tbody = $("#ext_hist_body");
                console.log(tbody);
                tbody.empty();
                var i;
                for (i = 0; i < dataResult.length; i++) {
                    var item = dataResult[i];
                    console.log(item);
                    var count = i+1;
                    var date = Date.parse(item.previous_date);
                    var markup = `<tr>
                                        <td>`+count +` </td>
                                        <td>`+item.previous_date+` </td>
                                        <td>`+ item.current_date+`</td>
                                        <td>`+ item.note+`</td>
                                  </tr>`;
                    console.log(markup);
                    tbody.append(markup);
                }
              

            },
            error: function(xhr, status, error) {
                
            },
        });
        
        console.log('exactly why');
    }
    $(document).on("click", "#change_time", function() {
        var date1 = $(this).data('date1');
        var insId = $(this).data('id');
        var saleId = $(this).data('saleid');
        // var rem_amount = $(this).data('rem');

        // alert(insId);
        $("#ext_sale_id").val(saleId);
        $("#ext_ins_id").val(insId);
        $("#cur_date").val(date1);
        // $("#rem_amount").val(rem_amount.toLocaleString('en-US'));

    });

    $(document).on('keyup', '#amount', function() {
        var rem_amount = ($("#rem_amount").val());
        var rem_amount = Number(rem_amount.replace(/[^0-9.-]+/g, ""));

        var amount = ($(this).val());
        amount = Number(amount.replace(/[^0-9.-]+/g, ""));
        if (amount > rem_amount) {
            $(this).val("");
        } else if (amount < rem_amount) {
            $('#move_to_next').attr('disabled', false);
        } else {
            $('#move_to_next').attr('disabled', true);
        }

    });

    function checkAmountPaid() {

    }
    $(document).ready(function() {

        $(document).ready(function() {
            console.log('i am datatable');
            // $('#investor-table').DataTable();
        });

    });


    function getInvoices() {
        // $("#customer_id").val("");
        var key = $('#invoice_no').val();
        //lo
        if (key.toString().length < 3) {

            return;
        }

        $.ajax({
            url: "{{ route('get-invoices') }}",
            type: "GET",
            data: {
                key: key,
            },
            success: function(dataResult) {
                $("#listBody").empty();
                console.log('recv');
                console.log(dataResult);
                var i;
                for (i = 0; i < dataResult.length; i++) {
                    var item = dataResult[i];
                    console.log(item);
                    markup = `<button id = "cusItem` + item.id +
                        `" type="button" class="list-group-item list-group-item-action" onclick="setInvoice(` +
                        item.id + `)">` + item.invoice_no + `</button>`;
                    $("#listBody").append(markup);
                }
                // $("#customer_name").val(dataResult.customer_name);

            },
            error: function(xhr, status, error) {
                // $("#customer_name").val("");
                // $("#customer_id").val("");
            },
        });
        $("#list").show();
    }

    function setInvoice(item) {

        $("#invoice_no").val($('#cusItem' + item).text());
        $("#list").hide();
        window.location.href = "{{ url('get-sale-instalments/') }}?id=" + item;
        // $("#customer_id").val(item);
        // $("#invoice_no").hide();
    }
</script>
@endsection