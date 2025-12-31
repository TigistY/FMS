@extends('layouts.wel')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg p-5 border-0 rounded-4">
        <h2 class="text-danger fw-bold mb-4"><i class="fas fa-user-shield me-2"></i> Privacy Policy | የምስጢራዊነት መመሪያ</h2>
        <hr>

        <div class="row g-4">
            <div class="col-12 mb-3">
                <h5 class="fw-bold text-dark">1. Anonymity | ማንነትን አለመግለጽ</h5>
                <p class="text-muted mb-1"><strong>If you choose "Anonymous", your identity will remain strictly confidential.</strong></p>
                <p class="text-muted small">"Anonymous" የሚለውን ምርጫ ከተጠቀሙ ማንነትዎ ለማንም አካል አይገለጽም፤ መረጃውም በምስጢር ይያዛል።</p>
            </div>

            <div class="col-12 mb-3">
                <h5 class="fw-bold text-dark">2. Data Security | የመረጃ ደህንነት</h5>
                <p class="text-muted mb-1"><strong>Your data is safely stored and protected within the University Data Center.</strong></p>
                <p class="text-muted small">መረጃዎ በዩኒቨርሲቲው ዳታ ማዕከል ውስጥ በጥንቃቄ የተቀመጠ ሲሆን ከፍተኛ ጥበቃ ይደረግለታል።</p>
            </div>

            <div class="col-12 mb-3">
                <h5 class="fw-bold text-dark">3. Information Usage | የመረጃ አጠቃቀም</h5>
                <p class="text-muted mb-1"><strong>Collected information is used only for service improvement and problem solving.</strong></p>
                <p class="text-muted small">የሚሰበሰበው መረጃ አገልግሎቶችን ለማሻሻል እና ችግሮችን ለመፍታት ብቻ ጥቅም ላይ ይውላል።</p>
            </div>
        </div>

        <div class="alert alert-info border-0 shadow-sm mt-4 text-center">
            <i class="fas fa-envelope-open-text me-2"></i> 
            For any questions / ለማንኛውም ጥያቄ: <strong>FMS@inu.edu.et</strong>
        </div>
    </div>
</div>
@endsection