@extends('layouts.app')

@section('sub-header', 'Product')

@section('content')
<div class="col-lg-12">
    <div class="card">
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show">
            <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
            <strong>Error!</strong> {{$error}}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            </button>
        </div>
        @endforeach
        <div class="card-header">
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#basicModal">Import Data</button>
            <div class="modal fade" id="basicModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Import Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <form action="{{route('import.product')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Input File (.xls, .csv, .xlsx)</label>
                                    <input required type="file" name="file" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-responsive-md">
                    <thead>
                        <tr>
                            <th style="width:50px;">
                                <div class="form-check custom-checkbox checkbox-success check-lg me-3">
                                    <input type="checkbox" class="form-check-input" id="checkAll" required="">
                                    <label class="form-check-label" for="checkAll"></label>
                                </div>
                            </th>
                            <th><strong>NO.</strong></th>
                            <th><strong>NAME PRODUCT</strong></th>
                            <th><strong>QTY</strong></th>
                            <th><strong>Date</strong></th>
                            <th><strong></strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $result => $key)
                            <tr>
                                <td>
                                    <div class="form-check custom-checkbox checkbox-success check-lg me-3">
                                        <input type="checkbox" class="form-check-input" id="customCheckBox2" required="">
                                        <label class="form-check-label" for="customCheckBox2"></label>
                                    </div>
                                </td>
                                <td>{{$result + $product->firstitem()}}</td>
                                <td>{{$key->name}}</td>
                                <td>{{$key->qty}}</td>
                                <td>{{$key->tgl}}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#edit_{{$key->id}}"><i class="fas fa-pencil-alt"></i></a>
                                        <div class="modal fade" id="edit_{{$key->id}}">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Data</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                        </button>
                                                    </div>
                                                    <form action="" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Name</label>
                                                                <input type="text" name="name" class="form-control" value="{{$key->name}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Quantity</label>
                                                                <input type="number" class="form-control" name="qty" value="{{$key->qty}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Date</label>
                                                                <input type="date" name="tgl" class="form-control" value="{{$key->tgl}}">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <a record="product" recordid="{{$key->id}}" href="javascript:void(0)" class="btn btn-danger shadow btn-xs sharp confirmDelete"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$product->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
