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

                        {{-- =============================================== --}}
                        {{-- 🆕 Polymorphic Recipient Fields --}}
                        {{-- =============================================== --}}
                        <h5 class="text-dark border-bottom pb-2 mt-4 mb-3" id="title-recipient-info">Recipient Information</h5>

                        <div class="row g-3 mb-4">
                            {{-- 1. Recipient Type (College/Department/Directory) --}}
                            <div class="col-md-6">
                                <label for="recipient_type" class="form-label" id="label-recipient-type">Recipient Type: <span class="text-danger">*</span></label>
                                <select id="recipient_type" name="recipient_type" required 
                                        class="form-select @error('recipient_type') is-invalid @enderror" onchange="window.loadRecipientUnits()">
                                    <option value="" id="option-select-recipient-type">Select Type</option>
                                    <option value="College" {{ old('recipient_type') == 'College' ? 'selected' : '' }} id="option-college">College</option>
                                    <option value="Department" {{ old('recipient_type') == 'Department' ? 'selected' : '' }} id="option-department">Department</option>
                                    <option value="Directory" {{ old('recipient_type') == 'Directory' ? 'selected' : '' }} id="option-directory">Directory</option>
                                </select>
                                <div class="invalid-feedback">Please select a recipient type.</div>
                            </div>
                            
                            {{-- 2. Actual Recipient ID (Dynamic Dropdown) --}}
                            <div class="col-md-6">
                                <label for="recipient_id" class="form-label" id="label-recipient-id">Select Recipient: <span class="text-danger">*</span></label>
                                <select id="recipient_id" name="recipient_id" required 
                                        class="form-select @error('recipient_id') is-invalid @enderror">
                                    <option value="" id="option-select-recipient">Select Recipient Unit</option>
                                    {{-- Dynamic content loaded via AJAX/JS here --}}
                                </select>
                                <div class="invalid-feedback">Please select a recipient unit.</div>
                                <small class="form-text text-danger d-none" id="loading-text">Loading...</small>
                            </div>
                        </div>
                        {{-- =============================================== --}}
                        
                        <h5 class="text-dark border-bottom pb-2 mt-4 mb-3" id="title-complaint-details">Complaint Details</h5>

                        <div class="mb-3">
                            <label for="subject" class="form-label" id="label-subject">Subject: <span class="text-danger">*</span></label>
                            <input type="text" id="subject" name="subject" required
                                class="form-control @error('subject') is-invalid @enderror"
                                value="{{ old('subject') }}" placeholder="Short and clear subject">
                            <div class="invalid-feedback">Subject is required.</div>
                        </div>

                        <div class="mb-4">
                            <label for="body" class="form-label" id="label-description">Detailed Description: <span class="text-danger">*</span></label>
                            <textarea id="body" name="body" rows="5" required
                                class="form-control @error('body') is-invalid @enderror"
                                placeholder="Describe your complaint in detail...">{{ old('body') }}</textarea>
                            <div class="invalid-feedback">Description is required.</div>
                        </div>
                        
                        {{-- ስም-አልባ አማራጭ --}}
                        <div class="form-check p-3 bg-danger-subtle rounded border border-danger-subtle mb-4">
                            <input id="is_anonymous" name="is_anonymous" type="checkbox" onchange="window.toggleGuestFields()"
                                class="form-check-input text-danger" {{ old('is_anonymous') ? 'checked' : '' }}>
                            <label for="is_anonymous" class="form-check-label text-danger" id="label-anonymous">I wish to remain Anonymous.</label>
                        </div>
                        <p class="text-sm text-danger mb-4" id="text-anonymous-warning">If you choose this, your identity will be hidden, but you may not receive a response.</p>

                        {{-- የእውቂያ መረጃ --}}
                        <div id="guest-fields" class="space-y-4 pt-4 border-top border-gray-200" style="display: none;">
                            <h5 class="h5 text-dark border-bottom pb-2" id="title-contact">Contact Information (Required for Response)</h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="guest_email" class="form-label" id="label-email">Email (for response): <span class="text-danger">*</span></label>
                                    <input type="email" id="guest_email" name="guest_email"
                                        class="form-control @error('guest_email') is-invalid @enderror"
                                        value="{{ old('guest_email') }}" placeholder="Email where you expect a response">
                                    <div class="invalid-feedback">Valid email is required.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="guest_name" class="form-label" id="label-name">Name (Optional):</label>
                                    <input type="text" id="guest_name" name="guest_name" class="form-control @error('guest_name') is-invalid @enderror"
                                        value="{{ old('guest_name') }}" placeholder="Full Name">
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <label for="guest_type" class="form-label" id="label-type">Reporter Type: <span class="text-danger">*</span></label>
                                <select id="guest_type" name="guest_type" class="form-select @error('guest_type') is-invalid @enderror">
                                    <option value="" id="option-select-type" {{ old('guest_type') == '' ? 'selected' : '' }}>Select Type</option>
                                    <option value="Student" {{ old('guest_type') == 'Student' ? 'selected' : '' }} id="option-student">Student</option>
                                    <option value="Teacher" {{ old('guest_type') == 'Teacher' ? 'selected' : '' }} id="option-teacher">Teacher</option>
                                    <option value="Employee" {{ old('guest_type') == 'Employee' ? 'selected' : '' }} id="option-employee">Employee</option>
                                    <option value="Other" {{ old('guest_type') == 'Other' ? 'selected' : '' }} id="option-other">Other</option>
                                </select>
                                <div class="invalid-feedback">Reporter type is required.</div>
                            </div>
                        </div>

                        <button type="submit" id="button-submit"
                            class="btn btn-danger w-100 mt-4 py-2 fw-bold complaint-button">
                            <i class="fas fa-file-signature me-2"></i> Submit Complaint
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // ===============================================================
    // ቋንቋ መቀያየሪያ (Translations)
    // ===============================================================
    window.translations = {
        'am': {
            'doc-title-feedback': 'ቅሬታ ማስገቢያ',
            'main-title': 'ቅሬታ ማስገቢያ',
            'subtitle': 'ቅሬታዎን የሚመለከተውን ክፍል በመምረጥ ዝርዝር ሁኔታውን ያስገቡ።',
            'label-language': 'ቋንቋ ይምረጡ:',
            
            // Recipient Fields
            'title-recipient-info': 'ቅሬታው የሚቀርብበት አካል መረጃ',
            'label-recipient-type': 'የመቀበያ አይነት:',
            'option-select-recipient-type': 'አይነት ይምረጡ',
            'option-college': 'ኮሌጅ',
            'option-department': 'ዲፓርትመንት',
            'option-directory': 'ዳይሬክቶሬት',
            'label-recipient-id': 'የመቀበያ ክፍሉን ይምረጡ:',
            'option-select-recipient': 'ክፍል ይምረጡ',
            
            // Complaint Details
            'title-complaint-details': 'የቅሬታ ዝርዝሮች',
            'label-subject': 'ርዕስ:',
            'placeholder-subject': 'አጭርና ግልጽ ርዕስ',
            'label-description': 'ዝርዝር መግለጫ:',
            'placeholder-description': 'ቅሬታዎን በዝርዝር ያስቀምጡ...',
            
            // Anonymous & Contact
            'label-anonymous': 'ስም-አልባ መሆን እፈልጋለሁ።',
            'text-anonymous-warning': 'ይህን ከመረጡ፣ ማንነትዎ ሙሉ በሙሉ ይደበቃል፣ ነገር ግን ምላሽ ላይደርስዎት ይችላል።',
            'title-contact': 'የእውቂያ መረጃ (ለምላሽ አስፈላጊ)',
            'label-email': 'ኢሜይል (ለአጸፋ መልስ):',
            'placeholder-email': 'ምላሽ የሚደርስበት ኢሜይል',
            'label-name': 'ስም (አማራጭ):',
            'placeholder-name': 'ሙሉ ስም',
            'label-type': 'ሪፖርተር አይነት:',
            'option-select-type': 'ይመድቡ',
            'option-student': 'ተማሪ',
            'option-teacher': 'መምህር',
            'option-employee': 'ሰራተኛ',
            'option-other': 'ሌላ',
            'button-submit': 'ቅሬታ አስገባ',
        },
        'en': {
            'doc-title-feedback': 'Complaint Submission Form',
            'main-title': 'Complaint Submission',
            'subtitle': 'Please select the relevant unit and enter the details of your complaint.',
            'label-language': 'Select Language:',

            // Recipient Fields
            'title-recipient-info': 'Recipient Information',
            'label-recipient-type': 'Recipient Type:',
            'option-select-recipient-type': 'Select Type',
            'option-college': 'College',
            'option-department': 'Department',
            'option-directory': 'Directory',
            'label-recipient-id': 'Select Recipient:',
            'option-select-recipient': 'Select Recipient Unit',

            // Complaint Details
            'title-complaint-details': 'Complaint Details',
            'label-subject': 'Subject:',
            'placeholder-subject': 'Short and clear subject',
            'label-description': 'Detailed Description:',
            'placeholder-description': 'Describe your complaint in detail...',

            // Anonymous & Contact
            'label-anonymous': 'I wish to remain Anonymous.',
            'text-anonymous-warning': 'If you choose this, your identity will be hidden, but you may not receive a response.',
            'title-contact': 'Contact Information (Required for Response)',
            'label-email': 'Email (for response):',
            'placeholder-email': 'Email where you expect a response',
            'label-name': 'Name (Optional):',
            'placeholder-name': 'Full Name',
            'label-type': 'Reporter Type:',
            'option-select-type': 'Select Type',
            'option-student': 'Student',
            'option-teacher': 'Teacher',
            'option-employee': 'Employee',
            'option-other': 'Other',
            'button-submit': 'Submit Complaint',
        }
    };

    let currentLanguage = 'en';

    // ===============================================================
    // Polymorphic Unit Loading (AJAX)
    // ===============================================================

    /**
     * Loads the list of units (Colleges, Departments, or Directories) based on the selected type.
     */
    window.loadRecipientUnits = async () => {
        const typeSelect = document.getElementById('recipient_type');
        const idSelect = document.getElementById('recipient_id');
        const loadingText = document.getElementById('loading-text');
        const selectedType = typeSelect.value;
        
        const lang = currentLanguage;
        
        // Reset the recipient dropdown
        idSelect.innerHTML = `<option value="">${window.translations[lang]['option-select-recipient']}</option>`;
        idSelect.disabled = true;
        
        if (!selectedType) {
            return;
        }

        loadingText.classList.remove('d-none');

        let apiUrl = '';

        if (selectedType === 'College') {
            // Assuming this route exists and returns JSON list of colleges
            apiUrl = '{{ route('api.colleges.list') }}'; 
        } else if (selectedType === 'Directory') {
            // Assuming this route exists and returns JSON list of directories
            apiUrl = '{{ route('api.directories.list') }}';
        } else if (selectedType === 'Department') {
            // Assuming this route exists and returns JSON list of all departments
            apiUrl = '{{ url('/api/departments/list/all') }}'; 
        } else {
            loadingText.classList.add('d-none');
            idSelect.disabled = false;
            return;
        }

        try {
            const response = await fetch(apiUrl);
            if (!response.ok) {
                 throw new Error(`HTTP error! status: ${response.status}`);
            }
            const units = await response.json();

            units.forEach(unit => {
                // Ensure names exist or fallback
                const nameAm = unit.name_am || unit.name_en || unit.code || unit.id;
                const nameEn = unit.name_en || unit.code || unit.id;
                
                const option = document.createElement('option');
                option.value = unit.id;
                option.textContent = lang === 'am' ? nameAm : nameEn;
                option.setAttribute('data-am-name', nameAm);
                option.setAttribute('data-en-name', nameEn);

                idSelect.appendChild(option);
            });

            idSelect.disabled = false;
        } catch (error) {
            console.error('Error loading recipient units:', error);
            idSelect.innerHTML = `<option value="" disabled>${lang === 'am' ? 'ዳታ መጫን አልተቻለም' : 'Failed to load data'}</option>`;
        } finally {
            loadingText.classList.add('d-none');
            idSelect.disabled = false;
        }
    };

    /**
     * Switches the entire form's language.
     */
    window.switchLanguage = (lang) => {
        currentLanguage = lang;
        document.title = window.translations[lang]['doc-title-feedback'];
        
        // 1. Update text content
        Object.keys(window.translations[lang]).forEach(key => {
            const element = document.getElementById(key);
            if (element && !key.startsWith('placeholder-') && !key.startsWith('option-')) {
                element.textContent = window.translations[lang][key];
            }
        });

        // 2. Update placeholders
        document.getElementById('subject').placeholder = window.translations[lang]['placeholder-subject'];
        document.getElementById('body').placeholder = window.translations[lang]['placeholder-description'];
        document.getElementById('guest_email').placeholder = window.translations[lang]['placeholder-email'];
        document.getElementById('guest_name').placeholder = window.translations[lang]['placeholder-name'];

        // 3. Update reporter type options
        document.getElementById('option-select-type').textContent = window.translations[lang]['option-select-type'];
        document.getElementById('option-student').textContent = window.translations[lang]['option-student'];
        document.getElementById('option-teacher').textContent = window.translations[lang]['option-teacher'];
        document.getElementById('option-employee').textContent = window.translations[lang]['option-employee'];
        document.getElementById('option-other').textContent = window.translations[lang]['option-other'];

        // 4. Update Recipient Type options
        document.getElementById('option-select-recipient-type').textContent = window.translations[lang]['option-select-recipient-type'];
        document.getElementById('option-college').textContent = window.translations[lang]['option-college'];
        document.getElementById('option-department').textContent = window.translations[lang]['option-department'];
        document.getElementById('option-directory').textContent = window.translations[lang]['option-directory'];

        // 5. Update dynamically loaded Recipient ID options
        const idSelect = document.getElementById('recipient_id');
        const nameKey = lang === 'am' ? 'am-name' : 'en-name';

        Array.from(idSelect.options).forEach(option => {
            if (option.value === "") {
                option.textContent = window.translations[lang]['option-select-recipient'];
            } else {
                const unitName = option.getAttribute(`data-${nameKey}`);
                if (unitName) {
                    option.textContent = unitName;
                }
            }
        });
    };

    /**
     * Toggles visibility and 'required' attributes for contact fields.
     */
    window.toggleGuestFields = () => {
        const isAnonymous = document.getElementById('is_anonymous').checked;
        const guestFields = document.getElementById('guest-fields');
        const guestEmail = document.getElementById('guest_email');
        const guestType = document.getElementById('guest_type');

        if (isAnonymous) {
            guestFields.style.display = 'none'; 
            guestEmail.removeAttribute('required');
            guestType.removeAttribute('required');
        } else {
            guestFields.style.display = 'block'; 
            guestEmail.setAttribute('required', 'required');
            guestType.setAttribute('required', 'required');
        }
    };

    // ===============================================================
    // Initialization
    // ===============================================================
    document.addEventListener('DOMContentLoaded', () => {
        // Set initial language to English
        document.getElementById('language_selector').value = 'en';
        window.switchLanguage('en'); 

        // Initial check for anonymous checkbox state
        window.toggleGuestFields();
        
        // Load recipient units if a type was previously selected (e.g., after validation error)
        if (document.getElementById('recipient_type').value) {
            window.loadRecipientUnits();
        }
    });
</script>
@endsection