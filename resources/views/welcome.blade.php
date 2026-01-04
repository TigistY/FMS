
@extends('layouts.wel')
@section('content')

    <div class="container mt-4 mx-2">

        <h2 class="mb-3">Welcome to the Feedback and Complaint System</h2>
        <p class="mb-4">
            This system is designed to provide students, staff, and the community with a structured way to submit feedback, suggestions, or formal complaints regarding university services, staff, or facilities. Your input is vital for continuous improvement.
        </p>

        <h3 class="mb-3" style="border-bottom: 2px solid #ddd; padding-bottom: 5px;">Submit Your Input</h3>
    <div class="section-card" onclick="window.location.href='{{ route('feedback.link') }}'">
    <p class="section-title">General Feedback & Suggestions</p>
    <p class="mb-0">
        Share your thoughts, appreciation, or suggestions to help us improve our services. Use this for non-urgent ideas related to university operations.
    </p>
</div>

<div class="section-card" onclick="window.location.href='{{ route('create') }}'">
    <p class="section-title">Formal Complaint Submission</p>
    <p class="mb-0">
        Submit a formal complaint regarding service failures, misconduct, or facility issues. This track ensures your case is officially reviewed and resolved.
    </p>
</div>

<div class="section-card" onclick="window.location.href='{{ route('create', ['anonymous' => true]) }}'">
    <p class="section-title">Anonymous Complaint Reporting</p>
    <p class="mb-0">
        Report sensitive issues or misconduct without revealing your identity. Ideal for whistleblowing or sensitive matters where privacy is your priority.
    </p>
</div>

<div class="section-card" onclick="window.location.href='{{ route('feedback.link', ['anonymous' => true]) }}'">
    <p class="section-title">Anonymous Feedback Submission</p>
    <p class="mb-0">
        Provide honest feedback or suggestions anonymously. Your input helps us improve while ensuring your personal information remains completely private.
    </p>
</div>
<div class="mt-5 pt-4">
    <h3 class="mb-4 fw-bold text-dark border-bottom pb-2">
        <i class="fas fa-question-circle text-primary me-2"></i>Frequently Asked Questions (FAQ)
    </h3>
    
    <div class="accordion accordion-flush" id="faqAccordion">
        
        <div class="accordion-item faq-hover-card mb-3 shadow-sm border rounded-3 overflow-hidden">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
            How will I receive a response to my submission? | ለላክሁት ጉዳይ እንዴት ምላሽ ይደርሰኛል?
        </button>
    </h2>
    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body bg-white text-muted">
            Once a response is provided by the university, you will receive an automatic notification via the email address you provided. Registered users can also check status updates by logging into their dashboard. <br>
            <span class="small text-primary">ዩኒቨርሲቲው ምላሽ ሲሰጥዎት ባስገቡት የኢሜይል አድራሻ አማካኝነት አውቶማቲክ ማሳወቂያ ይደርስዎታል። አካውንት ያላቸው ተጠቃሚዎች ደግሞ ሲስተሙ ውስጥ በመግባት የደረሰበትን ደረጃ ማየት ይችላሉ።</span>
        </div>
    </div>
