@extends('admin.admin-layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-right">
        <div class="col-md-6"><img src="{{ asset('master/assets/img/order.png') }}" height="500rem" alt="" /></div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ __('Login') }}
                </div>
                <div class="card-body">
                    @if($errors->any())
                        @foreach($errors->any() as $error)
                            <p class="invalid-feedback"> {{ $error }} </p>
                        @endforeach
                    @endif

                    @if(Session::has('error'))
                        <p class="invalid-feedback"> {{ Session::get('error') }} </p>
                    @endif

                    @if(Session::has('success'))
                        <p class="invalid-feedback"> {{ Session::get('success') }} </p>
                    @endif  
                    <form method="POST" action="{{ route('admin.login.submit') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="form-control @error('email') is-invalid @enderror" />

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
                                <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control @error('password') is-invalid @enderror" />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button id="adminLogin" type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
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
        $('#adminLogin').click(function(e) {
            e.preventDefault();
            let data = [];
            data[0] = document.getElementById('email');
            data[1] = document.getElementById('password');
            let url = "{{ asset('master/assets/img/order.png') }}";
            console.log(url);        
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
                
                if (x == 0 && !data[x].value.match(email)) {
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
                            data[0].value = result.value;  // Update the agency name field with the new value
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
                
                if (x == 1 && !data[x].value.match(password)) {
                    Swal.fire({
                        title: "Please enter password",
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
                            data[1].value = result.value;  // Update the agency name field with the new value
                            if (!result.value.match(password)) {
                                Swal.fire({
                                    title: "Please enter a valid password",
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
                $('form').submit();
            }
        });
    });
</script>
@endsection

