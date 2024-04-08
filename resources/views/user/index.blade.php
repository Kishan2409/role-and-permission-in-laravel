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
                        @if (auth()->user()->hasPermission('users.create'))
                            <a href="{{ route('users.create') }}" class="float-sm-right btn btn-primary"><i
                                    class="fa-solid fa-plus"></i>
                                Add User</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">User Information</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>

                    </div>

                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        User Name
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        User Role
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    @if (session('success'))
        <script>
            //success alert
            Swal.fire({
                title: "Success",
                text: "{{ Session::get('success') }}",
                icon: 'success',
                showCloseButton: true,
                confirmButtonText: '<i class="fa-regular fa-thumbs-up"></i> Great!',
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        searchable: true,
                    },
                    {
                        data: 'email',
                        searchable: true,
                    },
                    {
                        data: 'roles',
                        searchable: false,
                    },
                    {
                        data: 'action',
                        searchable: false,
                    },
                ],
            });


            // delete btn
            $("#example").on('click', '.delete', function(e) {
                e.preventDefault();
                var input = $(this);
                var Id = input.data("id")

                Swal.fire({
                    title: "Are you sure ?",
                    text: "Are you sure you want to delete this user.",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "get",
                            url: "{{ route('users.delete', ':id') }}".replace(':id', Id),
                            success: function() {
                                table.ajax.reload();
                                Swal.fire(
                                    'Deleted!',
                                    'Your user has been deleted.',
                                    'success'
                                )
                            }
                        });
                    }
                })
            });
        });
    </script>
@endsection
