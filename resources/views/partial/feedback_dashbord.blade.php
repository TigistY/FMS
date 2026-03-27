<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('feedback.submit') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="modal-content">
                {{-- Modal Header --}}
                <div class="modal-header bg-success text-white">
                    <div class="w-100 d-flex justify-content-between align-items-center">
                        <h5 class="modal-title fw-bold" id="fb-main-title">
                            <i class="fas fa-comment-dots me-2"></i> Feedback Submission
                        </h5>
                        <div style="width: 130px;">
                            <select id="fb_language_selector" onchange="window.switchLanguage(this.value, 'fb')" class="form-select form-select-sm border-0 shadow-sm">
                                <option value="en" selected>English</option>
                                <option value="am">አማርኛ</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <p class="text-muted mb-4" id="fb-subtitle">Please select the relevant unit and enter details.</p>
                    
                    <div class="row">
                        
                        <div class="col-md-6 border-end">
                            <h6 class="text-success fw-bold mb-3 border-bottom pb-2" id="fb-title-recipient-info">Recipient Information</h6>
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label small fw-bold" id="fb-label-recipient-type">Type </label>
                                    <select id="fb_recipient_type" name="recipient_type" required class="form-select form-select-sm" onchange="window.handleTypeChange('fb')">
                                        <option value="" id="fb-option-select-recipient-type">Select Type</option>
                                        <option value="College" id="fb-option-college">College</option>
                                        <option value="Department" id="fb-option-department">Department</option>
                                        <option value="Directory" id="fb-option-directory">Directory</option>
                                    </select>
                                </div>
                                <div class="col-6 d-none" id="fb_college_filter_container">
                                    <label class="form-label small fw-bold" id="fb-label-filter-college">College</label>
                                    <select id="fb_filter_college_id" class="form-select form-select-sm" onchange="window.loadDepartmentsByCollege(this.value, 'fb')">
                                        <option value="">Choose College</option>
                                    </select>
                                </div>
                                <div class="col-12 mt-2">
                                    <label class="form-label small fw-bold" id="fb-label-recipient-id">Select Recipient Unit *</label>
                                    <select id="fb_recipient_id" name="recipient_id" required class="form-select form-select-sm">
                                        <option value="" id="fb-option-select-recipient">Select Recipient</option>
                                    </select>
                                </div>
                            </div>

                            <h6 class="text-success fw-bold mb-3 border-bottom pb-2" id="fb-title-feedback-details">Feedback Content</h6>
                            <div class="mb-3">
                                <label class="form-label small fw-bold" id="fb-label-feedback-type">Feedback Nature </label>
                                <select id="fb_feedback_type" name="feedback_type" required class="form-select form-select-sm">
                                    <option value="Neutral" id="fb-opt-neutral">Neutral</option>
                                    <option value="Positive" id="fb-opt-positive">Positive</option>
                                    <option value="Negative" id="fb-opt-negative">Negative</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-bold" id="fb-label-subject">Subject </label>
                                <input type="text" id="fb_subject" name="subject" required class="form-control form-control-sm">
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-bold" id="fb-label-description">Description </label>
                                <textarea id="fb_body" name="body" rows="4" required class="form-control form-control-sm"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6 ps-md-4">
                            <h6 class="text-success fw-bold mb-3 border-bottom pb-2" id="fb-label-anonymous">Identity Options</h6>
                          <div class="form-check form-switch p-3 bg-light rounded mb-2">
                        <input id="fb_is_anonymous" name="is_anonymous" type="checkbox" onchange="window.handleIdentityChange('fb')" class="form-check-input">
                        <label for="fb_is_anonymous" id="fb-label-anon-text" class="form-check-label fw-bold">Anonymous</label>
                    </div>
                    <p class="small text-muted mb-3" id="fb-text-anonymous-warning">Hides identity, but may limit responses.</p>
                    <div class="form-check mb-3">
                        <input id="fb_use_guest_mode" name="use_guest_mode" type="checkbox" onchange="window.handleIdentityChange('fb')" class="form-check-input">
                        <label for="fb_use_guest_mode" id="fb-label-submit-guest" class="form-check-label small fw-bold text-success">Submit as Guest</label>
                    </div>


                            

                            <div id="fb_guest_fields" class="p-3 border rounded bg-white d-none">

                                <h6 class="small fw-bold mb-3 text-dark" id="fb-title-contact">Contact Information</h6>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-label small mb-1" id="fb-label-email">Email</label>
                                        <input type="email" name="guest_email" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label class="form-label small mb-1" id="fb-label-name">Full Name</label>
                                        <input type="text" name="guest_name" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label class="form-label small mb-1" id="fb-label-type">Reporter Type</label>
                                        <select name="guest_type" class="form-select form-select-sm" id="fb_guest_type">
                                            <option value="" id="fb-option-select-type">Select Type</option>
                                            <option value="Student" id="fb-opt-student">Student</option>
                                            <option value="Employee" id="fb-opt-employee">Employee</option>
                                            <option value="Other" id="fb-opt-guest">Guest</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="fb-button-submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm">
                        <i class="fas fa-paper-plane me-2"></i> Submit Feedback
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>