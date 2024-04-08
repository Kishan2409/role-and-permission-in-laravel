@extends('layouts.app')
@section('main')

    @if (auth()->user()->hasPermission('profile.edit'))
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> {{ __('Profile') }}</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active"> {{ __('Profile') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                    @if (auth()->user()->hasPermission('profile.destroy'))
                        <div class="row">
                            <div class="col-md-12">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    @endif

                </div>
            </section>
        </div>
    @endif

@endsection
@section('script')
    {{-- success alert --}}
    @if (session('status'))
        <script>
            Swal.fire({
                title: "Success",
                text: "{{ Session::get('status') }}",
                icon: 'success',
                showCloseButton: true,
                confirmButtonText: '<i class="fa-regular fa-thumbs-up"></i> Great!',
            });
        </script>
    @endif

    {{-- error alert --}}
    @if (session('error'))
        <script>
            Swal.fire({
                title: "Error",
                text: "{{ Session::get('error') }}",
                icon: 'error',
                showCloseButton: true,
                confirmButtonText: 'Ok !',
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $('#profileupdate').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: '{{ url('checkemail_edit') }}',
                            type: "post",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                email: function() {
                                    var email = $('#email').val();
                                    return email;
                                },
                                id: function() {
                                    var id = $('#id').val();
                                    return id;
                                }
                            }
                        }
                    }
                },
                messages: {
                    name: {
                        required: "Name is required."
                    },
                    email: {
                        required: "Email address is required.",
                        email: "Please enter a valid email address.",
                        remote: "Email address already exists !"
                    }
                },
                errorPlacement: function(error, element) {
                    error.css('color', 'red').appendTo(element.parent("div"));
                },
                submitHandler: function(form) {
                    $(':button[type="submit"]').prop('disabled', true);
                    form.submit();
                }
            });

            $('#passwordupdate').validate({
                rules: {
                    current_password: {
                        required: true,
                        minlength: 8,
                    },
                    password: {
                        required: true,
                        minlength: 8,
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 8,
                        equalTo: "#update_password_password"
                    }
                },
                messages: {
                    current_password: {
                        required: "Current password is required.",
                        minlength: "Please enter at least 8 characters."
                    },
                    password: {
                        required: "New password is required.",
                        minlength: "Please enter at least 8 characters."
                    },
                    password_confirmation: {
                        required: "Confirm password is required.",
                        minlength: "Please enter at least 8 characters.",
                        equalTo: "Confirm password is not same as password."
                    }
                },
                errorPlacement: function(error, element) {
                    error.css('color', 'red').appendTo(element.parent("div"));
                },
                submitHandler: function(form) {
                    $(':button[type="submit"]').prop('disabled', true);
                    form.submit();
                }
            });

            $('#profiledestroy').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8,
                    }
                },
                messages: {
                    password: {
                        required: "Password is required.",
                        minlength: "Please enter at least 8 characters."
                    },
                },
                errorPlacement: function(error, element) {
                    error.css('color', 'red').appendTo(element.parent("div"));
                },
                submitHandler: function(form) {
                    $(':button[type="submit"]').prop('disabled', true);
                    form.submit();
                }
            });
        });
    </script>
@endsection