</div>

        <div class="accordion-item faq-hover-card mb-3 shadow-sm border rounded-3 overflow-hidden">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                    Is my personal information safe? | የግል መረጃዬ ደህንነቱ የተጠበቀ ነው?
                </button>
            </h2>
            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body bg-white text-muted">
                    Absolutely. The system uses high-level encryption to protect your data. Only authorized personnel from the university can view relevant information. <br>
                    <span class="small text-primary">በፍፁም፤ ሲስተሙ መረጃዎን ለመጠበቅ ከፍተኛ የደህንነት ቴክኖሎጂን ይጠቀማል። መረጃዎን የማየት ስልጣን ያላቸው የዩኒቨርሲቲው የስራ ኃላፊዎች ብቻ ናቸው።</span>
                </div>
            </div>
        </div>

        <div class="accordion-item faq-hover-card mb-3 shadow-sm border rounded-3 overflow-hidden">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                    Can I edit a complaint after submission? | ቅሬታ ከላክኩ በኋላ ማስተካከል እችላለሁ?
                </button>
            </h2>
            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body bg-white text-muted">
                    No, once a complaint is submitted, it cannot be edited. However, you can add more information or comments if the administrator requests a clarification. <br>
                    <span class="small text-primary">አይቻልም፤ አንድ ጊዜ የተላከ ቅሬታን ማስተካከል አይቻልም። ነገር ግን አስተዳዳሪው ተጨማሪ ማብራሪያ ከጠየቀዎት መረጃ መጨመር ይችላሉ።</span>
                </div>
            </div>
        </div>

        <div class="accordion-item faq-hover-card mb-3 shadow-sm border rounded-3 overflow-hidden">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                    What is the difference between Feedback and Complaint? | በግብረ-መልስ እና በቅሬታ መካከል ያለው ልዩነት ምንድነው?
                </button>
            </h2>
            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body bg-white text-muted">
                    Feedback is for general suggestions and improvements, while a Complaint is for reporting specific misconduct or service failures that require formal action. <br>
                    <span class="small text-primary">ግብረ-መልስ ለአጠቃላይ አስተያየቶች እና ማሻሻያዎች ሲሆን፤ ቅሬታ ግን መደበኛ እርምጃ ለሚያስፈልጋቸው የአገልግሎት ጉድለቶች ወይም የጥፋት ሪፖርቶች ነው።</span>
                </div>
            </div>
        </div>

        <div class="accordion-item faq-hover-card mb-3 shadow-sm border rounded-3 overflow-hidden">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                     Can I report issues related to specific facilities? | ስለ ተወሰኑ ግቢ ውስጥ ስላሉ አገልግሎቶች ሪፖርት ማድረግ እችላለሁ?
                </button>
            </h2>
            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body bg-white text-muted">
                    Yes, you can report issues related to dormitories, cafes, libraries, classrooms, or any other university facility. <br>
                    <span class="small text-primary">አዎ፤ ስለ መኝታ ክፍሎች፣ ካፌዎች፣ ቤተ-መጽሐፍት፣ የመማሪያ ክፍሎች ወይም ስለ ማንኛውም የዩኒቨርሲቲው አገልግሎት ሪፖርት ማድረግ ይችላሉ።</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-5 mb-5">
    <h3 class="mb-4 fw-bold text-dark border-bottom pb-2">
        <i class="fas fa-images text-primary me-2"></i>University Gallery
    </h3>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/inu10.jfif') }}" class="rounded img-fluid" alt="Main Campus">
                <div class="overlay">Campus View</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/inu3.jfif') }}" class="rounded img-fluid" alt="ICT Center">
                <div class="overlay">Campus View</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/inu13.jfif') }}" class="rounded img-fluid" alt="Students Area">
                <div class="overlay">Administration Office</div>
            </div>
        </div>
    </div><br>
     <div class="row g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/inu18.jfif') }}" class="rounded img-fluid" alt="Main Campus">
                <div class="overlay">Presdent</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/inu2.jfif') }}" class="rounded img-fluid" alt="ICT Center">
                <div class="overlay">Prospective Graduates</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/inu1.jfif') }}" class="rounded img-fluid" alt="Students Area">
                <div class="overlay">campus view</div>
            </div>
        </div>
    </div><br>
     <div class="row g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/inu17.jfif') }}" class="rounded img-fluid" alt="Main Campus">
                <div class="overlay">Vice President</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/inu4.jfif') }}" class="rounded img-fluid" alt="ICT Center">
                <div class="overlay">Campus view</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/inu12.jfif') }}" class="rounded img-fluid" alt="Students Area">
                <div class="overlay">Plaza</div>
            </div>
        </div>
    </div><br>
     <div class="row g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/inu8.jfif') }}" class="rounded img-fluid" alt="Main Campus">
                <div class="overlay">Caffe View</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/inu20.jfif') }}" class="rounded img-fluid" alt="ICT Center">
                <div class="overlay">Campus view</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/inu14.jfif') }}" class="rounded img-fluid" alt="Students Area">
                <div class="overlay">campus view</div>
            </div>
        </div>
    </div>
</div>

<style>
    /* FAQ Hover and Animation Styling */
    .faq-hover-card {
        transition: all 0.3s ease;
        border-left: 5px solid #0d6efd !important; /* Blue border like section cards */
    }

    .faq-hover-card:hover {
        transform: translateY(-5px); /* Hover effect: Lift up */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12) !important;
    }

    /* Adjusting Accordion Plus/Minus Icon */
    .accordion-button:not(.collapsed) {
        background-color: #f8f9fa !important;
        color: #0d6efd !important;
        box-shadow: none;
    }

    /* Image Gallery Hover Effect */
    .gallery-card {
        position: relative;
        overflow: hidden;
        cursor: pointer;
        border-radius: 12px;
    }
    .gallery-card img {
        transition: transform 0.5s ease;
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .gallery-card:hover img {
        transform: scale(1.1);
    }
    .gallery-card .overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 77, 64, 0.8);
        color: white;
        padding: 8px;
        text-align: center;
        font-size: 0.85rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .gallery-card:hover .overlay {
        opacity: 1;
    }
</style>
        <div style="height: 150px;"></div>
    </div>
@endsection
