@extends('admin.admin-layouts.master')
@section('page_title','Bulk Employee Onboarding')
@section('admin_select','active')
@section('content')
    <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    </div>

    <div class="page-header">
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                @if($whichFunctionIsCreateExcel == "bulk Employee Onboarding")
                    <div class="d-flex card-header">
                        <div class="card-title"><i class="fa-solid fa-user"></i> Sample Employee Onboarding Excel</div>
                        <div class="ms-auto">
                            @if(session()->has('message'))
                                <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                                    {{ session('message') }}  
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div> 
                            @endif
                            <a href="{{ url('admin/employee/list/page') }}">
                                <h3 class="fw-bold mb-3"> {{ __('Back') }} </h3>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            <h1 class="mb10">Download Employee Onboarding Sample Excel</h1>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="{{ $excelDownload }}" class="btn btn-success card-title">
                                            <span style="margin-right: 4px;">DownLoad Employee Onboarding Link</span> <i class="fa-solid fa-download"></i>
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ url('employee/show-onboarding') }}" class="btn btn-success card-title">Upload Employee Onboarding</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($whichFunctionIsCreateExcel == "download Sub Module Excel Sheet")
                    <div class="d-flex card-header">
                        <div class="card-title"><i class="fa-solid fa-user"></i> Sample Sub Module Excel</div>
                        <div class="ms-auto">
                            @if(session()->has('message'))
                                <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                                    {{ session('message') }}  
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div> 
                            @endif
                            <a href="{{ url('admin/module/sub/list') }}">
                                <h3 class="fw-bold mb-3"> {{ __('Back') }} </h3>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            <h1 class="mb10">Download Sub Module Sample Excel</h1>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="{{ $excelDownload }}" class="btn btn-success card-title">
                                            <span style="margin-right: 4px;">Sub Module DownLoad Link</span> <i class="fa-solid fa-download"></i>
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ url('admin/bulk/sub/module/create') }}" class="btn btn-success card-title">Upload Sub Module</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($whichFunctionIsCreateExcel == "download Child Module Excel Sheet")
                    <div class="d-flex card-header">
                        <div class="card-title"><i class="fa-solid fa-user"></i> Sample Child Module Excel</div>
                        <div class="ms-auto">
                            @if(session()->has('message'))
                                <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                                    {{ session('message') }}  
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div> 
                            @endif
                            <a href="{{ url('admin/child/module/list') }}">
                                <h3 class="fw-bold mb-3"> {{ __('Back') }} </h3>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            <h1 class="mb10">Download Child Module Sample Excel</h1>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="{{ $excelDownload }}" class="btn btn-success card-title">
                                        <span style="margin-right: 4px;">Child Module DownLoad Link</span> <i class="fa-solid fa-download"></i>
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ url('admin/bulk/sub/module/create') }}" class="btn btn-success card-title">Upload Child Module</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
