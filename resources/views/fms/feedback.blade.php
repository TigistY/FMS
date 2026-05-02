@extends('layouts.wel')

@section('content')
    <div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-lg border-0 feedback-theme">
                {{-- Header Section --}}
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex justify-content-between align-items-center px-3">
                        <h2 class="fw-bold text-primary mb-0" id="main-title" style="font-size: 1.5rem;">
                            <i class="fas fa-comment-dots me-2"></i> Feedback Submission
                        </h2>
                        <div style="width: 150px;">
                            <select id="language_selector" onchange="window.switchLanguage(this.value)" class="form-select form-select-sm bg-info-subtle border-primary">
                                <option value="am">አማርኛ</option>
                                <option value="en" selected>English</option>
                            </select>
                        </div>
                    </div>
                    <p class="text-muted px-3 mt-2 mb-0" id="subtitle" style="font-size: 0.9rem;">Please select the relevant unit and enter details.</p>
                </div>
                       @if(session('success'))
                        <div class="alert alert-success text-center mb-4">{{ session('success') }}</div>
                    @endif
                <div class="card-body p-4">
                    <form action="{{ route('feedback.submit') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            {{-- Left Column: Recipient & Details --}}
                            <div class="col-md-6 border-end">
                                <h6 class="text-primary fw-bold mb-3 border-bottom pb-2" id="title-recipient-info"> Recipient Information</h6>
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold" id="label-recipient-type">Type *</label>
                                        <select id="recipient_type" name="recipient_type" required class="form-select form-select-sm" onchange="window.handleTypeChange()">
                                            <option value="" id="option-select-recipient-type">Select Type</option>
                                            <option value="College">College</option>
                                            <option value="Department">Department</option>
                                            <option value="Directory">Directory</option>
                                        </select>
                                    </div>
                                    <div class="col-6 d-none" id="college_filter_container">
                                        <label class="form-label small fw-bold" id="label-filter-college">College *</label>
                                        <select id="filter_college_id" class="form-select form-select-sm" onchange="window.loadDepartmentsByCollege(this.value)">
                                            <option value="">Choose College</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label class="form-label small fw-bold" id="label-recipient-id">Select Recipient Unit *</label>
                                        <select id="recipient_id" name="recipient_id" required class="form-select form-select-sm">
                                            <option value="" id="option-select-recipient">Select Recipient</option>
                                        </select>
                                    </div>
                                </div>

                                <h6 class="text-primary fw-bold mb-3 border-bottom pb-2" id="title-feedback-details">Feedback Content</h6>
                            
                       <div class="mb-3">
                           <label for="feedback_type" class="form-label" id="label-feedback-type">Feedback Nature: <span                        class="text-danger">*</span></label>
                           <select id="feedback_type" name="feedback_type" required class="form-select                        border-primary-subtle">
                               <option value="Neutral" id="opt-neutral">Neutral</option>
                               <option value="Positive" id="opt-positive">Positive</option>
                               <option value="Negative" id="opt-negative">Negative</option>
                           </select>
                       </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold" id="label-subject">Subject *</label>
                                    <input type="text" id="subject" name="subject" required class="form-control form-control-sm" placeholder="Subject">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold" id="label-description">Description *</label>
                                    <textarea id="body" name="body" rows="4" required class="form-control form-control-sm" placeholder="Details..."></textarea>
                                </div>
                            </div>

                          
                            <div class="col-md-6 ps-md-4">
                                <h6 class="text-primary fw-bold mb-3 border-bottom pb-2" id="label-Identity">Identity Options</h6>
                                <div class="form-check form-switch p-3 bg-light rounded mb-2">
                                    <input id="is_anonymous" name="is_anonymous" type="checkbox" role="switch" onchange="window.toggleGuestFields()" class="form-check-input" {{ old('is_anonymous') ? 'checked' : '' }}>
                                    <label for="is_anonymous" class="form-check-label fw-bold" id="label-anonymous">Remain Anonymous</label>
                                </div>
                                <p class="small text-muted mb-3" id="text-anonymous-warning">Hides identity, but may limit responses.</p>

                                <div id="guest-fields" class="p-3 border rounded bg-white">
                                    <h6 class="small fw-bold mb-3 text-dark" id="title-contact">Contact Information</h6>
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <label class="form-label small mb-1" id="label-email">Email *</label>
                                            <input type="email" id="guest_email" name="guest_email" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label class="form-label small mb-1" id="label-name">Full Name</label>
                                            <input type="text" id="guest_name" name="guest_name" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label class="form-label small mb-1" id="label-type">Reporter Type *</label>
                                            <select id="guest_type" name="guest_type" class="form-select form-select-sm">
                                                <option value="" id="option-select-type">Select Type</option>
                                                <option value="Student">Student</option>
                                                <option value="Employee">Employee</option>
                                                <option value="Other">Guest</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" id="button-submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                                        <i class="fas fa-paper-plane me-2"></i> Submit Feedback
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.translations = {
        'am': {
            'main-title': 'ግብረመልስ ማስገቢያ',
            'subtitle': 'አስተያየትዎን፣ ምስጋናዎን ወይም ምክርዎን የሚመለከተውን ክፍል በመምረጥ ያስገቡ።',
            'label-language': 'ቋንቋ ይምረጡ:',
            'title-recipient-info': 'ግብረመልሱ የሚመለከተው አካል መረጃ',
            'label-recipient-type': 'የመቀበያ አይነት:',
            'option-select-recipient-type': 'አይነት ይምረጡ',
            'option-college': 'ኮሌጅ',
            'option-department': 'ዲፓርትመንት',
            'option-directory': 'ዳይሬክቶሬት',
            'label-filter-college': 'ቅድሚያ ኮሌጅ ይምረጡ:',
            'option-select-filter-college': 'ኮሌጅ ይምረጡ ',
            'label-recipient-id': 'ክፍሉን ይምረጡ:',
            'option-select-recipient': 'ክፍል ይምረጡ',
            'title-feedback-details': 'የግብረመልስ ዝርዝሮች', 
            'label-subject': 'ርዕስ:',
            'placeholder-subject': 'አጭርና ግልጽ ርዕስ',
            'label-description': 'ዝርዝር መግለጫ:',
            'placeholder-description': 'አስተያየትዎን በዝርዝር ያስቀምጡ...',
            'label-Identity': 'የማንነት አማራጮች',
            'label-anonymous': 'ስም-አልባ መሆን እፈልጋለሁ።',
            'text-anonymous-warning': 'ይህን ከመረጡ ማንነትዎ ይደበቃል፣ ነገር ግን ምላሽ ላይደርስዎት ይችላል።',
            'title-contact': 'የእውቂያ መረጃ',
            'label-email': 'ኢሜይል:',
            'label-name': 'ስም (አማራጭ):',
            'label-type': 'የሪፖርተር አይነት:',
            'option-select-type': 'ይመድቡ',
            'button-submit': 'ግብረመልስ አስገባ',
            'label-feedback-type': 'የአስተያየቱ አይነት:',
            'opt-neutral': 'መካከለኛ',
            'opt-positive': 'ምስጋና',
            'opt-negative': 'ቅሬታ',
        },
        'en': {
            'main-title': 'Feedback Submission',
            'subtitle': 'Please select the relevant unit and enter the details of your feedback.',
            'label-language': 'Select Language:',
            'title-recipient-info': 'Recipient Information',
            'label-recipient-type': 'Recipient Type:',
            'option-select-recipient-type': 'Select Type',
            'option-college': 'College',
            'option-department': 'Department',
            'option-directory': 'Directory',
            'label-filter-college': 'Select College first:',
            'option-select-filter-college': 'Choose College',
            'label-recipient-id': 'Select Recipient:',
            'option-select-recipient': 'Select Recipient Unit',
            'title-feedback-details': 'Feedback Details', 
            'label-subject': 'Subject:',
            'placeholder-subject': 'Short and clear subject',
            'label-description': 'Detailed Description:',
            'placeholder-description': 'Describe your feedback in detail...',
            'label-Identity': 'Identity Options',
            'label-anonymous': 'Remain Anonymous',
            'text-anonymous-warning': 'Hides identity, but may limit responses.',
            'title-contact': 'Contact Information',
            'label-email': 'Email:',
            'label-name': 'Name (Optional):',
            'label-type': 'Reporter Type:',
            'option-select-type': 'Select Type',
            'button-submit': 'Submit Feedback',
            'label-feedback-type': 'Nature of Feedback:',
            'opt-neutral': 'Neutral',
            'opt-positive': 'Positive',
            'opt-negative': 'Negative',
        }
    };

    let currentLanguage = 'en';

    window.switchLanguage = (lang) => {
        currentLanguage = lang;
        const t = window.translations[lang];

        for (let key in t) {
            const el = document.getElementById(key);
            if (el) {
                const icon = el.querySelector('i');
                if (icon) {
                    el.innerHTML = ''; 
                    el.appendChild(icon);
                    el.appendChild(document.createTextNode(' ' + t[key]));
                } else {
                    el.textContent = t[key];
                }
            }
        }

        // 2. Placeholders
        if(document.getElementById('subject')) document.getElementById('subject').placeholder = t['placeholder-subject'];
        if(document.getElementById('body')) document.getElementById('body').placeholder = t['placeholder-description'];

        // 3. Dropdowns update
        const selects = [document.getElementById('recipient_id'), document.getElementById('filter_college_id')];
        selects.forEach(select => {
            if(!select) return;
            Array.from(select.options).forEach(opt => {
                if(opt.value === "") {
                    opt.textContent = (select.id === 'recipient_id') ? t['option-select-recipient'] : t['option-select-filter-college'];
                } else {
                    opt.textContent = opt.getAttribute(`data-${lang}-name`) || opt.textContent;
                }
            });
        });
    };

    window.handleTypeChange = async () => {
        const type = document.getElementById('recipient_type').value;
        const collegeFilter = document.getElementById('college_filter_container');
        const idSelect = document.getElementById('recipient_id');
        
        idSelect.innerHTML = `<option value="">${window.translations[currentLanguage]['option-select-recipient']}</option>`;
        idSelect.disabled = true;
        collegeFilter.classList.add('d-none');

        if (type === 'College') {
            window.loadUnits('{{ route('api.colleges.list') }}');
        } else if (type === 'Directory') {
            window.loadUnits('{{ route('api.directories.list') }}');
        } else if (type === 'Department') {
            collegeFilter.classList.remove('d-none');
            window.fillCollegeFilter();
        }
    };

    window.fillCollegeFilter = async () => {
        const filterSelect = document.getElementById('filter_college_id');
        try {
            const response = await fetch('{{ route('api.colleges.list') }}');
            const colleges = await response.json();
            filterSelect.innerHTML = `<option value="">${window.translations[currentLanguage]['option-select-filter-college']}</option>`;
            colleges.forEach(c => {
                const nameAm = c.name_am || c.name_en;
                const nameEn = c.name_en;
                const opt = document.createElement('option');
                opt.value = c.id;
                opt.textContent = currentLanguage === 'am' ? nameAm : nameEn;
                opt.setAttribute('data-am-name', nameAm);
                opt.setAttribute('data-en-name', nameEn);
                filterSelect.appendChild(opt);
            });
        } catch (e) { console.error(e); }
    };

    window.loadDepartmentsByCollege = (collegeId) => {
        if (!collegeId) return;
        window.loadUnits(`{{ url('/api/colleges') }}/${collegeId}/departments`);
    };

    window.loadUnits = async (url) => {
        const idSelect = document.getElementById('recipient_id');
        const loading = document.getElementById('loading-text');
        if(loading) loading.classList.remove('d-none');
        idSelect.disabled = true;

        try {
            const response = await fetch(url);
            const data = await response.json();
            idSelect.innerHTML = `<option value="">${window.translations[currentLanguage]['option-select-recipient']}</option>`;
            data.forEach(item => {
                const nameAm = item.name_am || item.name_en;
                const nameEn = item.name_en;
                const opt = document.createElement('option');
                opt.value = item.id;
                opt.textContent = currentLanguage === 'am' ? nameAm : nameEn;
                opt.setAttribute('data-am-name', nameAm);
                opt.setAttribute('data-en-name', nameEn);
                idSelect.appendChild(opt);
            });
            idSelect.disabled = false;
        } catch (e) { console.error(e); }
        if(loading) loading.classList.add('d-none');
    };

    window.toggleGuestFields = () => {
        const isAnon = document.getElementById('is_anonymous').checked;
        const guestFields = document.getElementById('guest-fields');
        if(guestFields) guestFields.style.display = isAnon ? 'none' : 'block';
    };

    document.addEventListener('DOMContentLoaded', () => {
        window.switchLanguage('en');
        window.toggleGuestFields();
    });
</script>
@endsection