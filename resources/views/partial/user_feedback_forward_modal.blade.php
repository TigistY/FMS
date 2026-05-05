<div class="modal fade" id="userFeedbackForwardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <form action="{{ route('feedback.forward', $feedback->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-share-alt me-2"></i>Forward Feedback
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Recipient Type</label>
                        <select id="fb_forward_recipient_type" name="recipient_type" class="form-select" onchange="handleFBForwardTypeChange()" required>
                            <option value="">Select Type</option>
                            <option value="College">College</option>
                            <option value="Department">Department</option>
                            <option value="Directory">Directory</option>
                        </select>
                    </div>

                    <div id="fb_forward_college_filter" class="mb-3 d-none">
                        <label class="form-label fw-bold text-primary">Select College First</label>
                        <select id="fb_forward_filter_college_id" class="form-select border-primary" onchange="loadFBForwardDepartments(this.value)">
                            <option value="">Choose College</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Target Unit</label>
                        <select id="fb_forward_recipient_id" name="recipient_id" class="form-select" required disabled>
                            <option value="">Select Unit</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Note (Reason for forwarding)</label>
                        <textarea name="forward_note" class="form-control" rows="3" placeholder="Write the reason for forwarding here..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Confirm Forward</button>
                </div>
            </form>
        </div>
    </div>
</div>
