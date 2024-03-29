@extends('template.header')
@section('section')
<div class="content-wrapper" id="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="">{{$investor->investor_name}} Inventory</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row ">
                        <div  class="col-12 table-responsive ">
                            <table id="investor-table" class="table">
                                <thead class="thead-dark">
                                    <tr style="background-color:red !important;">
                                        <th style="width: 2px !important">#</th>
                                        <th scope="col">name</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Make</th>
                                        <th scope="col">Model</th>
                                        <th scope="col">unit cost</th>
                                        <th scope="col">quantity</th>
                                        <th scope="col">Worth</th>
                                    </tr>
                                </thead>
                                <tbody class="inventory-iems-body" id="nventory-iems-body">
                                    @php
                                        $count = 1
                                    @endphp
                                    @foreach ($inventory_items as $item)
                                    <tr>
                                        <td>{{$count}}</td>
                                        <td>{{$item->item->name}}</td>
                                        <td>{{$item->item->category->category_name}}</td>
                                        <td>{{$item->item->make}}</td>
                                        <td>{{$item->item->model}}</td>
                                        <td>{{number_format($item->unit_cost)}}</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{number_format($item->quantity * $item->unit_cost)}}</td>
                                    </tr>
                                    @php
                                        $count = $count+1
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $(document).ready(function() {
            console.log('i am datatable');
            $('#investor-table').DataTable();
        });

    });
</script>
@endsection