@extends('admin.admin-layouts.master')
@section('page_title','profile')
@section('profile_select','active')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
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

    <form action="{{ url('admin/update/password') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $admin->id }}" />
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex card-header">
                        <div class="card-title"><i class="fa-solid fa-database"></i> {{ __('Update Password')}} </div>
                        <div class="ms-auto">
                            <a href="{{ url('admin/employee/list/page') }}">
                                <h3 class="fw-bold mb-3"> {{ __('Back') }} </h3>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
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
                                    <label for="password" class="labelTag" style="margin-bottom: 1rem;">Email</label>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" style="margin-left:-2rem;">@</span>
                                            <input type="text" name="email" value="{{ $admin->email }}" class="form-control" style="width: 22.2rem;" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="table_name" class="labelTag">Old Password</label>
                                    <div class="form-group">
                                        <input value="{{ $admin->default_password }}" class="form-control" style="width: 25rem;" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="password" class="labelTag" style="margin-bottom: 1rem;">Current Password</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="current_password" id="currentPaasword" class="form-control" style="width: 23rem; " placeholder="please enter new current password" />
                                            <span id="CPasswordSpan"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="password">New Password</label>
                                    <div class="form-group">
                                        <input type="text" name="new_password" id="newPassword" class="form-control" style="width: 24.7rem; margin-left:2rem;" placeholder="please enter new password" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="password" class="labelTag" style="margin-bottom: 1rem;">Confirmed Password</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="new_password_confirmation" id="confirmedNewPassword" class="form-control" style="width: 23rem;" placeholder="please enter new confirmed password" />
                                        </div>
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
                <input type="submit" id="changePasswordForm" value="Submit" class="btn btn-primary">
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#changePasswordForm').on('click', function(e) {
            e.preventDefault();
            let data = [
                document.getElementById("currentPaasword"),
                document.getElementById("newPassword"),
                document.getElementById("confirmedNewPassword"),
            ];
            let url = "{{ URL::to('/') }}/admin_assets/images/icon/order.jpg";
            let flag = false;
            for(let x=0; x<data.length; x++){
                if (data[x].value == '') {
                    Swal.fire({
                        title: "Message !!",
                        text: 'Please enter ' + data[x].placeholder,
                        imageUrl: url,
                        imageWidth: 400,
                        imageHeight: 200,
                    });
                    flag = true;
                    break;
                }
            }

            if (!flag) {
                if (data[1].value !== data[2].value) {
                    Swal.fire({
                        title: "Invalid Input",
                        text: 'New passwords and confirmed new password does not match.',
                        imageUrl: url,
                        imageWidth: 400,
                        imageHeight: 200,
                    });
                    flag = true;
                }
            }

            if (!flag) {
                $(this).closest('form').submit();
            }
        })
        // $("#currentPaasword").keyup(function() {
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     let current_password = $('#currentPaasword').val();
        //     $.ajax({
        //         type:"POST",
        //         url:"{{ url('update/password') }}",
        //         data: {
        //             current_password:current_password
        //         },
        //         success: function(result) {
        //             if(result=="true") {
        //                 $('CPasswordSpan').html('Current Password is match, go next step');
        //             } else {
        //                 $('CPasswordSpan').html('Current Password is not match, please check and try again');
        //             }
        //         }, 
        //         error: function(err) {

        //         }
        //     });
        // });
    });
</script>
@endsection