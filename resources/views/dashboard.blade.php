@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8 text-center text-md-start">
            <h3 class="fw-bold text-dark mb-1">{{ __('messages.Welcome') }}, {{ Auth::user()->name }}!</h3>
            <div class="d-flex flex-wrap justify-content-center justify-content-md-start align-items-center gap-2">
                <span class="text-secondary small">{{ __('messages.Your Role') }}:</span>
                @foreach(Auth::user()->roles as $role)
                    <span class="badge rounded-pill bg-info text-dark px-3 shadow-sm">
                        <i class="fas fa-user-tag me-1 small"></i> {{ $role->name }}
                    </span>
                @endforeach
            </div>
        </div>
        <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
            <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> Date: {{ date('M d, Y') }}</span>
        </div>
    </div>

    
    @include('partial.dashbord')

 <div class="row g-4 mb-5">
    
    <div class="col-md-6">
        <button type="button" class="btn p-0 w-100 text-start" data-bs-toggle="modal" data-bs-target="#complaintModal" style="border: none; background: none;">
            <div class="card h-100 border-0 shadow-sm p-4 text-center card-hover">
                <i class="fas fa-exclamation-triangle text-danger fa-3x mb-3"></i>
                <h5 class="fw-bold text-dark">{{ __('messages.Submit Complain') }}</h5>
                <p class="text-muted small mb-0">{{ __('messages.select the unit and enter your details') }}</p>
            </div>
        </button>
    </div>

    
<div class="col-md-6">
    <button type="button" class="btn p-0 w-100 text-start" data-bs-toggle="modal" data-bs-target="#feedbackModal" style="border: none; background: none;">
        <div class="card h-100 border-0 shadow-sm p-4 text-center card-hover">
            <i class="fas fa-comment-dots text-success fa-3x mb-3"></i>
            <h5 class="fw-bold text-dark">{{ __('messages.Submit Feedback') }}</h5>
            <p class="text-muted small mb-0">{{ __('messages.share your thoughts about oure service') }}</p>
        </div>
    </button>
</div>


</div>


