@extends('layouts.wel')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg p-5 border-0 rounded-4">
        <h2 class="text-primary fw-bold mb-4"><i class="fas fa-info-circle me-2"></i> System Information | ስለ ሲስተሙ መረጃ</h2>
        <hr>
        
        <div class="mb-5">
            <p class="lead fw-bold text-dark">
                This Feedback and Complaint Management System is designed to ensure transparency and accountability within Injibara University's service delivery.
            </p>
            <p class="lead text-muted">
                ይህ የቅሬታ እና ግብረ-መልስ ማስተዳደሪያ ሲስተም በእንጅባራ ዩኒቨርሲቲ የአገልግሎት አሰጣጥ ላይ ግልጽነትን እና ተጠያቂነትን ለማስፈን ታስቦ የተዘጋጀ ነው።
            </p>
        </div>

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

<div class="section-card">
    <p class="section-title">Anonymous Complaint And Feedback Submission</p>
    <p class="mb-0">
        To submit your feedback or complaint without revealing your identity, you can choose the Anonymous option provided in this form.
    </p>
</div>


        <h5 class="fw-bold text-primary mb-3">Key Objectives | ዋና ዓላማዎች፦</h5>
        <ul class="list-group list-group-flush">
            <li class="list-group-item border-0 ps-0">
                <i class="fas fa-check-circle text-success me-2"></i>
                <strong>To submit complaints from anywhere:</strong> ቅሬታዎችን ባሉበት ሆነው ለማቅረብ እንዲቻል
            </li>
            <li class="list-group-item border-0 ps-0">
                <i class="fas fa-check-circle text-success me-2"></i>
                <strong>To improve service quality via feedback:</strong> የአገልግሎት ጥራትን በግብረ-መልስ ለማሻሻል
            </li>
            <li class="list-group-item border-0 ps-0">
                <i class="fas fa-check-circle text-success me-2"></i>
                <strong>To ensure timely responses:</strong> ለቅሬታዎች ፈጣን እና ተገቢ ምላሽ ለመስጠት
            </li>
        </ul>

        <div class="mt-5 p-4 bg-light rounded-3 border">
            <h6 class="fw-bold text-dark mb-3"><i class="fas fa-users-cog me-2"></i> Development Team | የልማት ቡድን</h6>
            <div class="row small">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Developers:</strong> IU Computer Science Students</p>
                    <p class="mb-1"><strong>አልሚዎች፦</strong> የኮምፒውተር ሳይንስ ተማሪዎች</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Adviser:</strong> Mr. Andualem Muche</p>
                    <p class="mb-1"><strong>አማካሪ፦</strong> መምህር አንዱዓለም ሙጬ</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection