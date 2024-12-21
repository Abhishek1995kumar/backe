@extends('admin.admin-layouts.master')
@section('page_title','Bulk Employee Onboarding')
@section('admin_select','active')
@section('content')
<style>
    .customWidth{
        width: 60%;
    }
</style>
@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">

    </div>

    <div class="page-header">

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="d-flex card-header">
                    <div class="card-title"><i class="fa-solid fa-user"></i> Sample Employee Onboarding Excel</div>
                    <div class="ms-auto">
                        <a href="{{ url('admin/employee/list/page') }}">
                            <h3 class="fw-bold mb-3"> {{ __('Back') }} </h3>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row ">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if(Session::has('error'))
                        <p class="invalid-feedback"> {{ Session::get('error') }} </p>
                        @endif

                        @if(Session::has('success'))
                        <p class="invalid-feedback"> {{ Session::get('success') }} </p>
                        @endif
                    </div>
                    <form action="{{ url('admin/sample/download') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row ">
                            <div class="col-md-6 mb-3">
                                <select name="department_id" class="form-control" aria-label="Select Department">
                                    <option selected disabled>-- Select Department Name --</option>
                                    @foreach($departments as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->departments }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-8 offset-md-0">
                                <button id="sampleOnboardExcel" type="submit" class="btn btn-primary">
                                    {{ __('Sample Excel Download') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection