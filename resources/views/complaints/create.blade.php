@extends('layouts.wel')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="card p-4 shadow-lg border-0 complaint-theme">

                    <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center border-bottom pb-3" id="main-title">
                        <i class="fas fa-exclamation-triangle text-danger me-2"></i> Complaint Submission
                    </h1>
                    <p class="text-muted mb-4 text-center" id="subtitle">Please select the relevant unit and enter the details of your complaint.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger p-3 mb-4">
                            <ul class="list-unstyled mb-0">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fas fa-times-circle me-2"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success text-center mb-4">{{ session('success') }}</div>
                    @endif

                    <form action="{{route('complaints.submit')}}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        
                        {{-- ቋንቋ መምረጫ --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="language_selector" class="form-label" id="label-language">Select Language:</label>
                                <select id="language_selector" onchange="window.switchLanguage(this.value)"
                                        class="form-select bg-danger-subtle border-danger">
                                    <option value="am">አማርኛ</option>
                                    <option value="en" selected>English</option>
                                </select>
                            </div>
                        </div>

                        <h5 class="text-dark border-bottom pb-2 mt-4 mb-3" id="title-recipient-info">Recipient Information</h5>

                        <div class="row g-3 mb-4">
                            {{-- 1. Recipient Type --}}
                            <div class="col-md-6">
                                <label for="recipient_type" class="form-label" id="label-recipient-type">Recipient Type: <span class="text-danger">*</span></label>
                                <select id="recipient_type" name="recipient_type" required 
                                        class="form-select @error('recipient_type') is-invalid @enderror" onchange="window.handleTypeChange()">
                                    <option value="" id="option-select-recipient-type">Select Type</option>
                                    <option value="College" {{ old('recipient_type') == 'College' ? 'selected' : '' }} id="option-college">College</option>
                                    <option value="Department" {{ old('recipient_type') == 'Department' ? 'selected' : '' }} id="option-department">Department</option>
                                    <option value="Directory" {{ old('recipient_type') == 'Directory' ? 'selected' : '' }} id="option-directory">Directory</option>
                                </select>
                            </div>
                            
                            {{-- 2. College Filter (Department ሲመረጥ ብቻ የሚታይ) --}}
                            <div class="col-md-6 d-none" id="college_filter_container">
                                <label for="filter_college_id" class="form-label" id="label-filter-college">Select College first: <span class="text-danger">*</span></label>
                                <select id="filter_college_id" class="form-select" onchange="window.loadDepartmentsByCollege(this.value)">
                                    <option value="" id="option-select-filter-college">Choose College</option>
                                </select>
                            </div>

                            {{-- 3. Actual Recipient ID --}}
                            <div class="col-md-6">
                                <label for="recipient_id" class="form-label" id="label-recipient-id">Select Recipient: <span class="text-danger">*</span></label>
                                <select id="recipient_id" name="recipient_id" required 
                                        class="form-select @error('recipient_id') is-invalid @enderror">
                                    <option value="" id="option-select-recipient">Select Recipient Unit</option>
                                </select>
                                <small class="form-text text-danger d-none" id="loading-text"></small>
                            </div>
                        </div>
                        
                        <h5 class="text-dark border-bottom pb-2 mt-4 mb-3" id="title-complaint-details">Complaint Details</h5>

                        <div class="mb-3">
                            <label for="subject" class="form-label" id="label-subject">Subject: <span class="text-danger">*</span></label>
                            <input type="text" id="subject" name="subject" required
                                class="form-control @error('subject') is-invalid @enderror"
                                value="{{ old('subject') }}" placeholder="Short and clear subject">
                        </div>

                        <div class="mb-4">
                            <label for="body" class="form-label" id="label-description">Detailed Description: <span class="text-danger">*</span></label>
                            <textarea id="body" name="body" rows="5" required
                                class="form-control @error('body') is-invalid @enderror"
                                placeholder="Describe your complaint in detail...">{{ old('body') }}</textarea>
                        </div>
                        
                       <div class="form-check p-3 bg-info-subtle rounded border border-primary-subtle mb-4">
                            <input id="is_anonymous" name="is_anonymous" type="checkbox" onchange="window.toggleGuestFields()"
                                class="form-check-input text-primary" {{ old('is_anonymous') ? 'checked' : '' }}>
                            <label for="is_anonymous" class="form-check-label text-primary" id="label-anonymous">I wish to remain Anonymous.</label>
                        </div>
                        <p class="text-sm text-danger mb-4" id="text-anonymous-warning">If you choose this, your identity will be hidden, but you may not receive a response.</p>

                        <div id="guest-fields" class="space-y-4 pt-4 border-top border-gray-200" style="display: none;">
                            <h5 class="h5 text-dark border-bottom pb-2" id="title-contact">Contact Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="guest_email" class="form-label" id="label-email">Email: <span class="text-danger">*</span></label>
                                    <input type="email" id="guest_email" name="guest_email" class="form-control" value="{{ old('guest_email') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="guest_name" class="form-label" id="label-name">Name (Optional):</label>
                                    <input type="text" id="guest_name" name="guest_name" class="form-control" value="{{ old('guest_name') }}">
                                </div>
                                <div class="col-12">
                                    <label for="guest_type" class="form-label" id="label-type">Reporter Type: <span class="text-danger">*</span></label>
                                    <select id="guest_type" name="guest_type" class="form-select">
                                        <option value="" id="option-select-type">Select Type</option>
                                        <option value="Student">Student</option>
                                        <option value="Teacher">Teacher</option>
                                        <option value="Employee">Employee</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="button-submit" class="btn btn-danger w-100 mt-4 py-2 fw-bold">
                            <i class="fas fa-file-signature me-2"></i> Submit Complaint
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    window.translations = {
        'am': {
            'main-title': 'ቅሬታ ማስገቢያ',
            'subtitle': 'ቅሬታዎን የሚመለከተውን ክፍል በመምረጥ ዝርዝር ሁኔታውን ያስገቡ።',
            'label-language': 'ቋንቋ ይምረጡ:',
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
            'placeholder-subject': 'አጭርና ግልጽ ርዕስ',
            'label-description': 'ዝርዝር መግለጫ:',
            'placeholder-description': 'ቅሬታዎን በዝርዝር ያስቀምጡ...',
            'label-anonymous': 'ስም-አልባ መሆን እፈልጋለሁ።',
            'text-anonymous-warning': 'ይህን ከመረጡ ማንነትዎ ይደበቃል፣ ነገር ግን ምላሽ ላይደርስዎት ይችላል።',
            'title-contact': 'የእውቂያ መረጃ',
            'label-email': 'ኢሜይል:',
            'label-name': 'ስም (አማራጭ):',
            'label-type': 'የሪፖርተር አይነት:',
            'option-select-type': 'ይመድቡ',
            'button-submit': 'ቅሬታ አስገባ'
        },
        'en': {
            'main-title': 'Complaint Submission',
            'subtitle': 'Please select the relevant unit and enter the details of your complaint.',
            'label-language': 'Select Language:',
            'title-recipient-info': 'Recipient Information',
            'label-recipient-type': 'Recipient Type:',
            'option-select-recipient-type': 'Select Type',
            'option-college': 'College',
            'option-department': 'Department',
            'option-directory': 'Directory',
            'label-filter-college': 'Select College first:',
            'option-select-filter-college': ' Choose College ',
            'label-recipient-id': 'Select Recipient:',
            'option-select-recipient': 'Select Recipient Unit',
            'label-subject': 'Subject:',
            'placeholder-subject': 'Short and clear subject',
            'label-description': 'Detailed Description:',
            'placeholder-description': 'Describe your complaint in detail...',
            'label-anonymous': 'I wish to remain Anonymous.',
            'text-anonymous-warning': 'If you choose this, your identity will be hidden, but you may not receive a response.',
            'title-contact': 'Contact Information',
            'label-email': 'Email:',
            'label-name': 'Name (Optional):',
            'label-type': 'Reporter Type:',
            'option-select-type': 'Select Type',
            'button-submit': 'Submit Complaint'
        }
    };

    let currentLanguage = 'en';

    window.handleTypeChange = async () => {
        const type = document.getElementById('recipient_type').value;
        const collegeFilter = document.getElementById('college_filter_container');
        const idSelect = document.getElementById('recipient_id');
        
        // Reset
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
//next use this AJAX
    window.fillCollegeFilter = async () => {
        const filterSelect = document.getElementById('filter_college_id');
        try {
            const response = await fetch('{{ route('api.colleges.list') }}');
            const colleges = await response.json();
            filterSelect.innerHTML = `<option value="">${window.translations[currentLanguage]['option-select-filter-college']}</option>`;
            colleges.forEach(c => {
                const name = currentLanguage === 'am' ? (c.name_am || c.name_en) : c.name_en;
                filterSelect.innerHTML += `<option value="${c.id}">${name}</option>`;
            });
        } catch (e) { console.error(e); }
    };

    window.loadDepartmentsByCollege = (collegeId) => {
        if (!collegeId) return;
        window.loadUnits(`{{ url('/api/colleges') }}/${collegeId}/departments`);
    };
//use this AJAX 
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
        loading.classList.add('d-none');
    };

    window.switchLanguage = (lang) => {
        currentLanguage = lang;
        const t = window.translations[lang];
        
        // Update all IDs
        for (let key in t) {
            const el = document.getElementById(key);
            if (el) el.textContent = t[key];
        }

        // Placeholders
        document.getElementById('subject').placeholder = t['placeholder-subject'];
        document.getElementById('body').placeholder = t['placeholder-description'];

        // Dynamic units names update
        const idSelect = document.getElementById('recipient_id');
        Array.from(idSelect.options).forEach(opt => {
            if(opt.value === "") opt.textContent = t['option-select-recipient'];
            else opt.textContent = opt.getAttribute(`data-${lang}-name`) || opt.textContent;
        });
        // 4. አዲስ የተጨመረ፦ የ "ኮሌጅ መምረጫ (Filter)" ዝርዝር ስሞችን ቀይር
    const filterSelect = document.getElementById('filter_college_id');
    if (filterSelect) {
        Array.from(filterSelect.options).forEach(opt => {
            if(opt.value === "") {
                opt.textContent = t['option-select-filter-college'];
            } else {
                // እዚህ ጋር በ fillCollegeFilter ጊዜ የተቀመጠውን ዳታ እንጠቀማለን
                opt.textContent = opt.getAttribute(`data-${lang}-name`) || opt.textContent;
            }
        });
    }
    };

    window.toggleGuestFields = () => {
        const isAnon = document.getElementById('is_anonymous').checked;
        document.getElementById('guest-fields').style.display = isAnon ? 'none' : 'block';
    };

    document.addEventListener('DOMContentLoaded', () => {
        window.switchLanguage('en');
        window.toggleGuestFields();
    });
</script>
@endsection