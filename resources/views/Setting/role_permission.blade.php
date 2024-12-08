@extends('layouts.app')

@section('content')
<div class="content">
    <main class="p-4">
        <!-- Breadcrumb -->
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Roles and Permissions</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Role and Permission Creation Forms -->
            <div class="col-12">
                <div class="row mb-4">
                    @can('manage roles') <!-- Check if the user has permission to manage roles -->
                    <!-- Role Creation Form -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white">
                                <h5>Create Role</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('roles_permissions.store_role') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="role_name">Role Name</label>
                                        <input type="text" 
                                               class="form-control border-light shadow-sm" 
                                               id="role_name" 
                                               name="name" 
                                               placeholder="Enter role name" 
                                               required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-plus-circle"></i> Create Role
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Permission Creation Form -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-success text-white">
                                <h5>Create Permission</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('roles_permissions.store_permission') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="permission_name">Permission Name</label>
                                        <input type="text" 
                                               class="form-control border-light shadow-sm" 
                                               id="permission_name" 
                                               name="name" 
                                               placeholder="Enter permission name" 
                                               required>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-plus-circle"></i> Create Permission
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endcan
                </div>
            </div>

            <!-- Roles and Permissions Section -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-info text-white">
                        <h5>Roles</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Role Name</th>
                                        @can('manage roles') <th>Permissions</th> @endcan
                                        @can('manage roles') <th>Actions</th> @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        @can('manage roles') <!-- Show permissions if user has permission -->
                                        <td>
                                            <form data-role-id="{{ $role->id }}" 
                                                  action="{{ route('roles_permissions.assign_permissions', $role) }}" 
                                                  method="POST" 
                                                  class="permissions-form">
                                                @csrf
                                                <div class="permission-list">
                                                    @foreach ($permissions as $permission)
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" 
                                                               class="custom-control-input" 
                                                               id="role-{{ $role->id }}-{{ $permission->id }}" 
                                                               name="permissions[]" 
                                                               value="{{ $permission->id }}" 
                                                               @if($role->hasPermissionTo($permission->name)) checked @endif>
                                                        <label class="custom-control-label" 
                                                               for="role-{{ $role->id }}-{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </form>
                                        </td>
                                        @endcan
                                        @can('manage roles') <!-- Show actions if user has permission -->
                                        <td>
                                            <div class="btn-group" role="group">
                                                <!-- Edit Button -->
                                                <a href="javascript:void(0);" class="btn btn-warning btn-sm me-2 edit-role-btn" data-id="{{ $role->id }}" data-name="{{ $role->name }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <!-- Delete Button with SweetAlert -->
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm delete-role-btn" 
                                                        data-url="{{ route('roles_permissions.destroyRole', $role) }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        @endcan
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions Section -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-secondary text-white">
                        <h5>Permissions</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Permission Name</th>
                                        @can('manage roles') <th>Actions</th> @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->name }}</td>
                                        @can('manage roles') <!-- Show actions if user has permission -->
                                        <td>
                                            <div class="btn-group" role="group">
                                                <!-- Edit Button -->
                                                <button type="button" 
                                                        class="btn btn-warning btn-sm edit-permission-btn" 
                                                        data-id="{{ $permission->id }}" 
                                                        data-name="{{ $permission->name }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Delete Button with SweetAlert -->
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm delete-permission-btn" 
                                                        data-url="{{ route('roles_permissions.destroyPermission', $permission) }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        @endcan
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Permission Edit Modal -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" role="dialog" aria-labelledby="editPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPermissionModalLabel">Edit Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editPermissionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editPermissionName">Permission Name</label>
                        <input type="text" class="form-control" id="editPermissionName" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Role Edit Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editRoleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editRoleName">Role Name</label>
                        <input type="text" class="form-control" id="editRoleName" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>



<link rel="stylesheet" href="{{ asset('css/role-permission.css') }}">

