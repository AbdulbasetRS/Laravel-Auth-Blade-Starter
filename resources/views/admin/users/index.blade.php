@extends('admin.structure')

@section('title', 'Users')

@section('main.style')
    <style>

    </style>
@endsection

@section('main.script')
    <script>
        $(document).ready(function() {
            let table = $('#user-table').DataTable({
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
