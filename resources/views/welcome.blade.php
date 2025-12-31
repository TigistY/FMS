
@extends('layouts.wel')
@section('content')

    <div class="container mt-4 mx-2">

        <h2 class="mb-3">Welcome to the Feedback and Complaint System</h2>
        <p class="mb-4">
            This system is designed to provide students, staff, and the community with a structured way to submit feedback, suggestions, or formal complaints regarding university services, staff, or facilities. Your input is vital for continuous improvement.
        </p>

        <h3 class="mb-3" style="border-bottom: 2px solid #ddd; padding-bottom: 5px;">Submit Your Input</h3>
        
        <div class="section-card" onclick="window.location.href='feedback_form.html'">
            <p class="section-title">General Feedback & Suggestions</p>
            <p class="mb-0">
                Use this option to share positive feedback, suggestions for improvement, or ideas related to general university operations and processes.
            </p>
        </div>

        <div class="section-card" onclick="window.location.href='complaint_form.html'">
            <p class="section-title">Formal Complaint Submission</p>
            <p class="mb-0">
                Submit a formal complaint regarding misconduct, service failures, or specific issues with staff or facilities. This process ensures formal review and resolution.
            </p>
        </div>

        <div class="section-card" onclick="window.location.href='anonymous_form.html'">
            <p class="section-title">Anonymous Reporting</p>
            <p class="mb-0">
                Report sensitive issues anonymously. While follow-up is limited, this channel provides a safe space for confidential disclosures.
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
                     How do I track the status of my complaint? | የቅሬታዬን ደረጃ እንዴት መከታተል እችላለሁ?
                </button>
            </h2>
            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body bg-white text-muted">
                    After submitting a formal complaint, you will receive a reference number. You can use this number to check the progress through the "Track Status" menu. <br>
                    <span class="small text-primary">ቅሬታዎን ካስገቡ በኋላ የመለያ ቁጥር ይሰጥዎታል። ይህንን ቁጥር በመጠቀም "Track Status" በሚለው ሜኑ ውስጥ ሂደቱን መከታተል ይችላሉ።</span>
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
                <img src="{{ asset('image/f2.jpg') }}" class="rounded img-fluid" alt="Main Campus">
                <div class="overlay">Campus View</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/f1.jpg') }}" class="rounded img-fluid" alt="ICT Center">
                <div class="overlay">ICT Center</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/f3.jpg') }}" class="rounded img-fluid" alt="Students Area">
                <div class="overlay">Students Area</div>
            </div>
        </div>
    </div><br><br>
     <div class="row g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/f2.jpg') }}" class="rounded img-fluid" alt="Main Campus">
                <div class="overlay">Campus View</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/f1.jpg') }}" class="rounded img-fluid" alt="ICT Center">
                <div class="overlay">ICT Center</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm gallery-card">
                <img src="{{ asset('image/f3.jpg') }}" class="rounded img-fluid" alt="Students Area">
                <div class="overlay">Students Area</div>
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
