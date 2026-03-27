<div class="modal fade" id="complaintModal" tabindex="-1" aria-labelledby="complaintModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('complaints.submit') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <div class="w-100 d-flex justify-content-between align-items-center">
                        <h5 class="modal-title fw-bold" id="main-title">
                            <i class="fas fa-exclamation-triangle me-2"></i> Complaint Submission
                        </h5>
                        <div style="width: 140px;">
                            <select id="language_selector" onchange="window.switchLanguage(this.value)" class="form-select form-select-sm border-0 shadow-sm">
                                <option value="am">አማርኛ</option>
                                <option value="en" selected>English</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <p class="text-muted mt-0 mb-4" id="subtitle" style="font-size: 0.9rem;">
                        Please select the relevant unit and enter your complaint details.
                    </p>

                    <div class="row">
                        <div class="col-md-6 border-end">
                            <h6 class="text-danger fw-bold mb-3 border-bottom pb-2" id="title-recipient-info">Recipient Information</h6>
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label small fw-bold" id="label-recipient-type">Type *</label>
                                    <select id="recipient_type" name="recipient_type" required class="form-select form-select-sm" onchange="window.handleTypeChange()">
                                        <option value="" id="option-select-recipient-type">Select Type</option>
                                        <option value="College" id="option-college">College</option>
                                        <option value="Department" id="option-department">Department</option>
                                        <option value="Directory" id="option-directory">Directorate</option>
                                    </select>
                                </div>
                                <div class="col-6 d-none" id="college_filter_container">
                                    <label class="form-label small fw-bold" id="label-filter-college">Select College </label>
                                    <select id="filter_college_id" class="form-select form-select-sm" onchange="window.loadDepartmentsByCollege(this.value)">
                                        <option value="" id="option-select-filter-college">Choose College</option>
                                    </select>
                                </div>
                                <div class="col-12 mt-2">
                                    <label class="form-label small fw-bold" id="label-recipient-id">Recipient Unit </label>
                                    <select id="recipient_id" name="recipient_id" required class="form-select form-select-sm">
                                        <option value="" id="option-select-recipient">Select Recipient Unit</option>
                                    </select>
                                    <small id="loading-text" class="text-danger d-none fw-bold"></small>
                                </div>
                            </div>
                            
                            <h6 class="text-danger fw-bold mb-3 border-bottom pb-2" id="label-description">Complain Content</h6>
                            <div class="mb-2">
                                <label class="form-label small fw-bold" id="label-subject">Subject </label>
                                <input type="text" id="subject" name="subject" required class="form-control form-control-sm border-danger-subtle">
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-bold" id="label-body-text">Detailed Description </label>
                                <textarea id="body" name="body" rows="4" required class="form-control form-control-sm border-danger-subtle"></textarea>
                            </div>
                        </div>

                        
                        <div class="col-md-6 ps-md-4">
                            <h6 class="text-danger fw-bold mb-3 border-bottom pb-2" id="title-contact">Identity & Contact</h6>
                      <div class="form-check form-switch p-3 bg-danger-subtle rounded mb-2">
                      <input id="is_anonymous" name="is_anonymous" type="checkbox" onchange="window.handleIdentityChange()" class="form-check-input">
                      <label for="is_anonymous" id="label-anonymous" class="form-check-label fw-bold text-danger">Anonymous</label>
                  </div>
                 <p class="small text-muted mb-3" id="text-anonymous-warning">Hides identity, but may limit responses.</p>
                  <div class="form-check mb-3">
                 <input id="use_guest_mode" name="use_guest_mode" type="checkbox" onchange="window.handleIdentityChange()" class="form-check-input">
                 <label for="use_guest_mode" class="form-check-label small fw-bold text-primary" id="label-submit-guest">Submit as Guest</label>
                </div>       
                            
                             <div id="guest_fields" class="p-3 border rounded bg-light d-none">                  
                               <h6 class="small fw-bold mb-3 text-dark" id="titles-contact">Contact Information</h6>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-label small mb-1 fw-bold" id="label-email">Email</label>
                                        <input type="email" name="guest_email" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small mb-1 fw-bold" id="label-name">Full Name (Optional)</label>
                                        <input type="text" name="guest_name" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small mb-1 fw-bold" id="label-type">Reporter Type </label>
                                        <select name="guest_type" class="form-select form-select-sm" id="guest_type">
                                            <option value="" id="opt-select-type">Select Type</option>
                                            <option value="Student" id="opt-student">Student</option>
                                            <option value="Employee" id="opt-Employee">Employee</option>
                                            <option value="Other" id="opt-Guest">Guest</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="button-submit" class="btn btn-danger w-100 py-2 fw-bold">Submit Complaint</button>
                </div>
            </div>
        </form>
    </div>
</div>