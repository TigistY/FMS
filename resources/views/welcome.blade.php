
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

        <div style="height: 150px;"></div>
    </div>
@endsection