<script>
    $(document).ready(function () {
        // Delete Role
        $('.delete-role-btn').click(function () {
            var url = $(this).data('url'); // Get the delete URL
            var $button = $(this); // Reference the clicked button

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE',
                        },
                        success: function (response) {
                            toastr.success(response.success || 'Role deleted successfully.');

                            // Remove the role's row from the table
                            $button.closest('tr').fadeOut(300, function () {
                                $(this).remove();
                            });
                        },
                        error: function (xhr) {
                            toastr.error('Error deleting role. Please try again.');
                        },
                    });
                }
            });
        });

        // Edit Permission
        $('.edit-permission-btn').click(function () {
            var permissionId = $(this).data('id'); 
            var permissionName = $(this).data('name');
            var url = '{{ route('roles_permissions.update_permission', '__permission_id__') }}'.replace('__permission_id__', permissionId);

            $('#editPermissionName').val(permissionName);
            $('#editPermissionForm').attr('action', url);

            $('#editPermissionModal').modal('show');
        });

        // Submit edited permission
        $('#editPermissionForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function (response) {
                    toastr.success(response.success || 'Permission updated successfully!');

                    // Update the permission name in the table dynamically
                    $('button[data-id="' + response.id + '"]').data('name', response.name).closest('tr').find('td:first').text(response.name);

                    // Hide the modal
                    $('#editPermissionModal').modal('hide');
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON?.error || 'Error updating permission. Please try again.');
                },
            });
        });

        // Delete Permission
        $('.delete-permission-btn').click(function () {
            var url = $(this).data('url'); // Get the delete URL
            var $button = $(this); // Reference the clicked button

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE',
                        },
                        success: function (response) {
                            toastr.success(response.success || 'Permission deleted successfully.');

                            // Remove the permission's row from the table
                            $button.closest('tr').fadeOut(300, function () {
                                $(this).remove();
                            });
                        },
                        error: function (xhr) {
                            toastr.error('Error deleting permission. Please try again.');
                        },
                    });
                }
            });
        });
    });

    $(document).ready(function() {
        // Handle checkbox change for permissions
        $('.custom-control-input').change(function () {
        var permissionName = $(this).next('label').text().trim(); // Get the permission name from the label
        var roleId = $(this).closest('form').data('role-id'); // Get the role ID from the form data attribute

    // Gather all checked permissions for the current role
    var checkedPermissions = $(this)
        .closest('form')
        .find('.custom-control-input:checked')
        .map(function () {
            return $(this).next('label').text().trim();
        })
        .get();

    var data = {
        _token: '{{ csrf_token() }}',
        permissions: checkedPermissions ,
        role_id: roleId,
    };

    console.log(data); // Debugging: Check if all permissions are sent

    var url = '{{ route('roles_permissions.assign_permissions', '__role_id__') }}'.replace('__role_id__', roleId);

    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function (response) {
            toastr.success('Permissions updated successfully!');
        },
        error: function (xhr, status, error) {
            toastr.error('Error updating permissions. Please try again.');
        },
    });
});

    });

    $(document).ready(function () {
    // Edit Role
    $('.edit-role-btn').click(function () {
        var roleId = $(this).data('id'); // Get the role ID
        var roleName = $(this).data('name'); // Get the role name
        var url = '{{ route('roles_permissions.update_role', '__role_id__') }}'.replace('__role_id__', roleId);

        // Populate modal fields
        $('#editRoleName').val(roleName);
        $('#editRoleForm').attr('action', url); // Set the form action

        // Show the modal
        $('#editRoleModal').modal('show');
    });

    // Submit edited role
    $('#editRoleForm').submit(function (e) {
        e.preventDefault(); // Prevent default form submission
        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function (response) {
                toastr.success(response.success || 'Role updated successfully!');

                // Update the role name in the table dynamically
                $('a[data-id="' + response.id + '"]').data('name', response.name).closest('tr').find('td:first').text(response.name);

                // Hide the modal
                $('#editRoleModal').modal('hide');
            },
            error: function (xhr) {
                toastr.error(xhr.responseJSON?.error || 'Error updating role. Please try again.');
            },
        });
    });
});

</script>
@endsection
