@extends('layouts.dashboard')
@section('title','Users Management')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Data Users
                    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary btn-sm float-end">
                        Add User
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="users-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter = 1; @endphp
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    @if($loop->first && $user->role === 'admin')
                                    <td>
                                        <a href="{{ route('dashboard.users.edit', $user->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                    @else
                                    <td>
                                        <a href="{{ route('dashboard.users.edit', $user->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <a href="{{ route('dashboard.users.destroy', $user->id) }}"
                                            class="btn btn-sm btn-danger" data-confirm-delete="true">Delete</a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.bootstrap5.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.bootstrap5.js"></script>
<script>
    $(document).ready(function () {
            $('#users-table').DataTable();
        });
</script>
@endpush
