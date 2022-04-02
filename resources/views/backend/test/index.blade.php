@extends('layouts.app')

@section('sub-header', 'Test')

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


        @if ($message = Session::get('hasil'))
        <div class="alert alert-success alert-dismissible fade show">
            <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
            <strong>Hasil Prediksi Menggunakan Linear Regression Sederhana : </strong> {{$message}}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            </button>
        </div>
        @endif
        <div class="card-header" style="justify-content: right;">
            <button style="margin-right: 5px;" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#basicModal">Import Data</button>
            <div class="modal fade" id="basicModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Import Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <form action="{{route('import.test')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Input File (.xlsx). NB. Sebelum Import silahkah lihat data excel dengan cara klik export</label>
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
            <a href="" style="margin-right: 5px;" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#prediksi">Predict</a>
            <div class="modal fade" id="prediksi">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Prediksi Linear Regression Sederhana</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <form action="{{route('test.predict')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Masukkan Nila X</label>
                                    <input required type="number" name="x" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Predict</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <a href="{{route('export.test')}}" class="btn btn-success btn-sm">Export</a>
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
                            <th><strong>X</strong></th>
                            <th><strong>Y</strong></th>
                            <th><strong></strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($test as $result => $key)
                            <tr>
                                <td>
                                    <div class="form-check custom-checkbox checkbox-success check-lg me-3">
                                        <input type="checkbox" class="form-check-input" id="customCheckBox2" required="">
                                        <label class="form-check-label" for="customCheckBox2"></label>
                                    </div>
                                </td>
                                <td>{{$result + $test->firstitem()}}</td>
                                <td>{{$key->X}}</td>
                                <td>{{$key->Y}}</td>

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
                                                                <label>Nilai X</label>
                                                                <input required type="number" name="name" class="form-control" value="{{$key->X}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Nilai Y</label>
                                                                <input required type="number" class="form-control" name="qty" value="{{$key->Y}}">
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
                                        <a  href="javascript:void(0)" class="btn btn-danger shadow btn-xs sharp confirmDelete"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$test->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
