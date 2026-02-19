<div class="modal fade" id="userForwardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <form action="{{ route('complaints.forward', $complaint->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fw-bold">Forward to Higher/Other Unit</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Recipient Type</label>
                        <select id="user_recipient_type" name="recipient_type" class="form-select" onchange="handleUserTypeChange()" required>
                            <option value="">Select Type</option>
                            <option value="College">College</option>
                            <option value="Department">Department</option>
                            <option value="Directory">Directory</option>
                        </select>
                    </div>

                    <div id="user_college_filter" class="mb-3 d-none">
                        <label class="form-label fw-bold">Select College</label>
                        <select id="user_filter_college" class="form-select" onchange="loadUserDepartments(this.value)">
                            <option value="">-- Choose --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Target Unit</label>
                        <select id="user_recipient_id" name="recipient_id" class="form-select" required disabled>
                            <option value="">Select Unit</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Note (Reason for forwarding)</label>
                        <textarea name="forward_note" class="form-control" rows="3" placeholder="Why are you forwarding this?..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-dark w-100 fw-bold">Forward Now</button>
                </div>
            </form>
        </div>
    </div>
</div>