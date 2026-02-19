{{-- for deparerment modal--}}
    <div class="modal fade" id="departmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="departmentModalTitle">Department Information</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="departmentForm" method="POST">
                @csrf
                <div id="deptMethod"></div>
                <div class="modal-body p-4">
                    
                    <div class="mb-3" id="collegeSelectContainer">
    <label class="form-label fw-bold">Select College</label>
    <select name="college_id" id="dept_college_id" class="form-select">
        <option value="">-- Choose College --</option>
        @foreach($colleges as $col)
            <option value="{{ $col->id }}">{{ $col->name_en }}</option>
        @endforeach
    </select>
</div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Department Name (English)</label>
                        <input type="text" name="name_en" id="dept_name_en" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Department Name (Amharic)</label>
                        <input type="text" name="name_am" id="dept_name_am" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Department Head Name</label>
                        <input type="text" name="head_name" id="dept_head_name" class="form-control">
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{--for college modal to edit --}}
<div class="modal fade" id="collegeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="collegeModalTitle">College Information</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="collegeForm" method="POST">
                @csrf
                <div id="collegeMethod"></div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">College Name (English)</label>
                        <input type="text" name="name_en" id="col_name_en" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">College Name (Amharic)</label>
                        <input type="text" name="name_am" id="col_name_am" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">College Code</label>
                            <input type="text" name="code" id="col_code" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Dean Name</label>
                            <input type="text" name="dean_name" id="col_dean_name" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4 shadow-sm">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
      // (Global Add) for college Dropdown
        window.openGlobalAddDepartmentModal = function() {
            $('#departmentForm').attr('action', "{{ route('departments.store') }}");
            $('#deptMethod').html('');
            $('#departmentModalTitle').text('Add New Department');
            $('#departmentForm')[0].reset();
            $('#collegeSelectContainer').show(); 
            $('#dept_college_id').prop('required', true);      
            $('#departmentModal').modal('show');
        }

        // "Quick Add" this hidde college Dropdown
        window.openAddDepartmentModal = function(collegeId) {
            $('#departmentForm').attr('action', "{{ route('departments.store') }}");
            $('#deptMethod').html('');
            $('#departmentModalTitle').text('Quick Add Department');
            $('#departmentForm')[0].reset();
            $('#dept_college_id').val(collegeId); 
            $('#collegeSelectContainer').hide(); 
            $('#departmentModal').modal('show');
        }
        // Edit Department
        window.openEditDepartmentModal = function(id, nameEn, nameAm, collegeId, headName) {
            var url = "{{ route('departments.update', ':id') }}".replace(':id', id);
            
            $('#departmentForm').attr('action', url);
            $('#deptMethod').html('<input type="hidden" name="_method" value="PUT">');
            $('#departmentModalTitle').text('Edit Department');
            
            $('#dept_name_en').val(nameEn);
            $('#dept_name_am').val(nameAm);
            $('#dept_college_id').val(collegeId);
            $('#dept_head_name').val(headName); 
            
            $('#departmentModal').modal('show');
        }
        // for college
window.openAddCollegeModal = function() {
    $('#collegeForm').attr('action', "{{ route('colleges.store') }}");
    $('#collegeMethod').html('');
    $('#collegeModalTitle').text('Add New College');
    $('#collegeForm')[0].reset();
    $('#collegeModal').modal('show');
}

// for college Edit
window.openEditCollegeModal = function(id, nameEn, nameAm, code, deanName) {
    var url = "{{ route('colleges.update', ':id') }}".replace(':id', id);
    
    $('#collegeForm').attr('action', url);
    $('#collegeMethod').html('<input type="hidden" name="_method" value="PUT">');
    $('#collegeModalTitle').text('Edit College');
    
    $('#col_name_en').val(nameEn);
    $('#col_name_am').val(nameAm);
    $('#col_code').val(code);
    $('#col_dean_name').val(deanName);
    
    $('#collegeModal').modal('show');
}
    });
</script>