<div class="modal fade" id="createPermissionModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Permission</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Permission Name (view-complaint)</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Amharic Name</label>
                        <input type="text" name="display_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Group</label>
                        <input type="text" name="group" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Permission</button>
                </div>
            </div>
        </form>
    </div>
</div>