@extends('layouts.wel')

@section('content')
<div class="container mt-5 mx-auto px-3" style="max-width: 1100px;">

    
    <div class="section-card shadow-lg p-5 border-0 rounded-4 mb-5 text-white" 
         style="background: linear-gradient(135deg, #004d40 0%, #0d6efd 100%);">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold mb-3">Welcome to INU-FMS</h1>
                <h3 class="fw-light mb-4">Injibara University Feedback & Complaint Management System</h3>
                <p class="lead mb-4">
                    Your voice matters! Use this platform to help us improve our university services by sharing your honest feedback or reporting concerns.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('create') }}" class="btn btn-warning btn-lg fw-bold px-4">
                        <i class="fas fa-plus-circle me-2"></i>  ቅሬታ አቅርብ
                    </a>
                    <a href="{{ route('feedback.link') }}" class="btn btn-outline-light btn-lg px-4">
                        <i class="fas fa-bullhorn me-2"></i> አስተያየት ስጥ
                    </a>
                </div>
            </div>
            <div class="col-md-4 d-none d-md-block text-center">
                <i class="fas fa-hands-helping fa-8x opacity-50"></i>
            </div>
        </div>
    </div>

    
    <div class="row g-4 mb-5 text-center">
        <h3 class="fw-bold mb-4">How to Use the System | ሲስተሙን እንዴት ይጠቀማሉ?</h3>
        
        <div class="col-md-4">
            <div class="p-4 bg-white shadow-sm rounded-4 h-100 border-top border-primary border-4">
                <div class="icon-box mb-3 text-primary">
                    <i class="fas fa-edit fa-3x"></i>
                </div>
                <h5 class="fw-bold">Submit | ማስገባት</h5>
                <p class="text-muted small">Choose between Feedback or Complaint and fill out the form.</p>
                <p class="small text-secondary">ቅሬታ ወይም አስተያየት የሚለውን መርጠው ፎርሙን ይሙሉ::</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-4 bg-white shadow-sm rounded-4 h-100 border-top border-success border-4">
                <div class="icon-box mb-3 text-success">
                    <i class="fas fa-tasks fa-3x"></i>
                </div>
                <h5 class="fw-bold"> Process | ማቀነባበር</h5>
                <p class="text-muted small">The relevant department will review your submission.</p>
                <p class="small text-secondary">የሚመለከተው የሥራ ክፍል ጉዳዩን ይመረምራል::</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-4 bg-white shadow-sm rounded-4 h-100 border-top border-warning border-4">
                <div class="icon-box mb-3 text-warning">
                    <i class="fas fa-check-double fa-3x"></i>
                </div>
                <h5 class="fw-bold">Resolution | ምላሽ</h5>
                <p class="text-muted small">Receive updates and final resolution on your issue.</p>
                <p class="small text-secondary">ለጥያቄዎ ተገቢውን ምላሽ እና መፍትሄ ያገኛሉ::</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-4 bg-white shadow-sm rounded-4 h-100 border-top border-danger border-4">
                <div class="icon-box mb-3 text-danger">
                    <i class="fas fa-user-secret fa-3x"></i>
                </div>
                <h5 class="fw-bold">4. Anonymous Option | በምስጢር መላክ</h5>
                <p class="text-muted small">You can choose to remain anonymous if you don't want your identity to be known.</p>
                <p class="small text-secondary font-ethiopia">ማንነትዎ እንዳይታወቅ ከፈለጉ በምስጢር (Anonymous) መላክ ይችላሉ። በዚህ ጊዜ ስምዎ ለማንም አይታይም።</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-4 bg-white shadow-sm rounded-4 h-100 border-top border-info border-4">
                <div class="icon-box mb-3 text-info">
                    <i class="fas fa-user-check fa-3x"></i>
                </div>
                <h5 class="fw-bold">5. Provide Info for Response | ምላሽ ለማግኘት</h5>
                <p class="text-muted small">Provide your contact info if you want to receive direct feedback and follow your case.</p>
                <p class="small text-secondary font-ethiopia">ምላሽ እንዲደርስዎ እና የጉዳዩን ሂደት ለመከታተል ከፈለጉ የግል መረጃዎን (ኢሜይል) መሙላት ይችላሉ።</p>
            </div>
        </div>
    </div>

    {{-- FAQ and Gallery sections can follow here --}}
</div>

<style>
    /* Hero Section Animation */
    .section-card {
        transition: transform 0.4s ease;
    }
    .section-card:hover {
        transform: scale(1.01);
    }
    
    .icon-box {
        transition: transform 0.3s ease;
    }
    .col-md-4:hover .icon-box {
        transform: rotateY(180deg);
    }
</style>
@endsection