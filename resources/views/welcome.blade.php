
@extends('layouts.wel')
@section('content')

    <div class="container mt-4 mx-2">
<div class="row align-items-center">
        <div class="col-md-7 pe-md-5">
            <h2 class="display-6 fw-bold text-dark mb-3">Welcome to the Feedback and Complain Management System</h2>
            <p class="lead text-muted mb-4" style="font-size: 1.1rem;">
                This system is designed to provide students, staff, and the community with a structured way to submit feedback or formal complaints. Your input is vital for continuous improvement.
            </p>
            <div class="d-flex gap-2 mb-4">
                <a href="#input-sections" class="btn btn-primary px-4 py-2">Get Started</a>
                <a href="{{ route('aboutinfo') }}" class="btn btn-outline-secondary px-4 py-2">Learn More</a>
            </div>
        </div>

        <div class="col-md-5 mt-4 mt-md-0">
            <div class="university-hero-img shadow-lg rounded-4 overflow-hidden border border-5 border-white">
                <img src="{{ asset('image/inu50.jfif') }}" class="img-fluid" alt="Injibara University" style="width: 100%; height: 350px; object-fit: cover;">
            </div>
        </div>
    </div>

    <div id="input-sections" class="mt-5 pt-4">
        <h3 class="mb-4 border-bottom pb-2 fw-bold text-secondary">Submit Your Input</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="section-card h-100" onclick="window.location.href='{{ route('feedback.link') }}'">
                    <p class="section-title"><i class="fas fa-bullhorn me-2 text-primary"></i> General Feedback</p>
                    <p class="text-muted small">Share your thoughts or suggestions to help us improve.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="section-card h-100" onclick="window.location.href='{{ route('create') }}'">
                    <p class="section-title"><i class="fas fa-balance-scale me-2 text-danger"></i> Formal Complaint</p>
                    <p class="text-muted small">Submit formal complains regarding service failures or misconduct.</p>
                </div>
            </div>
            </div>
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
                <img src="{{ asset('image/inu1.jfif') }}" class="rounded img-fluid" alt="Students Area">
                <div class="overlay">campus view</div>
            </div>
        </div>
</div>

<style>
    /* for image */
    .university-hero-img {
        transition: transform 0.4s ease;
    }
    .university-hero-img:hover {
        transform: scale(1.02);
    }

    @media (max-width: 768px) {
        .display-6 { font-size: 1.8rem; }
        .col-md-7 { text-align: center; }
        .d-flex.gap-2 { justify-content: center; }
    }
    /* FAQ Hover and Animation Styling */
    .faq-hover-card {
        transition: all 0.3s ease;
        border-left: 5px solid #0d6efd !important; 
    }

    .faq-hover-card:hover {
        transform: translateY(-5px); /* Hover effect: Lift up */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12) !important;
    }

   
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
