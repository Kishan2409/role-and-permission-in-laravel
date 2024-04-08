@extends('layouts.app')

@section('main')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> {{ __('User') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"> {{ __('Edit User') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Edit User</h3>
                    </div>
                    <form method="POST" id="user">
                        @csrf
                        <div class="card-body">
                            <div class="row mb-1">
                                <div class="col-md-6 mb-1">
                                    <label for="role">User Role<spna class="text-danger">*</spna></label>
                                    <select class="form-control roles" id="role" name="role">
                                        <option></option>
                                        @foreach ($role as $role)
                                            @role('superadmin|admin')
                                                @if (Auth::user()->hasRole('superadmin'))
                                                    <option value="{{ $role->id }}"
                                                        {{ $data->roles->first()->id == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}</option>
                                                @else
                                                    @if ($role->id != 1)
                                                        <option value="{{ $role->id }}"
                                                            {{ $data->roles->first()->id == $role->id ? 'selected' : '' }}>
                                                            {{ $role->name }}</option>
                                                    @endif
                                                @endif
                                            @else
                                                @if ($role->id != 1 && $role->id != 2)
                                                    <option value="{{ $role->id }}"
                                                        {{ $data->roles->first()->id == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}</option>
                                                @endif
                                            @endrole
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <input type="hidden" name="id" id="id" class="form-control"
                                    placeholder="Enter User id" value="{{ $data->id }}">
                                <div class="col-md-6 mb-1">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Enter User Name" value="{{ $data->name }}">
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label for="email">Email<span class="text-danger">*</span></label>
                                    <input type="text" name="email" id="email" class="form-control"
                                        placeholder="Enter Emali Address" value="{{ $data->email }}">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-6 mb-1">
                                    <label for="password">Password</label>
                                    <div class="input-group">

                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Enter Password">

                                        <span class="input-group-append" id="inputGroupPrepend">
                                            <button tabindex="-1" type="button" id="password_btn" class="btn btn-light">
                                                <i id="pass_btn" class="fa-solid fa-lock"></i>
                                            </button>
                                        </span>

                                        <div class="col-md-12"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label for="con_password">Confirm Password</label>
                                    <div class="input-group">

                                        <input type="password" name="con_password" id="con_password" class="form-control"
                                            placeholder="Enter Confirm Password">

                                        <span class="input-group-append" id="inputGroupPrepend">
                                            <button tabindex="-1" type="button" id="password_confirmation_btn"
                                                class="btn btn-light">
                                                <i id="pass_con_btn" class="fa-solid fa-lock"></i>
                                            </button>
                                        </span>

                                        <div class="col-md-12"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <label>Permission</label>
                                    <div class="row" id="permission-container">
                                        @foreach ($permissions as $model => $modelPermissions)
                                            <div class="card w-25 m-1">
                                                <div class="card-header">
                                                    <div class="icheck-primary d-inline ms-1">
                                                        @php
                                                            $allPermissionsChecked = true;
                                                        @endphp
                                                        @foreach ($modelPermissions as $permission)
                                                            @unless (in_array($permission->id, $approvedUserPermissions))
                                                                @php
                                                                    $allPermissionsChecked = false;
                                                                @endphp
                                                            @break
                                                        @endunless
                                                    @endforeach
                                                    <input type="checkbox" class="checkModel"
                                                        id="content{{ $model }}"
                                                        data-model="{{ $model }}"
                                                        {{ $allPermissionsChecked ? 'checked' : '' }}>
                                                    <label for="content{{ $model }}"
                                                        class="text-dark">{{ $model }}</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @foreach ($modelPermissions as $permission)
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" class="chk"
                                                            id="content{{ $permission->id }}" name="permission[]"
                                                            data-model="{{ $model }}"
                                                            value="{{ $permission->id }}"
                                                            {{ in_array($permission->id, $approvedUserPermissions) ? 'checked' : '' }}>
                                                        <label
                                                            for="content{{ $permission->id }}">{{ $permission->description }}</label><br>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-1">
                                <button class="btn btn-info">Save</button>
                                <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {

        // Function to handle master checkbox change
        $("body").on("change", ".checkModel", function() {
            const model = $(this).data('model');
            $(`.chk[data-model="${model}"]`).prop('checked', $(this).prop("checked"));
        });

        // Function to handle child checkbox change
        $("body").on("change", ".chk", function() {
            const model = $(this).data('model');
            const allChecked = $(`.chk[data-model="${model}"]:checked`).length === $(
                `.chk[data-model="${model}"]`).length;
            $(`.checkModel[data-model="${model}"]`).prop('checked', allChecked);
        });
        //select 2
        $(".roles").select2({
            placeholder: "Select user role",
            allowClear: true,
            theme: 'bootstrap4'
        });

        //validation
        $('#user').validate({
            rules: {
                role: {
                    required: true,
                },
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
                },
                password: {
                    minlength: 8,
                },
                con_password: {
                    minlength: 8,
                    equalTo: "#password"
                }
            },
            messages: {
                role: {
                    required: "Role is required.",
                },
                name: {
                    required: "Name is required.",
                },
                email: {
                    required: "Email is required.",
                    email: "Please enter a valid email address.",
                    remote: "Email address already exists !",
                },
                password: {
                    minlength: "Please enter at least 8 characters."
                },
                con_password: {
                    minlength: "Please enter at least 8 characters.",
                    equalTo: "Confirm Password is not same as password."
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

        //password_eye_btn for view enter password
        $("#password_btn").click(function(e) {
            e.preventDefault();

            var input = $("#password");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
                $('#pass_btn').removeClass('fa-solid fa-lock');
                $('#pass_btn').addClass('fa-solid fa-unlock-keyhole');
            } else {
                input.attr("type", "password");
                $('#pass_btn').removeClass('fa-solid fa-unlock-keyhole');
                $('#pass_btn').addClass('fa-solid fa-lock');
            }
        });

        //password_confirmation_eye_btn for view enter password
        $("#password_confirmation_btn").click(function(e) {
            e.preventDefault();
            var input = $("#con_password");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
                $('#pass_con_btn').removeClass('fa-solid fa-lock');
                $('#pass_con_btn').addClass('fa-solid fa-unlock-keyhole');
            } else {
                input.attr("type", "password");
                $('#pass_con_btn').removeClass('fa-solid fa-unlock-keyhole');
                $('#pass_con_btn').addClass('fa-solid fa-lock');
            }
        });

        $('#role').change(function(e) {
            e.preventDefault();
            var roleid = $(this).val();

            $.ajax({
                type: "get",
                url: "{{ route('users.create') }}",
                data: {
                    'roleid': roleid,
                },
                success: function(response) {
                    var permissionContainer = $('#permission-container');
                    permissionContainer.empty(); // Clear previous permissions

                    $.each(response.permissions, function(model, permissions) {
                        var modelCard = $(
                            '<div class="card w-25 m-1"></div>'
                        );
                        var modelHeader = $(
                            '<div class="card-header"><div class="icheck-primary d-inline model">' +
                            '<input type="checkbox" class="checkModel" id="content' +
                            model +
                            '" data-model="' + model + '">' +
                            '<label for="content' + model +
                            '" class="text-dark">' + model + '</label>' +
                            '</div></div>');
                        var modelBody = $('<div class="card-body"></div>');

                        $.each(permissions, function(index, permission) {
                            var permissionCheckbox = $(
                                '<div class="icheck-primary d-inline">' +
                                '<input type="checkbox" class="chk" id="content' +
                                permission.id +
                                '" name="permission[]" data-model="' +
                                model +
                                '" value="' + permission.id + '">' +
                                '<label for="content' + permission.id +
                                '">' + permission.description +
                                '</label></div></br>');
                            modelBody.append(permissionCheckbox);
                        });

                        modelCard.append(modelHeader, modelBody);
                        permissionContainer.append(modelCard);
                    });
                }
            });
        });
    });
</script>
@endsection
