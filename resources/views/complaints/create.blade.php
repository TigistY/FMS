@extends('layouts.wel')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            {{-- Hover effect ያለው ካርድ --}}
            <div class="card shadow-lg border-0 complaint-card">
                
                {{-- Header Section --}}
                <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                    <div class="d-flex justify-content-between align-items-center px-3">
                        <h2 class="fw-bold text-danger mb-0" id="main-title" style="font-size: 1.5rem;">
                            <i class="fas fa-exclamation-triangle me-2"></i> Complaint Submission
                        </h2>
                        <div style="width: 150px;">
                            <select id="language_selector" onchange="window.switchLanguage(this.value)" class="form-select form-select-sm bg-danger-subtle border-danger">
                                <option value="am">አማርኛ</option>
                                <option value="en" selected>English</option>
                            </select>
                        </div>
                    </div>
                    <p class="text-muted mt-2 mb-0" id="subtitle" style="font-size: 0.9rem;">Please select the relevant unit and enter your complaint details.</p>
                </div>

                {{-- Alert Messages --}}
                <div class="px-4 mt-3">
                    @if ($errors->any())
                        <div class="alert alert-danger p-2 small">
                            <ul class="mb-0 list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fas fa-times-circle me-1"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success text-center p-2 small">{{ session('success') }}</div>
                    @endif
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('complaints.submit') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            {{-- Left Column: Recipient & Details --}}
                            <div class="col-md-6 border-end">
                                <h6 class="text-danger fw-bold mb-3 border-bottom pb-2" id="title-recipient-info">Recipient Information</h6>
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold" id="label-recipient-type">Type *</label>
                                        <select id="recipient_type" name="recipient_type" required class="form-select form-select-sm" onchange="window.handleTypeChange()">
                                            <option value="" id="option-select-recipient-type">Select Type</option>
                                            <option value="College" id="option-college">College</option>
                                            <option value="Department" id="option-department">Department</option>
                                            <option value="Directory" id="option-directory">Directory</option>
                                        </select>
                                    </div>
                                    <div class="col-6 d-none" id="college_filter_container">
                                        <label class="form-label small fw-bold" id="label-filter-college">Select College *</label>
                                        <select id="filter_college_id" class="form-select form-select-sm" onchange="window.loadDepartmentsByCollege(this.value)">
                                            <option value="" id="option-select-filter-college">Choose College</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label class="form-label small fw-bold" id="label-recipient-id">Select Recipient Unit *</label>
                                        <select id="recipient_id" name="recipient_id" required class="form-select form-select-sm">
                                            <option value="" id="option-select-recipient">Select Recipient Unit</option>
                                        </select>
                                        <small id="loading-text" class="text-danger d-none fw-bold">Loading...</small>
                                    </div>
                                </div>

                                <h6 class="text-danger fw-bold mb-3 border-bottom pb-2" id="label-description">Complaint Content</h6>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold" id="label-subject">Subject *</label>
                                    <input type="text" id="subject" name="subject" required class="form-control form-control-sm border-danger-subtle" placeholder="Short and clear subject">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold" id="label-body-text">Detailed Description *</label>
                                    <textarea id="body" name="body" rows="4" required class="form-control form-control-sm border-danger-subtle" placeholder="Describe your complaint..."></textarea>
                                </div>
                            </div>

                            {{-- Right Column: Identity & Contact --}}
                            <div class="col-md-6 ps-md-4">
                                <h6 class="text-danger fw-bold mb-3 border-bottom pb-2" id="title-contact">Identity & Contact</h6>
                                <div class="form-check form-switch p-3 bg-danger-subtle rounded mb-2 border border-danger-subtle">
                                    <input id="is_anonymous" name="is_anonymous" type="checkbox" role="switch" onchange="window.toggleGuestFields()" class="form-check-input" {{ old('is_anonymous') ? 'checked' : '' }}>
                                    <label for="is_anonymous" class="form-check-label fw-bold text-danger" id="label-anonymous">I wish to remain Anonymous.</label>
                                </div>
                                <p class="small text-muted mb-3" id="text-anonymous-warning" style="font-size: 0.8rem;">If you choose this, your identity will be hidden.</p>

                                <div id="guest-fields" class="p-3 border rounded bg-light shadow-sm">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <label class="form-label small mb-1 fw-bold" id="label-email">Email *</label>
                                            <input type="email" id="guest_email" name="guest_email" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label class="form-label small mb-1 fw-bold" id="label-name">Full Name (Optional)</label>
                                            <input type="text" id="guest_name" name="guest_name" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label class="form-label small mb-1 fw-bold" id="label-type">Reporter Type *</label>
                                            <select id="guest_type" name="guest_type" class="form-select form-select-sm">
                                                <option value="" id="option-select-type">Select Type</option>
                                                <option value="Student">Student</option>
                                                <option value="Teacher">Teacher</option>
                                                <option value="Employee">Employee</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" id="button-submit" class="btn btn-danger w-100 py-2 fw-bold shadow-sm">
                                        <i class="fas fa-file-signature me-2"></i> Submit Complaint
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

