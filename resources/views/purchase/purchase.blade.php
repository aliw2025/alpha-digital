@extends('template.header')
@section('section')
    <div class="content-wrapper container-xxl p-0">
        <div class="content-body">
            <section class="invoice-add-wrapper">
                <div class="row invoice-add">
                    <!-- Invoice Add Left starts -->
                    <div class="col-xl-12 col-md-12 col-12">
                        <form class="" method="POST" autocomplete="on" action="{{ route('purchase.store') }}">
                            <div class="card invoice-preview-card">
                                <!-- Header starts -->
                                <div class="card-body invoice-padding pb-0">
                                    <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                        <div>
                                            <div class="logo-wrapper">
                                                <h3 class="ms-0 text-primary invoice-logo">Alpha Digital</h3>
                                            </div>
                                            <p class="card-text mb-25">Office 149,Mustafa plaza</p>
                                            <p class="card-text mb-25">Ring Road Peshawar, PK</p>
                                            <p class="card-text mb-0">+1 (123) 456 7891, +44 (876) 543 2198</p>

                                        </div>
                                        <div class="mt-2">
                                            <h4 style="text-decoration: underline">{{ $type == 1 ? 'Purchase' : 'Purchase Return' }}</h4>
                                        </div>
                                        <div class="invoice-number-date mt-md-0 mt-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                @csrf
                                                <input id ="tran_type" type="hidden" value="{{$type}}" name="tran_type">
                                                <input type="hidden" name="purchase_type" id="purchase_type" value="{{ $type }}">
                                                <h4 class="invoice-title"> {{ $type == 1 ? 'Purchase #' : 'Purchase Return #' }}</h4>
                                                <div class="input-group input-group-merge invoice-edit-input-group">
                                                    <input style="font-size: 12px"
                                                        @if (isset($purchase)) disabled
                                                        value="{{ $purchase->purchase_no }}" 
                                                        @endif
                                                        name="purchaseId" type="text" class="form-control invoice-edit-input" placeholder="" disabled>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <span class="title">Date:</span>
                                                @if (isset($purchase))
                                                    <input value="{{ $purchase->purchase_date }}" disabled
                                                        name="payment_date" type="text"
                                                        class="form-control invoice-edit-input ">
                                                @else
                                                    <input name="purchase_date" type="text"
                                                        class="form-control invoice-edit-input date-picker flatpickr-input"
                                                        readonly="readonly">
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="title">Investor:</span>
                                                <div style="width: 11.21rem; max-width:11.21rem; "
                                                    class="align-items-center">
                                                    @if (isset($purchase))
                                                        <input disabled value="{{ $purchase->investor->investor_name }}"
                                                            name="payment_date" type="text"
                                                            class="form-control invoice-edit-input ">
                                                    @else
                                                        <select name="investor_id"
                                                            class=" select2 select2-hidden-accessible form-control invoice-edit-input"
                                                            id="select2-basic" data-select2-id="select2-basic"
                                                            tabindex="-1" aria-hidden="true">
                                                            @foreach ($investors as $investor)
                                                                <option value="{{ $investor->id }}">
                                                                    {{ $investor->investor_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-1">
                                                <span class="title">Supplier</span>
                                                <div style="width: 11.21rem; max-width:11.21rem; "
                                                    class="align-items-center">
                                                    @if (isset($purchase))
                                                        <input value="{{ $purchase->supplier_val->name }}" disabled
                                                            name="payment_date" type="text"
                                                            class="form-control invoice-edit-input ">
                                                    @else
                                                        <select id="supplier_id" name="supplier" class="form-select"
                                                            aria-label="Default select example">
                                                            @foreach ($suppliers as $sup)
                                                                <option value="{{ $sup->id }}">{{ $sup->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                                <hr class="invoice-spacing">
                                <!-- Product Details starts -->
                                <div class="card-body invoice-padding invoice-product-details">
                                    <form class="source-item">
                                        @if (!isset($purchase))
                                            <div data-repeater-list="group-a">

                                                <div class="repeater-wrapper" data-repeater-item="">
                                                    <div class="row">
                                                        <div
                                                            class="col-12 d-flex product-details-border position-relative pe-0">
                                                            <div class="row py-2">
                                                                <div class="col-lg-1 col-12 my-lg-0 my-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">Item Id</p>
                                                                    <input id="passId0" type="number"
                                                                        class="form-control" value="" placeholder=""
                                                                        disabled>
                                                                    <input name="item_id[]" id="item_id0" type="hidden"
                                                                        class="form-control" value="" placeholder="">
                                                                </div>
                                                                <div class="col-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">Item Name
                                                                    </p>
                                                                    <input autocomplete="off" id="itemBox0"
                                                                        class=" form-control" autocomplete="off"
                                                                        placeholder="Enter Item" @if($type==1) onkeyup="getItems(0)" @else onkeyup="getInvItems(0)" @endif>
                                                                    <div class="list-type" id="list0"
                                                                        style="position: absolute; z-index: 1;"
                                                                        class="card mb-4">
                                                                        <div id="listBody0" class="list-group">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">cost</p>
                                                                    <input  onkeyup="calRowTotal(0)" id="cost0"
                                                                        name="cost[]" 
                                                                        class="number-separator form-control" value=""
                                                                        placeholder="">
                                                                </div>
                                                                @if($type==2)
                                                                    {{-- @dd("wwwwwww") --}}
                                                                    <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                        <p class="card-text col-title mb-md-2 mb-0">Curr Price</p>
                                                                        <input onkeyup="calLoss(0)"  id="cur_cost0"
                                                                            name="cost[]" 
                                                                            class="number-separator form-control" value=""
                                                                            placeholder="">
                                                                    </div>
                                                                   
                                                                @endif
                                                                
                                                                <div class="col-lg-1 col-12 my-lg-0 my-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">Qty</p>
                                                                    <input pattern="[0-9]{10}" onkeyup="calRowTotal(0)"
                                                                        id="qty0" name="qty[]" type="number"
                                                                        onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 45) ? null : event.charCode >= 48 && event.charCode <= 57"
                                                                        class="form-control" value=""
                                                                        placeholder="">
                                                                </div>
                                                                @if($type==2)
                                                    
                                                                    <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                        <p class="card-text col-title mb-md-2 mb-0">Trade Loss</p>
                                                                        <input  onkeyup="calRowTotal(0)" id="td_loss0"
                                                                            name="td_loss[]" 
                                                                            class="number-separator form-control" value=""
                                                                            placeholder="">
                                                                    </div>
                                                                   
                                                                @endif
                                                                
                                                                <div class="col-lg-2 col-12 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-50 mb-0">Total</p>
                                                                    <input 
                                                                        style=" border: none;background-color: transparent;resize: none;outline: none;"
                                                                        id="rowTotal0" name="rowTotal[]"
                                                                        class=" form-control" value="0 PKR" disabled>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="d-flex flex-column align-items-center justify-content-between border-start invoice-product-actions py-50 px-25">
                                                                <svg onclick="deleteItem(0)"
                                                                    xmlns="http://www.w3.org/2000/svg" width="14"
                                                                    height="14" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-x cursor-pointer font-medium-3">
                                                                    <line x1="18" y1="6" x2="6"
                                                                        y2="18"></line>
                                                                    <line x1="6" y1="6" x2="18"
                                                                        y2="18"></line>
                                                                </svg>
                                                                <div class="dropdown">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                                        height="14" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-settings cursor-pointer more-options-dropdown me-0"
                                                                        id="dropdownMenuButton" role="button"
                                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                        <circle cx="12" cy="12"
                                                                            r="3">
                                                                        </circle>
                                                                        <path
                                                                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                                                        </path>
                                                                    </svg>
                                                                    <div class="dropdown-menu dropdown-menu-end item-options-menu p-50"
                                                                        aria-labelledby="dropdownMenuButton">
                                                                        <div class="mb-1">
                                                                            <label for="discount-input"
                                                                                class="form-label">Discount</label>
                                                                            <input name="trade_dicount" type="number"
                                                                                class="form-control" id="discount-input">
                                                                        </div>
                                                                        <div class="form-row mt-50"></div>
                                                                        <div class="dropdown-divider my-1"></div>
                                                                        <div class="d-flex justify-content-between">
                                                                            <button type="button"
                                                                                class="btn btn-outline-primary btn-apply-changes waves-effect">Apply</button>
                                                                            <button type="button"
                                                                                class="btn btn-outline-secondary waves-effect">Cancel</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div id="itemRows" class="row mt-1">
                                                <div class="col-12 px-0">
                                                    <button id="addNewBtn" type="button"
                                                        class="btn btn-primary btn-sm btn-add-new waves-effect waves-float waves-light">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-plus me-25">
                                                            <line x1="12" y1="5" x2="12"
                                                                y2="19">
                                                            </line>
                                                            <line x1="5" y1="12" x2="19"
                                                                y2="12">
                                                            </line>
                                                        </svg>
                                                        <span class="align-middle">Add Item</span>
                                                    </button>
                                                </div>
                                            </div>
                                        @else
                                            <table id="investor-table" class="table">
                                                <thead class="thead-dark">
                                                    <tr style="background-color:red !important;">
                                                        <th style="width: 2px !important">#</th>
                                                        <th scope="col">name</th>
                                                        <th scope="col">unit cost</th>
                                                        <th scope="col">quantity</th>
                                                        <th scope="col">total</th>

                                                    </tr>
                                                </thead>
                                                <tbody class="inventory-iems-body" id="nventory-iems-body">

                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($purchase->items as $item)
                                                        <tr>
                                                            <td>{{ $count }}</td>
                                                            <td>{{ $item->name }}</td>
                                                            <td>{{ number_format($item->pivot->unit_cost)  }}</td>
                                                            <td>{{ $item->pivot->quantity }}</td>
                                                            <td>{{ number_format($item->pivot->quantity * $item->pivot->unit_cost )}}</td>s   
                                                        </tr>
                                                        @php
                                                            $count = $count + 1;
                                                        @endphp
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        @endif

                                    </form>
                                </div>
                                <!-- Product Details ends -->

                                <!-- Invoice Total starts -->
                                <div class="card-body invoice-padding">
                                    <div class="row invoice-sales-total-wrapper">
                                        <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">

                                        </div>
                                        <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                            <div class="invoice-total-wrapper">
                                                <hr class="my-50">
                                                <div class="invoice-total-item">
                                                    <input type="hidden" name="total_amount" id="amount_feild">
                                                    <p class="invoice-total-title">Total:</p>
                                                    @if (isset($purchase))
                                                        <p class="invoice-total-amount">{{number_format( $purchase->total )}}</p>
                                                    @else
                                                        <p id="totalAmount" class="invosice-total-amount">0 PKR</p>
                                                    @endif
                                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Invoice Total ends -->
                                <hr class="invoice-spacing mt-0">

                                <div class="card-body invoice-padding py-0">
                                    <!-- Invoice Note starts -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label for="note" class="form-label fw-bold">Note:</label>
                                                <textarea name="note" class="form-control" rows="2" id="note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Invoice Note ends -->
                                </div>
                                <div class="row p-2">
                                    <div class="col-12">
                                        @if (isset($purchase))
                                            <div class="d-flex justify-content-end">
                                                <button onclick="rePrint()" type="reset"
                                                    class="btn btn-primary">Reprint Invoice</button>
                                            </div>
                                        @else
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-2">Save</button>
                                                <button type="reset" class="btn btn-danger">Reset</button>
                                            </div>
                                        @endif

                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
            </section>
        </div>
    </div>

    <script src="{{ url('/resources/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ url('/resources/js/scripts/forms/form-select2.min.js') }}"></script>
    <script src="{{ url('/resources/js/scripts/pages/app-invoice.min.js') }}"></script>
    <script>
        var rowId = 0;
        $(document).ready(function() {
            // $("span.numbers").digits();
            $('.select2-selection__arrow').hide();
        });

        $(document).on('change','#supplier_id',function () {

            console.log("supplier_changed");
            
            
        });

        $('#addNewBtn').click(function() {
            console.log('ad-new item');
            rowId = rowId + 1;
            var maarkup = `<div id="row${rowId}" class="row">
                        <div class="mt-3 col-12 d-flex product-details-border position-relative pe-0">
                            <div class="row py-2">
                                    <div class="col-lg-1 col-12 my-lg-0 my-2">
                                    <p class="card-text col-title mb-md-2 mb-0">Item Id</p>
                                    <input name="item_id[]" id ="passId${rowId}" type="number" class="form-control" value="" placeholder="" disabled>
                                    <input name="item_id[]" id="item_id${rowId}" type="hidden" class="form-control"
                                                                    value="" placeholder="" >
                                    </div>
                                <div class="col-2">
                                    <p class="card-text col-title mb-md-2 mb-0">Item Name</p>
                                    
                                    <input autocomplete="off" id="itemBox${rowId}" class=" form-control" autocomplete="off"
                                        placeholder="Enter Item"
                                        @if($type==1) onkeyup="getItems(${rowId})" @else onkeyup="getInvItems(${rowId})" @endif
                                        >
                                    <div class="list-type" id="list${rowId}" style="position: absolute; z-index: 1;"
                                        class="card mb-4">
                                        <div id="listBody${rowId}" class="list-group">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-12 my-lg-0 my-2">
                                    <p class="card-text col-title mb-md-2 mb-0">Cost</p>
                                    <input onkeyup="calRowTotal(${rowId})" id="cost${rowId}" name="cost[]"  class="number-separator form-control" value=""
                                        placeholder="">
                                </div>
                                @if($type==2)
                                                    
                                    <div class="col-lg-2 col-12 my-lg-0 my-2">
                                        <p class="card-text col-title mb-md-2 mb-0">Curr Price</p>
                                        <input  onkeyup="calLoss(${rowId})"  id="cur_cost${rowId}"
                                            name="cost[]" 
                                            class="number-separator form-control" value=""
                                            placeholder="">
                                    </div>
                                                                                   
                                @endif
                                <div class="col-lg-1 col-12 my-lg-0 my-2">
                                    <p class="card-text col-title mb-md-2 mb-0">Qty</p>
                                    <input   onkeyup="calRowTotal(${rowId})" id="qty${rowId}" name="qty[]"
                                        type="number" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"class="form-control" value=""
                                        placeholder="">
                                </div>
                                @if($type==2)
                                                    
                                    <div class="col-lg-2 col-12 my-lg-0 my-2">
                                        <p class="card-text col-title mb-md-2 mb-0">Trade Loss</p>
                                        <input  onkeyup="calRowTotal(${rowId})" id="td_loss${rowId}"
                                            name="td_loss[]" 
                                            class="number-separator form-control" value=""
                                            placeholder="">
                                    </div>
                                                                   
                                @endif
                                <div class="col-lg-2 col-12 mt-lg-0 mt-2">
                                    <p class="card-text col-title mb-md-50 mb-0">Total</p>
                                    <input style=" border: none;background-color: transparent;resize: none;outline: none;" id="rowTotal${rowId}"  name="rowTotal[]"  class="form-control" value="0 PKR" disabled>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-center justify-content-between border-start invoice-product-actions py-50 px-25">
                                <svg onclick="deleteItem(${rowId})" xmlns="http://www.w3.org/2000/svg" width="14"
                                    height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="feather feather-x cursor-pointer font-medium-3"
                                    >
                                    <line x1="18" y1="6" x2="6"
                                        y2="18"></line>
                                    <line x1="6" y1="6" x2="18"
                                        y2="18"></line>
                                </svg>
                                <div class="dropdown">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                        height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-settings cursor-pointer more-options-dropdown me-0"
                                        id="dropdownMenuButton" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <circle cx="12" cy="12" r="3">
                                        </circle>
                                        <path
                                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                        </path>
                                    </svg>
                                    <div class="dropdown-menu dropdown-menu-end item-options-menu p-50"
                                        aria-labelledby="dropdownMenuButton">
                                        <div class="mb-1">
                                            <label for="discount-input"
                                                class="form-label">Discount</label>
                                            <input name="trade_discount" type="number" class="form-control"
                                                id="discount-input">
                                        </div>
                                        <div class="form-row mt-50"></div>
                                        <div class="dropdown-divider my-1"></div>
                                        <div class="d-flex justify-content-between">
                                            <button type="button"
                                                class="btn btn-outline-primary btn-apply-changes waves-effect">Apply</button>
                                            <button type="button"
                                                class="btn btn-outline-secondary waves-effect">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

            $('.repeater-wrapper').append(maarkup);
        })
        // var lastVall= 0;
        function calRowTotal(rowId) {

            var qty = $('#qty' + rowId).val();
            var cost = ($('#cost' + rowId).val());
            var type = $('#tran_type').val();
            var cost = Number(cost.replace(/[^0-9.-]+/g,""));
            var cost = parseFloat(cost);
            
            var old = $("#rowTotal" + rowId).val();
            old = Number(old.replace(/[^0-9.-]+/g,""));
            var total = qty * cost;
            $("#rowTotal" + rowId).val(total.toLocaleString('en-US')+" PKR");
            
            var subTotal = $("#totalAmount").text();
            subTotal =  Number(subTotal.replace(/[^0-9.-]+/g,""));
            var sum = parseFloat(subTotal) + parseFloat(total) - parseFloat(Number(old));
            $("#totalAmount").text(sum.toLocaleString('en-US')+ " PKR");
            $("#amount_feild").val(sum.toFixed(2));

            if(type==2){
                console.log(type);
                calLoss(rowId)
            }
           
        }



        function rePrint() {

            console.log('what is to be reprinted');
            // window.open({{ url('/test-pdf') }});

        }

        function getInvItems(id) {

                console.log('function callled');
                var letters = $('#itemBox' + id).val();
                if (letters.length < 2) {
                    $('#cost' + rowId).val("");
                    $('#qty' + rowId).val("");
                    $('#cur_cost' + rowId).val("");
                    $('#rowTotal' + rowId).val("");
                    $('#td_loss' + rowId).val("");
                    return;
                }
                console.log(letters);
                var investor_id = $("#select2-basic").val();
                console.log(investor_id);
                $.ajax({
                    url: "{{ route('get-investor-items') }}",
                    type: "GET",
                    data: {
                        key: letters,
                        investor_id: investor_id
                    },
                    success: function(dataResult) {
                        
                        $("#listBody"+id).empty();
                        console.log('recv2');
                        console.log(dataResult);
                        var i;
                        for (i = 0; i < dataResult.length; i++) {
                            var item = dataResult[i].item;
                            console.log(item);
                            markup = `<button id = "btnItem` + item.id +
                                `"type="button" class="list-group-item list-group-item-action" onclick="setText(` +
                                item.id + `,${id})">` + item.name + `</button>`;
                            $("#listBody"+id).append(markup);
                        }


                    },
                    error: function(xhr, status, error) {

                        var err = eval("(" + xhr.responseText + ")");
                        console.log(err);
                        alert(err);
                    },
                });
                $("#list"+id).show();

        }

        function getItems(id) {

            console.log("arg");
            // console.log(set.id);
            var letters = $('#itemBox' + id).val();
            var supplier_id = $('#supplier_id').val();
            if (letters.length < 2) {
                $('#cost' + id).val("");
                $('#qty' + id).val("");
                $('#cur_cost' + id).val("");
                $('#rowTotal' + id).val("");
                $('#td_loss' + id).val("");
                
                return;
            }
            $("#passId").val("");
            $.ajax({
                url: "{{ route('get-items') }}",
                type: "GET",
                data: {
                    key: letters,
                    supplier_id:supplier_id,
                },
                success: function(dataResult) {
                    $("#listBody" + id).empty();
                    console.log('recv1');
                    console.log(dataResult);
                    var i;
                    for (i = 0; i < dataResult.length; i++) {

                        var item = dataResult[i];
                        console.log(item);
                        markup = `<button id = "btnItem` + item.id +
                            `" type="button" class="list-group-item list-group-item-action" onclick="setText(` +
                            item.id + `,${id})">` + item.name + `</button>`;
                        $("#listBody" + id).append(markup);
                    }

                },
                error: function(xhr, status, error) {

                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err);
                    alert(err);
                },
            });
            $("#list" + id).show();
            console.log(letters);
        }

        function deleteItem(id) {
            console.log("removing");
            $('#row' + id).remove();
        }
        

        $(".content-wrapper").click(function(event) {
            console.log('clicked');
            var myClass = $(event.target).hasClass("list-group-item");
            if (myClass == true) {
                console.log("you clicked menu");

            } else {
                $(".list-type").hide();
            }
        });

        function setText(item, rowId) {
            // var item = JSON.parse(item);
            console.log($('#btnItem' + item).text());
            $("#itemBox" + rowId).val($('#btnItem' + item).text());
            $("#passId" + rowId).val(item);
            $("#item_id" + rowId).val(item);
            $("#list" + rowId).hide();
            var investor_id = $("#select2-basic").val();
            var type = $('#tran_type').val();
            console.log(type);
            if(type==2){

                $.ajax({
                url: "{{ route('get-last-purchase')}}",
                type: "GET",
                data: {
                    item_id: item,
                    investor_id:investor_id
                },
                success: function(dataResult) {
                   
                    console.log('recv1');
                    console.log(dataResult);
                    
                    $("#cost"+rowId).val(parseFloat(dataResult).toLocaleString('en-US'));
                    

                },
                error: function(xhr, status, error) {

                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err);
                    alert(err);
                },
            });

            }
             $('#qty' + rowId).val("");
            $('#cur_cost' + rowId).val("");
            $('#rowTotal' + rowId).val("");
            $('#td_loss' + rowId).val("");

        }

        function calLoss(id){
            console.log('lssigfdf');
           var orgCost = $("#cost"+id).val();
           var qty = $("#qty"+id).val();
           var curCost = $("#cur_cost"+id).val();
           orgCost = Number(orgCost.replace(/[^0-9.-]+/g,""));
           curCost = Number(curCost.replace(/[^0-9.-]+/g,""));
           var loss = (orgCost  - curCost )*qty;
           console.log(loss);
           $("#td_loss"+id).val(loss.toLocaleString('en-US'));



        }

       
    </script>
@endsection
