@extends('admin.admin-layouts.master')
@section('page_title','Register')
@section('register_select','active')
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
                    <div class="card-title"><i class="fa-solid fa-user"></i> Employee Onboarding</div>
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
                    <form action="{{ url('admin/register/submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row ">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex">
                                    <label for="department_id" class="me-3 col-md-4 col-form-label text-md-end">{{ __('Department') }}</label>
                                    <div class="col-md-6 customWidth">
                                        <select name="department_id" placeholder="name" id="departmentId" type="text" class="form-control @error('department_id') is-invalid @enderror" autocomplete="department_id"  autofocus>
                                            <option selected disabled value="">select department</option>
                                            @if($departments)
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->departments }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        @error('department_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="d-flex">
                                    <label for="designation_id" class="col-md-4 col-form-label text-md-end me-3">{{ __('Designation') }}</label>
                                    <div class="col-md-6">
                                        <select name="designation_id" placeholder="designation id" id="designationId" type="text" class="form-control @error('designation_id') is-invalid @enderror" autocomplete="designation_id"  autofocus>
                                            <option selected disabled value="">select designation</option>
                                            @if($designations)
                                                @foreach($designations as $des)
                                                    <option value="{{ $des->id }}" >{{ $des->designation }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        @error('designation_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex">
                                    <label for="role_id" class="me-3 col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>

                                    <div class="col-md-6">
                                        <select name="role_id" placeholder="role id" id="roleId" type="text" class="form-control @error('role_id') is-invalid @enderror" autocomplete="role_id"  autofocus>
                                            <option selected disabled value="">select role</option>
                                            @if($roles)
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}" >{{ $role->role_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('role_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="d-flex">
                                    <label for="name" class="me-3 col-md-4 col-form-label text-md-end">{{ __('Employee Name') }}</label>

                                    <div class="col-md-6">
                                        <input name="name" value="{{ old('name') }}" placeholder="name" id="name" type="text" class="form-control @error('name') is-invalid @enderror" autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex">
                                    <label for="code" class="me-3 col-md-4 col-form-label text-md-end">{{ __('Employee Code') }}</label>

                                    <div class="col-md-6">
                                        <input name="code" value="{{ old('code') }}" placeholder="employee code" id="code" type="text" class="form-control @error('code') is-invalid @enderror" autocomplete="code" autofocus>

                                        @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div> 

                            <div class="col-md-6 mb-3">
                                <div class="d-flex">
                                    <label for="phone" class="me-3 col-md-4 col-form-label text-md-end">{{ __('Employee Contact') }}</label>

                                    <div class="col-md-6">
                                        <input name="phone" value="{{ old('phone') }}" id="phone" type="text" placeholder="contact number" class="form-control @error('phone') is-invalid @enderror" autocomplete="phone">

                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex">
                                    <label for="pancard_document" class="me-3 col-md-4 col-form-label text-md-end">{{ __('Employee Pancard') }}</label>

                                    <div class="col-md-6">
                                        <input name="pancard_document" value="{{ old('pancard_document') }}" id="pancardDocument" type="file" placeholder="pancard document" class="form-control @error('pancard_document') is-invalid @enderror" autocomplete="pancard_document">

                                        @error('pancard_document')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex">
                                    <label for="adhaar_document" class="me-3 col-md-4 col-form-label text-md-end">{{ __('Employee Adhaar') }}</label>

                                    <div class="col-md-6">
                                        <input name="adhaar_document" value="{{ old('adhaar_document') }}" id="adhaarDocument" type="file" placeholder="adhaar document" class="form-control @error('adhaar_document') is-invalid @enderror" autocomplete="adhaar_document">

                                        @error('adhaar_document')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex">
                                    <label for="self_image" class="me-3 col-md-4 col-form-label text-md-end">{{ __('Employee Image') }}</label>

                                    <div class="col-md-6">
                                        <input name="self_image" value="{{ old('self_image') }}" id="selfImage" type="file" placeholder="self document" class="form-control @error('self_image') is-invalid @enderror" autocomplete="self_image">

                                        @error('self_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="d-flex">
                                    <label for="address" class="me-3 col-md-4 col-form-label text-md-end">{{ __('Employee Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="address" type="text" placeholder="address" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" autocomplete="address">

                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex">
                                    <label for="email" class="me-3 col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" placeholder="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                    <label for="gender" class="me-3 col-md-4 col-form-label text-md-end">{{ __('gender') }}</label>

                                    <div class="col-md-6">
                                        <select name="gender" value="{{ old('gender') }}" id="gender" placeholder="gender" class="form-control @error('gender') is-invalid @enderror"  autocomplete="gender">
                                            <option selected disabled value="">select gender</option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                            <option value="3">Other</option>
                                        </select>
                                        @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5" style="border-top: 1px solid #BCBCBC !important; padding: 1rem;">
                            <h5>Employee Experience</h5>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered text-center" id="employeeOnboardingExperience" style="border: 1px solid grey;">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">Add</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">company</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">role</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">experience</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">salary</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">project</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">description</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">documents</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">doj</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">doe</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableColumn" class="col-md-12">
                                            <tr id="">
                                                <td style="border: 1px solid #a9a5a5;">
                                                    <a type="button" id="addButton" class="fa fa-plus"></a>
                                                </td>
                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="text" name="company[]" id="" class="form-control @error('company') is-invalid @enderror" placeholder="previous company" style="width: 15rem;" >
                                                        <span class="text-danger">
                                                            @error("company")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="role[]" type="text" class=" form-control @error('role') is-invalid @enderror" placeholder="employee role" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("role")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="text" name="experience[]" class="form-control @error('experience') is-invalid @enderror" placeholder="employee experience" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("experience")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="number" name="salary[]" class="form-control @error('salary') is-invalid @enderror" placeholder="salary" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("salary")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="text" name="project_title[]" class="form-control" placeholder="project title" style="width:25rem;">
                                                        <span class="text-danger">
                                                            @error("project_title")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="description[]" type="text" class="form-control @error('description') is-invalid @enderror" placeholder="description" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("description")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="documents[]" type="file" class="form-control @error('documents') is-invalid @enderror" placeholder="documents" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("documents")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="doj[]" type="date" class="form-control @error('doj') is-invalid @enderror" placeholder="doj" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("doj")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="doe[]" type="date" class="form-control @error('doe') is-invalid @enderror" placeholder="doe" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("doe")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5" style="border-top: 1px solid #BCBCBC !important; padding: 1rem;">
                            <h5>Employee Bank Details</h5>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered text-center" id="employeeOnboardingBank" style="border: 1px solid grey;">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">account holder</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">bank name</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">ifsc code</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">branch name</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">account number</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">bank destination</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">bank opening date</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">nominee name</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableColumn" class="col-md-12">
                                            <tr id="">
                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="text" name="account_holder" id="" class="form-control @error('account_holder') is-invalid @enderror" placeholder="account holder" style="width: 15rem;" >
                                                        <span class="text-danger">
                                                            @error("account_holder")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="bank_name" type="text" class=" form-control @error('bank_name') is-invalid @enderror" placeholder="bank name" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("bank_name")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="text" name="ifsc_code" class="form-control @error('ifsc_code') is-invalid @enderror" placeholder="ifsc code" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("ifsc_code")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="text" name="branch_name" class="form-control @error('branch_name') is-invalid @enderror" placeholder="branch name" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("branch_name")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="account_number" type="text" class="form-control @error('account_number') is-invalid @enderror" placeholder="account number" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("account_number")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="bank_destination" type="text" class="form-control @error('bank_destination') is-invalid @enderror" placeholder="bank destination" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("bank_destination")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="bank_opening_date" type="date" class="form-control @error('bank_opening_date') is-invalid @enderror" placeholder="bank opening date" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("bank_opening_date")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="nominee_name" type="text" class="form-control @error('nominee_name') is-invalid @enderror" placeholder="nominee name" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("nominee_name")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5" style="border-top: 1px solid #BCBCBC !important; padding: 1rem;">
                            <h5>Employee Salary</h5>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered text-center" id="employeeOnboardingSalary" style="border: 1px solid grey;">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">bonus</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">annual</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">medical</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">monthly</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">basic pay</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">net salary</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">base salary</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">gross salary</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">bonus applicable</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">house rent allowance</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">travelling allowance</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">tax deducted at source</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">bonus date</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">applicable from</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">applicable to</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">start from</th>
                                                <th class="col-md-1" style="border: 1px solid #a9a5a5;">end to</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableColumn" class="col-md-12">
                                            <tr id="">
                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="text" name="bonus" id="" class="form-control @error('bonus') is-invalid @enderror" placeholder="bonus" style="width: 15rem;" >
                                                        <span class="text-danger">
                                                            @error("bonus")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="annual" type="number" class=" form-control @error('annual') is-invalid @enderror" placeholder="annual" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("annual")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="number" name="medical" class="form-control @error('medical') is-invalid @enderror" placeholder="medical" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("medical")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="number" name="monthly" class="form-control @error('monthly') is-invalid @enderror" placeholder="monthly" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("monthly")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="number" name="basic_pay" class="form-control @error('basic_pay') is-invalid @enderror" placeholder="basic pay" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("basic_pay")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="number" name="net_salary" class="form-control @error('net_salary') is-invalid @enderror" placeholder="net salary" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("net_salary")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="number" name="base_salary" class="form-control @error('base_salary') is-invalid @enderror" placeholder="base salary" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("base_salary")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="number" name="gross_salary" class="form-control @error('gross_salary') is-invalid @enderror" placeholder="gross salary" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("gross_salary")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <select type="number" name="bonus_applicable" class="form-control @error('bonus_applicable') is-invalid @enderror" placeholder="monthly" style="width: 15rem;" />
                                                            <option selected disabled value="">select bonus applicable</option>
                                                            <option value="1">yes</option>
                                                            <option value="0">no</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            @error("bonus_applicable")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="number" name="house_rent_allowance" class="form-control @error('house_rent_allowance') is-invalid @enderror" placeholder="house rent allowance" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("house_rent_allowance")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input type="number" name="travelling_allowance" class="form-control @error('travelling_allowance') is-invalid @enderror" placeholder="travelling allowance" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("travelling_allowance")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="tax_deducted_at_source" type="text" class="form-control @error('tax_deducted_at_source') is-invalid @enderror" placeholder="tax deducted at source" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("tax_deducted_at_source")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="bonus_date" type="date" class="form-control @error('bonus_date') is-invalid @enderror" placeholder="bonus date" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("bonus_date")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="applicable_from" type="date" class="form-control @error('applicable_from') is-invalid @enderror" placeholder="applicable from" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("applicable_from")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="applicable_to" type="date" class="form-control @error('applicable_to') is-invalid @enderror" placeholder="applicable to" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("applicable_to")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="start_from" type="date" class="form-control @error('start_from') is-invalid @enderror" placeholder="start_from" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("start_from")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>

                                                <td style="border: 1px solid #a9a5a5;">
                                                    <div class="form-group">
                                                        <input name="end_to" type="date" class="form-control @error('end_to') is-invalid @enderror" placeholder="end to" style="width: 15rem;" />
                                                        <span class="text-danger">
                                                            @error("end_to")
                                                            {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-8 offset-md-0">
                                <button id="adminRegistration" type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        let x=0
        $('#addButton').on('click', function() {
            x++;
            let html = `
                    <tbody id="tableColumn_${x}" class="col-md-12">
                        <tr id="">
                            <td style="border: 1px solid #a9a5a5;">
                                <a type="button" id="nextButton" class="fa fa-minus removeTr"></a>
                            </td>
                            <td style="border: 1px solid #a9a5a5;">
                                <div class="form-group">
                                    <input type="text" name="company[]" id="" class="form-control @error('company') is-invalid @enderror" placeholder="previous company" style="width: 15rem;" >
                                </div>
                            </td>

                            <td style="border: 1px solid #a9a5a5;">
                                <div class="form-group">
                                    <input name="role[]" type="text" class=" form-control @error('role') is-invalid @enderror" placeholder="employee role" style="width: 15rem;" />
                                </div>
                            </td>

                            <td style="border: 1px solid #a9a5a5;">
                                <div class="form-group">
                                    <input type="text" name="experience[]" class="form-control @error('experience') is-invalid @enderror" placeholder="employee experience" style="width: 15rem;" />
                                </div>
                            </td>

                            <td style="border: 1px solid #a9a5a5;">
                                <div class="form-group">
                                    <input type="number" name="salary[]" class="form-control @error('salary') is-invalid @enderror" placeholder="salary" style="width: 15rem;" />
                                 </div>
                            </td>

                            <td style="border: 1px solid #a9a5a5;">
                                <div class="form-group">
                                    <input type="text" name="project_title[]" class="form-control" placeholder="project title" style="width:25rem;">
                                </div>
                            </td>

                            <td style="border: 1px solid #a9a5a5;">
                                <div class="form-group">
                                    <input name="description[]" type="text" class="form-control @error('description') is-invalid @enderror" placeholder="description" style="width: 15rem;" />
                                </div>
                            </td>

                            <td style="border: 1px solid #a9a5a5;">
                                <div class="form-group">
                                    <input name="documents[]" type="file" class="form-control @error('documents') is-invalid @enderror" placeholder="documents" style="width: 15rem;" />
                                </div>
                            </td>

                            <td style="border: 1px solid #a9a5a5;">
                                <div class="form-group">
                                    <input name="doj[]" type="date" class="form-control @error('doj') is-invalid @enderror" placeholder="doj" style="width: 15rem;" />
                                </div>
                            </td>

                            <td style="border: 1px solid #a9a5a5;">
                                <div class="form-group">
                                    <input name="doe[]" type="date" class="form-control @error('doe') is-invalid @enderror" placeholder="doe" style="width: 15rem;" />
                                </div>
                            </td>
                        </tr>
                    </tbody>
            `;
            $('#employeeOnboardingExperience').append(html);
            $('#employeeOnboardingExperience').on('click', '.removeTr', function() {
                $(this).closest('tbody').remove();
            });
        });
    });
</script>
@endsection