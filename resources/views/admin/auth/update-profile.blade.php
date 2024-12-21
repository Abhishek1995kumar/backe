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
    @media (min-width:320px) {
        .inputTag {
            width: 80rem;
        }

        .labelTag {
            width: 10rem;
        }
    }
</style>
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">

    </div>

    <div class="page-header">
    </div>

    <form action="{{ url('admin/update/profile') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $admin->id }}" />
        <input type="hidden" name="password" value="{{ $admin->password }}" />
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex card-header">
                        <div class="card-title"><i class="fa-solid fa-database"></i> Update Profile</div>
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
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="table_name" class="labelTag">Designation</label>
                                    <div class="form-group">
                                        <select name="designation_id" id="designationId" class="form-control" style="width: 25rem;">
                                            @foreach($designation as $des)
                                                <option value="{{ $des->id }}" {{ ($admin->getDesignation && $admin->getDesignation->designation == $des->designation) ? 'selected' : '' }} >{{ $des->designation }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="table_name" class="labelTag">Department</label>
                                    <div class="form-group">
                                        <select name="department_id" id="departmentId" class="form-control" style="width: 25rem;">
                                            @foreach($department as $department)
                                                <option value="{{ $department->id }}" {{ ($admin->getDepartment && $admin->getDepartment->departments == $department->departments) ? 'selected' : '' }} >{{ $department->departments }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="table_name" class="labelTag">Employee Name</label>
                                    <div class="form-group">
                                        <input type="text" name="name" value="{{ $admin->name }}" class="form-control" style="width: 25rem;" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="password" class="labelTag">Employee Email</label>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" style="margin-left:-2rem;">@</span>
                                            <input type="text" name="email" value="{{ $admin->email }}" class="form-control" style="width: 22.2rem;" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="table_name" class="labelTag">Employee Role</label>
                                    <div class="form-group">
                                        <select name="role_id" id="roleId" class="form-control" style="width: 25rem;">
                                            @foreach($role as $role)
                                                <option value="{{ $role->id }}" {{ ($admin->getRole && $admin->getRole->role_name == $role->role_name) ? 'selected' : '' }} >{{ $role->role_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="table_name" class="labelTag">Employee Code</label>
                                    <div class="form-group">
                                        <input type="text" name="code" value="{{ $admin->code }}" class="form-control " style="width: 25rem;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="table_name" class="labelTag">Employee Contact</label>
                                    <div class="form-group">
                                        <input type="text" name="phone" value="{{ $admin->phone }}" class="form-control" style="width: 25rem;" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="table_name" class="labelTag">Employee Birth</label>
                                    <div class="form-group">
                                        <input type="date" name="dob" value="{{ $admin->dob }}" class="form-control" style="width: 25rem;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="table_name" class="labelTag">Employee Joining</label>
                                    <div class="form-group">
                                        <input type="date" name="doj" value="{{ $admin->doj }}" class="form-control" style="width: 25rem;" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="table_name" class="labelTag">Employee Gender</label>
                                    <div class="form-group">
                                        @if($admin->gender == 1)
                                            <input type="text" name="gender" value="Male" class="form-control " style="width: 25rem;" />
                                        @elseif($admin->gender == 2)
                                            <input type="text" name="gender" value="Female" class="form-control " style="width: 25rem;" />
                                        @else
                                            <input type="text" name="gender" value="Other" class="form-control " style="width: 25rem;" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="table_name" class="labelTag">Employee Image</label>
                                    <div class="form-group">
                                    <img src="{{ asset('documents/self_image/'.$admin->self_image) }}" style="border-radius:5rem;" width="40rem;" height="26rem;" alt="job image" title="job image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-5">
            <div class="col">
                <input type="submit" value="Submit" class="btn btn-primary">
            </div>
        </div>
    </form>
</div>

@endsection