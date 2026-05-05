
<div class="modal fade" id="directoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="directoryModalTitle">Directorate Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="directoryForm" method="POST">
                @csrf
                <div id="dirMethod"></div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name (English)</label>
                        <input type="text" name="name_en" id="dir_name_en" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name (Amharic)</label>
                        <input type="text" name="name_am" id="dir_name_am" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Code</label>
                            <input type="text" name="code" id="dir_code" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Manager Name</label>
                            <input type="text" name="manager_name" id="dir_manager_name" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" id="dir_description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0" id="modalFooter">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Save Directory</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        window.openAddDirectoryModal = function() {
            $('#directoryForm').attr('action', "{{ route('directories.store') }}");
            $('#dirMethod').html('');
            $('#directoryModalTitle').text('Add New Directory');
            $('#directoryForm')[0].reset();
            enableFormFields(true);
            $('#modalFooter').show();
            $('#directoryModal').modal('show');
        }

        window.openEditDirectoryModal = function(directory) {
            let url = "{{ route('directories.update', ':id') }}".replace(':id', directory.id);
            $('#directoryForm').attr('action', url);
            $('#dirMethod').html('@method("PUT")');
            $('#directoryModalTitle').text('Edit Directory');
            fillModalData(directory);
            enableFormFields(true);
            $('#modalFooter').show();
            $('#directoryModal').modal('show');
        }

        window.openViewDirectoryModal = function(directory) {
            $('#directoryModalTitle').text('View Directory Details');
            fillModalData(directory);
            enableFormFields(false); 
            $('#modalFooter').hide(); 
            $('#directoryModal').modal('show');
        }

        function fillModalData(data) {
            $('#dir_name_en').val(data.name_en);
            $('#dir_name_am').val(data.name_am);
            $('#dir_code').val(data.code);
            $('#dir_manager_name').val(data.manager_name);
            $('#dir_description').val(data.description);
        }

       
        function enableFormFields(status) {
            $('#directoryForm input, #directoryForm textarea').prop('disabled', !status);
        }
    });
</script>