<style>
    .complaint-card { 
        transition: transform 0.3s ease, box-shadow 0.3s ease; 
        border-top: 5px solid #dc3545 !important; 
    }
    .complaint-card:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 15px 30px rgba(220, 53, 69, 0.15) !important; 
    }
    .border-danger-subtle { border-color: #f5c2c7 !important; }
</style>

<script>
    window.translations = {
        'am': {
            'main-title': 'ቅሬታ ማስገቢያ',
            'subtitle': 'ቅሬታዎን የሚመለከተውን ክፍል በመምረጥ ዝርዝር ሁኔታውን ያስገቡ።',
            'title-recipient-info': 'ቅሬታው የሚቀርብበት አካል መረጃ',
            'label-recipient-type': 'የመቀበያ አይነት:',
            'option-select-recipient-type': 'አይነት ይምረጡ',
            'option-college': 'ኮሌጅ',
            'option-department': 'ዲፓርትመንት',
            'option-directory': 'ዳይሬክቶሬት',
            'label-filter-college': 'ቅድሚያ ኮሌጅ ይምረጡ:',
            'option-select-filter-college': 'ኮሌጅ ይምረጡ',
            'label-recipient-id': 'ክፍሉን ይምረጡ:',
            'option-select-recipient': 'ክፍል ይምረጡ',
            'label-subject': 'ርዕስ:',
            'label-description': 'የአቤቱታ ዝርዝር',
            'label-body-text': 'ዝርዝር መግለጫ:',
            'label-anonymous': 'ስም-አልባ መሆን እፈልጋለሁ።',
            'text-anonymous-warning': 'ማንነትዎ ይደበቃል፣ ነገር ግን ምላሽ ላይደርስዎት ይችላል።',
            'title-contact': 'ማንነትና እውቂያ',
            'label-email': 'ኢሜይል:',
            'label-name': 'ሙሉ ስም (አማራጭ):',
            'label-type': 'የአመልካች አይነት:',
            'option-select-type': 'ይምረጡ',
            'button-submit': 'ቅሬታ አስገባ'
        },
        'en': {
            'main-title': 'Complaint Submission',
            'subtitle': 'Please select the relevant unit and enter your complaint details.',
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
            'label-subject': 'Subject:',
            'label-description': 'Complaint Content',
            'label-body-text': 'Detailed Description:',
            'label-anonymous': 'I wish to remain Anonymous.',
            'text-anonymous-warning': 'If you choose this, your identity will be hidden.',
            'title-contact': 'Identity & Contact',
            'label-email': 'Email:',
            'label-name': 'Full Name (Optional):',
            'label-type': 'Reporter Type:',
            'option-select-type': 'Select Type',
            'button-submit': 'Submit Complaint'
        }
    };

    let currentLanguage = 'en';

    window.switchLanguage = (lang) => {
        currentLanguage = lang;
        const t = window.translations[lang];
        for (let key in t) {
            const el = document.getElementById(key);
            if (el) el.textContent = t[key];
        }
        // Update placeholders
        document.getElementById('subject').placeholder = lang === 'am' ? 'አጭር ርዕስ' : 'Short subject';
        document.getElementById('body').placeholder = lang === 'am' ? 'ዝርዝር መረጃ እዚህ ይጻፉ...' : 'Describe your complaint...';
    };

    window.handleTypeChange = async () => {
        const type = document.getElementById('recipient_type').value;
        const collegeFilter = document.getElementById('college_filter_container');
        const idSelect = document.getElementById('recipient_id');
        
        idSelect.innerHTML = `<option value="">${window.translations[currentLanguage]['option-select-recipient']}</option>`;
        collegeFilter.classList.add('d-none');

        if (type === 'College') {
            window.loadUnits('{{ route("api.colleges.list") }}');
        } else if (type === 'Directory') {
            window.loadUnits('{{ route("api.directories.list") }}');
        } else if (type === 'Department') {
            collegeFilter.classList.remove('d-none');
            window.fillCollegeFilter();
        }
    };

    window.fillCollegeFilter = async () => {
        const filterSelect = document.getElementById('filter_college_id');
        try {
            const response = await fetch('{{ route("api.colleges.list") }}');
            const colleges = await response.json();
            filterSelect.innerHTML = `<option value="">${window.translations[currentLanguage]['option-select-filter-college']}</option>`;
            colleges.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.id;
                const nameAm = c.name_am || c.name_en;
                opt.textContent = currentLanguage === 'am' ? nameAm : c.name_en;
                opt.setAttribute('data-am-name', nameAm);
                opt.setAttribute('data-en-name', c.name_en);
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
        loading.classList.remove('d-none');
        idSelect.disabled = true;

        try {
            const response = await fetch(url);
            const data = await response.json();
            idSelect.innerHTML = `<option value="">${window.translations[currentLanguage]['option-select-recipient']}</option>`;
            data.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.id;
                const nameAm = item.name_am || item.name_en;
                opt.textContent = currentLanguage === 'am' ? nameAm : item.name_en;
                opt.setAttribute('data-am-name', nameAm);
                opt.setAttribute('data-en-name', item.name_en);
                idSelect.appendChild(opt);
            });
            idSelect.disabled = false;
        } catch (e) { console.error(e); }
        loading.classList.add('d-none');
    };

    window.toggleGuestFields = () => {
        const isAnon = document.getElementById('is_anonymous').checked;
        document.getElementById('guest-fields').classList.toggle('d-none', isAnon);
    };

    document.addEventListener('DOMContentLoaded', () => {
        window.switchLanguage('en');
        window.toggleGuestFields();
    });
</script>
@endsection