@include('partial.complaint_dashbord')
 @include('partial.feedback_dashbord') 

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    @endif
    @if(Auth::user()->hasRole('General User'))
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-header bg-white py-3"><h5 class="fw-bold mb-0">{{ __('messages.My Submissions & Responses') }}</h5></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th class="ps-4">{{ __('messages.Type') }}</th>
                            <th>{{ __('messages.Subject') }}</th>
                            <th>{{ __('messages.Status') }}</th>
                            <th>{{ __('messages.Date') }}</th>
                            <th class="text-center">{{ __('messages.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allSubmissions as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="ps-4">
                                @if($item instanceof \App\Models\Complaint)
                                    <span class="badge bg-danger-soft text-danger border border-danger">Complaint</span>
                                @else
                                    <span class="badge bg-success-soft text-success border border-success">Feedback</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($item->subject, 50) }}</td>
                            <td><span class="badge rounded-pill bg-info text-dark">{{ $item->status }}</span></td>
                                                <td>
                             <div class="small fw-bold text-dark">{{ $item->created_at->format('M d, Y') }}</div>
                              <div class="text-muted small" style="font-size: 0.75rem;"><i class="far fa-clock me-1"></i>{{ $item->created_at->format('h:i A') }}</div>
                              </td>
                          <td class="text-center">
                                  @php
                                   $route = $item instanceof \App\Models\Complaint ? route('show', $item->id) : route('feedback.show', $item->id);
                                      @endphp
                                 <a href="{{ $route }}" class="btn btn-sm btn-primary shadow-sm px-3">
                                    <i class="fas fa-eye me-1"></i> View Details
                                    </a>
                                        </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-5 text-muted">No records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
   


window.translations = {
    'am': {
        //for Complaint
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
        'label-recipient-id': 'ይምረጡ:',
        'option-select-recipient': 'ክፍል ይምረጡ',
        'label-subject': 'ርዕስ:',
        'label-description': 'የአቤቱታ ዝርዝር',
        'title-cont': ' ዝርዝር',
        'label-body-text': 'ዝርዝር መግለጫ:',
        'label-anonymous': 'ስም-አልባ መሆን እፈልጋለሁ።',
        'text-anonymous-warning': 'ማንነትዎ ይደበቃል፣ ነገር ግን ምላሽ ላይደርስዎት ይችላል።',
        'title-contact': 'ማንነትና እውቂያ',
        'label-email': 'ኢሜይል:',
        'label-name': 'ሙሉ ስም (አማራጭ):',
        'label-type': 'የአመልካች አይነት:',
        'opt-select-type': 'ይምረጡ',
        'label-submit-guest': 'እንደ እንግዳ አስገባ',
        'opt-student': 'ተማሪ',
        'opt-Employee': 'ሰራተኛ',
        'opt-Guest': 'እግዳ',
        'button-submit': 'ቅሬታ አስገባ',
        
        //for Feedback
        'fb-main-title': 'አስተያየት ማስገቢያ',
        'fb-subtitle': 'እባክዎን የሚመለከተውን ክፍል በመምረጥ አስተያየትዎን ያስገቡ።',
        'fb-title-recipient-info': 'መረጃ መቀበያ አካል',
        'fb-label-recipient-type': 'የመቀበያ አይነት:',
        'fb-option-select-recipient-type': 'አይነት ይምረጡ',
        'fb-option-college': 'ኮሌጅ',
        'fb-option-department': 'ዲፓርትመንት',
        'fb-option-directory': 'ዳይሬክቶሬት',
        'fb-label-filter-college': 'ቅድሚያ ኮሌጅ ይምረጡ:',
        'fb-label-recipient-id': 'ክፍሉን ይምረጡ:',
        'fb-option-select-recipient': 'ክፍል ይምረጡ',
        'fb-title-feedback-details': 'የአስተያየቱ ይዘት',
        'fb-label-feedback-type': 'የአስተያየቱ ባህሪ ',
        'fb-opt-neutral': 'ገለልተኛ',
        'fb-opt-positive': 'አዎንታዊ',
        'fb-opt-negative': 'አሉታዊ',
        'fb-label-subject': 'ርዕስ:',
        'fb-label-description': 'መግለጫ:',
        'fb-label-anonymous': 'የማንነት አማራጮች',
        'fb-label-anon-text': 'ስም-አልባ መሆን እፈልጋለሁ።',
        'fb-text-anonymous-warning': 'ማንነትዎ ይደበቃል፣ ነገር ግን ምላሽ ላይደርስዎት ይችላል።',
        'fb-title-contact': 'የእውቂያ መረጃ',
        'fb-label-email': 'ኢሜይል:',
        'fb-label-name': 'ሙሉ ስም:',
        'fb-label-type': 'የአስተያየት ሰጪው አይነት:',
        'fb-option-select-type': 'ይምረጡ',
        'fb-label-submit-guest': 'እንደ እንግዳ አስገባ',
        'fb-opt-student': 'ተማሪ',
        'fb-opt-employee': 'ሰራተኛ',
        'fb-opt-guest': 'እግዳ',
        'fb-button-submit': 'አስተያየት አስገባ'

    },
    'en': {
        // Complaint
        'main-title': 'Complaint Submission',
        'subtitle': 'Please select the relevant unit and enter your complaint details.',
        'title-recipient-info': 'Recipient Information',
        'label-recipient-type': 'Recipient Type:',
        'option-select-recipient-type': 'Select Type',
        'option-college': 'College',
        'option-department': 'Department',
        'option-directory': 'Directorate',
        'label-filter-college': 'Select College first:',
        'option-select-filter-college': 'Choose College',
        'label-recipient-id': 'Recipient Unit:',
        'option-select-recipient': 'Select Recipient Unit',
        'label-subject': 'Subject:',
        'label-description': 'Complaint Content',
        'label-body-text': 'Detailed Description:',
        'title-cont': 'Identity & Contact:',
        'label-anonymous': 'I wish to remain Anonymous.',
        'text-anonymous-warning': 'Hides identity, but may limit responses.',
        'title-contact': 'Contact Information',
        'label-email': 'Email:',
        'label-name': 'Full Name (Optional):',
        'label-type': 'Reporter Type:',
        'opt-select-type': 'Select Type',
        'label-submit-guest': 'Submit as guest',
        'option-select-type': '',
        'opt-student': 'Student',
        'opt-employee': 'Employee',
        'opt-guest': 'Guest',
        'button-submit': 'Submit Complaint',


        //Feedback 
        'fb-main-title': 'Feedback Submission',
        'fb-subtitle': 'Please select the relevant unit and enter details.',
        'fb-title-recipient-info': 'Recipient Information',
        'fb-label-recipient-type': 'Type ',
        'fb-option-select-recipient-type': 'Select Type',
        'fb-option-college': 'College',
        'fb-option-department': 'Department',
        'fb-option-directory': 'Directorate',
        'fb-label-filter-college': 'College ',
        'fb-label-recipient-id': 'Select Recipient Unit ',
        'fb-option-select-recipient': 'Select Recipient',
        'fb-title-feedback-details': 'Feedback Content',
        'fb-label-feedback-type': 'Feedback Nature ',
        'fb-opt-neutral': 'Neutral',
        'fb-opt-positive': 'Positive',
        'fb-opt-negative': 'Negative',
        'fb-label-subject': 'Subject ',
        'fb-label-description': 'Description ',
        'fb-label-anonymous': 'Identity Options',
        'fb-label-anon-text': 'Remain Anonymous',
        'fb-text-anonymous-warning': 'Hides identity, but may limit responses.',
        'fb-title-contact': 'Contact Information',
        'fb-label-email': 'Email ',
        'fb-label-name': 'Full Name',
        'fb-label-type': 'Reporter Type ',
        'fb-option-select-type': 'Select Type',
        'fb-label-submit-guest': 'Submit as guest',
        'fb-opt-student': 'student',
        'fb-opt-employee': 'Employee',
        'fb-opt-guest': 'Guest',
        'fb-button-submit': 'Submit Feedback'
    }
};


    let currentLangs = { 'complaint': 'en', 'fb': 'en' };

    // for languge
    window.switchLanguage = (lang, prefix = '') => {
        const type = prefix === 'fb' ? 'fb' : 'complaint';
        currentLangs[type] = lang;
        const t = window.translations[lang];
        for (let key in t) {
            const el = document.getElementById(key);
            if (el) el.textContent = t[key];
        }
        window.handleTypeChange(prefix);
    };

    //for Recipient Type(College/Dept/Dir)
    window.handleTypeChange = async (prefix = '') => {
        const pfx = prefix ? prefix + '_' : '';
        const lang = prefix === 'fb' ? currentLangs['fb'] : currentLangs['complaint'];
        
        const type = document.getElementById(pfx + 'recipient_type').value;
        const collegeFilter = document.getElementById(pfx + 'college_filter_container');
        const idSelect = document.getElementById(pfx + 'recipient_id');

        //idSelect.innerHTML = `<option value="">Loading...</option>`;
        collegeFilter.classList.add('d-none');

        if (type === 'College') {
            await window.fetchAndFill('{{ route("api.colleges.list") }}', idSelect, lang);
        } else if (type === 'Directory') {
            await window.fetchAndFill('{{ route("api.directories.list") }}', idSelect, lang);
        } else if (type === 'Department') {
            collegeFilter.classList.remove('d-none');
            await window.fillColleges(pfx, lang);
        }
    };

    // for college
    window.fillColleges = async (pfx, lang) => {
        const filterSelect = document.getElementById(pfx + 'filter_college_id');
        const response = await fetch('{{ route("api.colleges.list") }}');
        const data = await response.json();
        //filterSelect.innerHTML = `<option value="">Select College</option>`;
        data.forEach(c => {
            filterSelect.innerHTML += `<option value="${c.id}">${lang === 'am' ? (c.name_am || c.name_en) : c.name_en}</option>`;
        });
    };

    //for departemnt load by college
    window.loadDepartmentsByCollege = async (collegeId, prefix = '') => {
        if (!collegeId) return;
        const pfx = prefix ? prefix + '_' : '';
        const lang = prefix === 'fb' ? currentLangs['fb'] : currentLangs['complaint'];
        const idSelect = document.getElementById(pfx + 'recipient_id');
        await window.fetchAndFill(`{{ url('/api/colleges') }}/${collegeId}/departments`, idSelect, lang);
    };

    // Generic Fetch function
    window.fetchAndFill = async (url, selectEl, lang) => {
        try {
            const response = await fetch(url);
            const data = await response.json();
            //selectEl.innerHTML = `<option value="">Select Unit</option>`;
            data.forEach(item => {
                selectEl.innerHTML += `<option value="${item.id}">${lang === 'am' ? (item.name_am || item.name_en) : item.name_en}</option>`;
            });
        } catch (e) { selectEl.innerHTML = `<option value="">Error</option>`; }
    };

    // for guest & ANONYMOUS 
    window.handleIdentityChange = (prefix = '') => {
        const pfx = prefix ? prefix + '_' : '';
        const isAnon = document.getElementById(pfx + 'is_anonymous').checked;
        const guestCheck = document.getElementById(pfx + 'use_guest_mode');
        const guestFields = document.getElementById(pfx + 'guest_fields');

        if (isAnon) {
            guestFields.classList.add('d-none');
            if(guestCheck) guestCheck.parentElement.classList.add('d-none');
        } else {
            if(guestCheck) guestCheck.parentElement.classList.remove('d-none');
            
            if (guestCheck && guestCheck.checked) {
                guestFields.classList.remove('d-none');
            } else {
                guestFields.classList.add('d-none');
            }
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        window.switchLanguage('en');
        window.switchLanguage('en', 'fb');
    });


</script>

<style>
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.08); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.08); }
    .card-hover:hover { transform: translateY(-5px); transition: all 0.3s ease; box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>
@endsection