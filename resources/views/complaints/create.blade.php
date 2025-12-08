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
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="language_selector" class="form-label" id="label-language">Select Language:</label>
                                <select id="language_selector" onchange="window.switchLanguage(this.value)"
                                        class="form-select bg-danger-subtle border-danger">
                                    <option value="am">አማርኛ</option>
                                    <option value="en" selected>English</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="unit_id" class="form-label" id="label-unit">Unit/Department Concerned: <span class="text-danger">*</span></label>
                                <select id="unit_id" name="unit_id" required class="form-select">
                                    <option value="" id="option-select-unit">Select Unit</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            data-am="{{ $unit->name_am ?? $unit->id }}"
                                            data-en="{{ $unit->name_en ?? $unit->id }}">
                                            {{ $unit->name_en ?? $unit->name_am ?? $unit->code ?? $unit->id }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a unit.</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label" id="label-subject">Subject: <span class="text-danger">*</span></label>
                            <input type="text" id="subject" name="subject" required
                                class="form-control"
                                placeholder="Short and clear subject" id="placeholder-subject">
                            <div class="invalid-feedback">Subject is required.</div>
                        </div>

                        <div class="mb-4">
                            <label for="body" class="form-label" id="label-description">Detailed Description: <span class="text-danger">*</span></label>
                            <textarea id="body" name="body" rows="5" required
                                class="form-control"
                                placeholder="Describe your complaint in detail..." id="placeholder-description"></textarea>
                            <div class="invalid-feedback">Description is required.</div>
                        </div>
                        
                        <div class="form-check p-3 bg-danger-subtle rounded border border-danger-subtle mb-4">
                            <input id="is_anonymous" name="is_anonymous" type="checkbox" onchange="window.toggleGuestFields()"
                                class="form-check-input text-danger">
                            <label for="is_anonymous" class="form-check-label text-danger" id="label-anonymous">I wish to remain Anonymous.</label>
                        </div>
                        <p class="text-sm text-danger mb-4" id="text-anonymous-warning">If you choose this, your identity will be hidden, but you may not receive a response.</p>

                        <div id="guest-fields" class="space-y-4 pt-4 border-top border-gray-200">
                            <h2 class="h5 text-dark border-bottom pb-2" id="title-contact">Contact Information (Required for Response)</h2>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="guest_email" class="form-label" id="label-email">Email (for response): <span class="text-danger">*</span></label>
                                    <input type="email" id="guest_email" name="guest_email" required
                                        class="form-control"
                                        placeholder="Email where you expect a response" id="placeholder-email">
                                    <div class="invalid-feedback">Valid email is required.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="guest_name" class="form-label" id="label-name">Name (Optional):</label>
                                    <input type="text" id="guest_name" name="guest_name" class="form-control"
                                        placeholder="Full Name" id="placeholder-name">
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <label for="guest_type" class="form-label" id="label-type">Reporter Type: <span class="text-danger">*</span></label>
                                <select id="guest_type" name="guest_type" required class="form-select">
                                    <option value="" id="option-select-type">Select Type</option>
                                    <option value="Student" id="option-student">Student</option>
                                    <option value="Teacher" id="option-teacher">Teacher</option>
                                    <option value="Employee" id="option-employee">Employee</option>
                                    <option value="Other" id="option-other">Other</option>
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
    window.translations = {
        'am': {
            'doc-title-feedback': 'ቅሬታ ማስገቢያ',
            'main-title': 'ቅሬታ ማስገቢያ',
            'subtitle': 'ቅሬታዎን የሚመለከተውን ክፍል በመምረጥ ዝርዝር ሁኔታውን ያስገቡ።',
            'label-language': 'ቋንቋ ይምረጡ:',
            'label-unit': 'ቅሬታው የሚመለከተው ክፍል/ዩኒት:',
            'option-select-unit': 'ክፍል ይምረጡ',
            'label-subject': 'ርዕስ:',
            'placeholder-subject': 'አጭርና ግልጽ ርዕስ',
            'label-description': 'ዝርዝር መግለጫ:', 
            'placeholder-description': 'ቅሬታዎን በዝርዝር ያስቀምጡ...',
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
            'label-unit': 'Unit/Department Concerned:',
            'option-select-unit': 'Select Unit',
            'label-subject': 'Subject:',
            'placeholder-subject': 'Short and clear subject',
            'label-description': 'Detailed Description:', 
            'placeholder-description': 'Describe your complaint in detail...',
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
    }

    // እነዚህ ተግባራት (functions) ከላይ ካለው Feedback JS ጋር አንድ አይነት ናቸው።
    window.updateUnitOptions = (lang) => {
        const unitSelect = document.getElementById('unit_id');
        const nameKey = lang === 'am' ? 'am' : 'en';

        Array.from(unitSelect.options).forEach(option => {
            if (option.value === "") {
                option.textContent = window.translations[lang]['option-select-unit'];
            } else {
                const unitName = option.getAttribute(`data-${nameKey}`);
                option.textContent = unitName; 
            }
        });
    };

    window.switchLanguage = (lang) => {
        document.title = window.translations[lang]['doc-title-feedback'];
        
        Object.keys(window.translations[lang]).forEach(key => {
            const element = document.getElementById(key);
            if (element && !key.startsWith('placeholder-') && !key.startsWith('option-')) {
                element.textContent = window.translations[lang][key];
            }
        });

        document.getElementById('subject').placeholder = window.translations[lang]['placeholder-subject'];
        document.getElementById('body').placeholder = window.translations[lang]['placeholder-description'];
        document.getElementById('guest_email').placeholder = window.translations[lang]['placeholder-email'];
        document.getElementById('guest_name').placeholder = window.translations[lang]['placeholder-name'];

        document.getElementById('option-select-type').textContent = window.translations[lang]['option-select-type'];
        document.getElementById('option-student').textContent = window.translations[lang]['option-student'];
        document.getElementById('option-teacher').textContent = window.translations[lang]['option-teacher'];
        document.getElementById('option-employee').textContent = window.translations[lang]['option-employee'];
        document.getElementById('option-other').textContent = window.translations[lang]['option-other'];

        window.updateUnitOptions(lang);
    };

    window.toggleGuestFields = () => {
        const isAnonymous = document.getElementById('is_anonymous').checked;
        const guestFields = document.getElementById('guest-fields');
        const guestEmail = document.getElementById('guest_email');
        const guestType = document.getElementById('guest_type');

        if (isAnonymous) {
            // Use Bootstrap utility class for hiding
            guestFields.classList.add('d-none'); 
            
            guestEmail.removeAttribute('required');
            guestType.removeAttribute('required');
            guestEmail.value = '';
            guestType.value = '';
        } else {
            // Use Bootstrap utility class for showing
            guestFields.classList.remove('d-none'); 
            
            guestEmail.setAttribute('required', 'required');
            guestType.setAttribute('required', 'required');
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        window.switchLanguage('en'); 
        window.toggleGuestFields();
    });
</script>
@endsection