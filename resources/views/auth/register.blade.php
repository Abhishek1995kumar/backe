@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-right">
        <div class="col-md-6"><img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg" height="500rem" alt="" /></div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input name="name" value="{{ old('name') }}" placeholder="name" id="userName" type="text" class="form-control @error('name') is-invalid @enderror" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" placeholder="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="passwordConfirm" placeholder="confirm password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button id="userRegistration" type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>

                                @if (Route::has('login'))
                                    <a class="btn btn-warning" href="{{ route('login') }}">{{ __('Sign In') }}</a>
                                @endif
                            </div>
                        </div>
                    </form>
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
        $('#userRegistration').click(function(e) {
            e.preventDefault();
            let data = [];
            data[0] = document.getElementById('userName');
            data[1] = document.getElementById('email');
            data[2] = document.getElementById('password');
            data[3] = document.getElementById('passwordConfirm');

            let name = /^[A-Za-z\s]{5,}$/;
            let email = /^([a-zA-Z0-9._%+-]+)@([a-zA-Z0-9.-]+)\.([a-zA-Z]{2,})$/;
            let password = /^([@$!%*?&]{0,5})([A-Za-z]{4,10})([@$!%*?&]{0,5})([A-Za-z0-9]{1,10})$/;
            let url = "{{ URL::to('/') }}/admin_assets/images/icon/order.jpg";
            let flag = false;

            for (let x = 0; x < data.length; x++) {
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

                if (x == 0 && !data[x].value.match(name)) {
                    Swal.fire({
                        title: "Message !!",
                        text: 'Please enter a valid agency name',
                        imageUrl: url,
                        imageWidth: 400,
                        imageHeight: 200,
                        html: '<input id="userNameInput" type="text" name="name" class="form-control">',
                        preConfirm: () => {
                            return new Promise((resolve) => {
                                resolve(document.getElementById('userNameInput').value);
                            });
                        },
                        didOpen: () => {
                            document.getElementById('userNameInput').focus();
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            data[0].value = result.value;  // Update the agency name field with the new value
                            if (!result.value.match(name)) {
                                Swal.fire({
                                    title: "Message !!",
                                    text: 'Please enter a valid name',
                                    imageUrl: url,
                                    imageWidth: 400,
                                    imageHeight: 200,
                                });
                            } else {
                                flag = false;
                            }
                        }
                    }).catch(Swal.noop);
                    flag = true;
                    break;
                }

                if (x == 1 && !data[x].value.match(email)) {
                    Swal.fire({
                        title: "Message !!",
                        text: 'Please enter a valid email',
                        imageUrl: url,
                        imageWidth: 400,
                        imageHeight: 200,
                        html: '<input id="emailInput" type="text" name="email" class="form-control">',
                        preConfirm: () => {
                            return new Promise((resolve) => {
                                resolve(document.getElementById('emailInput').value);
                            });
                        },
                        didOpen: () => {
                            document.getElementById('emailInput').focus();
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            data[1].value = result.value;  // Update the agency name field with the new value
                            if (!result.value.match(email)) {
                                Swal.fire({
                                    title: "Message !!",
                                    text: 'Please enter a valid email',
                                    imageUrl: url,
                                    imageWidth: 400,
                                    imageHeight: 200,
                                });
                            } else {
                                flag = false;
                            }
                        }
                    }).catch(Swal.noop);
                    flag = true;
                    break;
                }

                if (x == 2 && !data[x].value.match(password)) {
                    Swal.fire({
                        title: "Message !!",
                        text: 'Please enter a valid password',
                        imageUrl: url,
                        imageWidth: 400,
                        imageHeight: 200,
                        html: '<input id="passwordInput" type="text" name="password" class="form-control">',
                        preConfirm: () => {
                            return new Promise((resolve) => {
                                resolve(document.getElementById('passwordInput').value);
                            });
                        },
                        didOpen: () => {
                            document.getElementById('passwordInput').focus();
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            data[2].value = result.value;  // Update the agency name field with the new value
                            if (!result.value.match(password)) {
                                Swal.fire({
                                    title: "Message !!",
                                    text: 'Please enter a valid password',
                                    imageUrl: url,
                                    imageWidth: 400,
                                    imageHeight: 200,
                                });
                            } else {
                                flag = false;
                            }
                        }
                    }).catch(Swal.noop);
                    flag = true;
                    break;
                }
            }

            if (!flag) {
                if (data[2].value !== data[3].value) {
                    Swal.fire({
                        title: "Invalid Input",
                        text: 'Passwords do not match.',
                        imageUrl: url,
                        imageWidth: 400,
                        imageHeight: 200,
                    });
                    flag = true;
                }
            }

            if (!flag) {
                $('form').submit();
            }
        });
    });
</script>
@endsection
