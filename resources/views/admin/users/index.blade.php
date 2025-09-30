@extends('admin.structure')

@section('title', 'Users')

@section('main.style')
 <style>
    /* Light mode */
body .dt-button-collection .dt-button,
body .dt-button-collection .dropdown-item {
    background-color: #fff !important;
    color: #212529 !important;
    border: none !important;
    text-align: left;
    padding: .375rem .75rem !important;
}

body .dt-button-collection .dt-button:hover,
body .dt-button-collection .dropdown-item:hover {
    background-color: #0d6efd !important; /* أزرق Bootstrap */
    color: #fff !important;
}

/* Dark mode */
body .dt-button-collection .dt-button,
body .dt-button-collection .dropdown-item {
    background-color: #2b2b2b !important;
    color: #f1f1f1 !important;
    border: none !important;
    text-align: left;
    padding: .375rem .75rem !important;
}

body .dt-button-collection .dt-button:hover,
body .dt-button-collection .dropdown-item:hover {
    background-color: #444 !important;
    color: #fff !important;
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
       