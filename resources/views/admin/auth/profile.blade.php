@extends('admin.admin-layouts.master')
@section('page_title','profile')
@section('profile_select','active')
@section('content')
<style>
    .inputTag {
        width: 80rem;
    }

    .labelTag {
        width: 10rem;
    }
</style>
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">

    </div>

    <div class="page-header">

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="d-flex card-header">
                    <div class="card-title"><i class="fa-solid fa-user"></i> Admin Profile</div>
                    <div class="ms-auto">
                        <a href="{{ url('admin/employee/list/page') }}">
                            <h3 class="fw-bold mb-3"> {{ __('Back') }} </h3>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label for="table_name" class="labelTag">Name</label>
                                <div class="form-group">
                                    <input value="{{ $admin->name }}" class="form-control" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label for="password" class="labelTag">Email</label>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">@</span>
                                        <input value="{{ $admin->email }}" class="form-control" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label for="table_name" class="labelTag">Designation</label>
                                <div class="form-group">
                                    <input value="{{ $admin->getDesignation->description }}" class="form-control " readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label for="table_name" class="labelTag">Department</label>
                                <div class="form-group">
                                    <input value="{{ $admin->getDepartment->departments }}" class="form-control " readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label for="table_name" class="labelTag">Employee Role</label>
                                <div class="form-group">
                                    <input value="{{ $admin->getRole->role_name }}" class="form-control" value="" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label for="table_name" class="labelTag">Employee Code</label>
                                <div class="form-group">
                                    <input value="{{ $admin->code }}" class="form-control " readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label for="table_name" class="labelTag">Contact</label>
                                <div class="form-group">
                                    <input value="{{ $admin->phone }}" class="form-control " readonly />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label for="table_name" class="labelTag">Gender</label>
                                <div class="form-group">
                                    @if($admin->gender == 1)
                                        <input value="Male" class="form-control " readonly />
                                    @elseif($admin->gender == 2)
                                        <input value="Female" class="form-control " readonly />
                                    @else
                                        <input value="Other" class="form-control " readonly />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label for="table_name" class="labelTag">Joining</label>
                                <div class="form-group">
                                    <input value="{{ $doj }}" class="form-control " readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label for="table_name" class="labelTag">Birth</label>
                                <div class="form-group">
                                    <input value="{{ $dob }}" class="form-control " readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection