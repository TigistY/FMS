   <div class="modal fade" id="forwardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <form action="{{ route('complaints.forward', $complaint->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold">Forward Complaint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Recipient Type</label>
                        <select id="forward_recipient_type" name="recipient_type" class="form-select" onchange="handleForwardTypeChange()" required>
                            <option value="">Select Type</option>
                            <option value="College">College</option>
                            <option value="Department">Department</option>
                            <option value="Directory">Directory</option>
                        </select>
                    </div>

                    <div id="forward_college_filter_container" class="mb-3 d-none">
                        <label class="form-label fw-bold text-primary">Select College First</label>
                        <select id="forward_filter_college_id" class="form-select border-primary" onchange="loadForwardDepartments(this.value)">
                            <option value="">-- Choose College --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Target Unit</label>
                        <select id="forward_recipient_id" name="recipient_id" class="form-select" required disabled>
                            <option value="">Select Unit</option>
                        </select>
                        <small id="forward_loading" class="text-muted d-none">Loading...</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Forwarding Note</label>
                        <textarea name="forward_note" class="form-control" rows="3" placeholder="Reason for forwarding...."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning px-4 fw-bold">Confirm Forward</button>
                </div>
            </form>
        </div>
    </div>
</div>