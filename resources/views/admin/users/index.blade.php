@extends('admin.structure')

@section('title', 'Users')

@section('main.style')
    <style>
        /* ✅ DataTables Column visibility dropdown items */
        .dt-button-collection .dt-button,
        .dt-button-collection .dropdown-item {
            background-color: var(--app-bg) !important;
            color: var(--app-fg) !important;
            border: none !important;
            text-align: left;
            padding: .375rem .75rem !important;
        }

        /* Hover & Focus */
        .dt-button-collection .dt-button:hover,
        .dt-button-collection .dt-button:focus,
        .dt-button-collection .dropdown-item:hover,
        .dt-button-collection .dropdown-item:focus {
            background-color: rgba(13, 110, 253, 0.1) !important;
            /* نفس لون الـ hover في Bootstrap */
            color: var(--app-fg) !important;
        }

        /* Light mode */
        .dt-button-collection {
            background-color: #dfe6e9 !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        /* Dark mode */
        body.theme-dark .dt-button-collection {
            background-color: #1f2426 !important;
            /* نفس لون الفوتر/الناڤ بار */
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .6) !important;
        }

        html[dir="rtl"] div.dt-buttons span.dt-button-down-arrow,
        body[dir="rtl"] div.dt-buttons span.dt-button-down-arrow {
            padding-left: 0;
            padding-right: 10px;
        }

        /* الوضع العادي (LTR) */
        div.dt-button-collection .dt-button-active:after {
            right: 1em;
        }

        div.dt-button-collection .dt-button {
            text-align: left;
        }

        /* الوضع العربي (RTL) */
        html[dir="rtl"] div.dt-button-collection .dt-button-active:after,
        body[dir="rtl"] div.dt-button-collection .dt-button-active:after {
            left: 1em;
            right: auto;
        }

        html[dir="rtl"] div.dt-button-collection .dt-button,
        body[dir="rtl"] div.dt-button-collection .dt-button {
            text-align: right;
        }
    </style>
@endsection

@section('main.script')
    <script>
        $(document).ready(function() {
            let table = $('#user-table').DataTable({
                dom: '<"top d-flex justify-content-between align-items-center"Bf>rt<"bottom d-flex justify-content-between align-items-center"lip>',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: ':visible'
                        },
                        className: 'btn btn-primary'
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        },
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':visible'
                        },
                        className: 'btn btn-info'
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible'
                        },
                        className: 'btn btn-danger'
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        },
                        className: 'btn btn-warning'
                    },
                    {
                        extend: 'colvis',
                        className: 'btn btn-dark'
                    }
                ],
                lengthMenu: [
                    [10, 20, 50, -1],
                    [10, 20, 50, "All"]
                ],

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.users.index') }}",
                    type: 'GET',
                    data: function(d) {
                        d.status = $('#filter-status').val();
                        d.type = $('#filter-type').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'mobile_number',
                        name: 'mobile_number'
                    },
                    {
                        data: 'national_id',
                        name: 'national_id'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'can_login',
                        name: 'can_login'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        visible: false
                    }
                ],
                columnDefs: [{
                    targets: -1,
                    className: 'dt-center'
                }]
            });

            $('#filter-status, #filter-type').on('change', function() {
                table.ajax.reload();
            });
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Users</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="filter-status"></label>
                                <select id="filter-status" class="form-control">
                                    <option value="">All</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="filter-type"></label>
                                <select id="filter-type" class="form-control">
                                    <option value="">All</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="user-table" class="table table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Mobile Number</th>
                                        <th>National ID</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>Can Login</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
