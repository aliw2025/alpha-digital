@extends('template.header')
@section('section')
<div class="content-wrapper" id="content-wrapper">
    <div class="row">
        <div class="col-md-9 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="">Items</h4>
                    </div>
                </div>
                <div class="card-body">
                   
                    <div class="row ">
                        <div class="col-12 table-responsive">
                            <table id="investor-table" class="table">
                                <thead class="thead-dark">
                                    <tr style="background-color:red !important;">

                                        <th style="width: 2px !important">#</th>
                                        <th scope="col">Item id</th>
                                        <th scope="col">Item name</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Make</th>
                                        <th scope="col">Model</th>
                                        {{-- <th scope="col">Supplier</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="set-iems-body" id="set-iems-body">
                                    @php
                                    $count = 1;
                                    @endphp
                                    @if(isset($items))
                                    @foreach ($items as $item)
                                    <tr>
                                        <th style="width: 2px !important">{{$count}}</th>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->mame }}</td>
                                        <td>{{ $item->category }}</td>
                                        <td>{{ $item->make }}</td>
                                        <td>{{ $item->model }}</td>
                                        {{-- <td>{{ $item->Supplier }}</td> --}}
                                        <td >
                                            <div class="d-flex align-items-center">

                                            <form class="" method="POST" autocomplete="on" action="{{ route('investor.destroy',$inv->id)}}">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <button style="border:0ch;background-color:white !important;" id="btnDel{{$inv->id}}" type="submit" class=""><i data-feather='trash-2'></i></button>
                                            </form>
                                            <form class="" method="GET  " autocomplete="on" action="{{ route('investor.edit',$inv->id)}}">
                                                @csrf
                                                {{ method_field('GET') }}
                                                <button style="border:0ch;background-color:white !important;" id="btnDel{{$inv->id}}" type="submit" class=""><i data-feather='edit'></i></button>
                                            </form>
                                        </div>
                                        </td>
                                        @php
                                        $count = $count+1;
                                        @endphp
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    <div>
                        <h4 class="text-center">{{isset($item)? "Update item":'Add New item'}}</h4>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($item))
                    <div class="d-flex justify-content-end">
                        <div>
                            <a href='{{route("item.index")}}'" type=" reset" class="">
                                Add New
                            </a>
                        </div>
                    </div>
                    @endif
                    <div class="">
                        <form method="POST" class="form form-vertical" autocomplete="on" action=" {{isset($item)? route('item.update',$item) :route('item.store')}}">
                            @csrf
                            <div class="row ">
                                <div class=" ">
                                    <div class="mb-1">
                                        <label   class="form-label" for="first-name-vertical">item Name</label>
                                        <input value="{{old('name',isset($item)? $item->name  :'')}}"  type="text" id="itemName" class=" @error('name') is-invalid @enderror form-control" name="name" placeholder="item Name">
                                        @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class=" ">
                                    <div class="mb-1">
                                        <label   class="form-label" for="first-name-vertical">Category</label>
                                        <input value="{{old('category',isset($item)? $item->category  :'')}}"  type="text" id="cateogoryName" class=" @error('category') is-invalid @enderror form-control" name="category" placeholder="Category">
                                        @error('category')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class=" ">
                                    <div class="mb-1">
                                        <label   class="form-label" for="first-name-vertical">make</label>
                                        <input value="{{old('make',isset($item)? $item->make  :'')}}"  type="text" id="cateogoryName" class=" @error('make') is-invalid @enderror form-control" name="make" placeholder="make">
                                        @error('make')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class=" ">
                                    <div class="mb-1">
                                        <label   class="form-label" for="first-name-vertical">model</label>
                                        <input value="{{old('model',isset($item)? $item->model  :'')}}"  type="text" id="cateogoryName" class=" @error('model') is-invalid @enderror form-control" name="model" placeholder="model">
                                        @error('model')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                               
                            
                                <div class="">
                                    @if (isset($item))
                                    {{ method_field('PUT') }}
                                    @endif
                                   
                                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">{{isset($item)? 'Update': 'Add'}}</button>
                                    <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function() {

        $(document).ready(function() {
            $('#investor-table').DataTable();
        });

    });
</script>
@endsection