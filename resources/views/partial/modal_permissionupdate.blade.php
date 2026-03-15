<div class="modal fade" id="editPermissionModal{{ $perm->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('permissions.update', $perm->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Permission</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Permission Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $perm->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Amharic Name</label>
                        <input type="text" name="display_name" class="form-control" value="{{ $perm->display_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Group</label>
                        <input type="text" name="group" class="form-control" value="{{ $perm->group }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>