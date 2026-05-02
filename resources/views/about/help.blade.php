@extends('layouts.wel')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Help Center | የእርዳታ ማዕከል</h2>
        <p class="text-muted">If you have any technical issues or questions, please contact the system developers.</p>
    </div>

    <div class="row g-4">
    {{-- Developer Card 1 --}}
    <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 text-center p-3 developer-card">
            <div class="mb-3 image-container">
                <img src="{{ asset('image/tg.jpg') }}" alt="Tigist Yeshambel" class="rounded-circle img-fluid shadow-sm developer-image">
            </div>
            <h6 class="fw-bold mb-1">Tigist Yeshambel</h6>
            <p class="small text-muted mb-3">Backend Developer</p>
            <div class="border-top pt-2">
                <p class="small mb-1"><i class="fas fa-phone text-success me-2"></i> +251 930 988 811</p>
                <p class="small mb-0 text-truncate"><i class="fas fa-envelope text-danger me-2"></i>TtY@gmail.com</p>
            </div>
        </div>
    </div>

    {{--  Card 2 --}}
    <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 text-center p-3 developer-card">
            <div class="mb-3 image-container">
                <img src="{{ asset('image/ale2.jpg') }}" alt="Alemnhe" class="rounded-circle img-fluid shadow-sm developer-image">
            </div>
            <h6 class="fw-bold mb-1">Alemnhe</h6>
            <p class="small text-muted mb-3">Frontend Developer</p>
            <div class="border-top pt-2">
                <p class="small mb-1"><i class="fas fa-phone text-success me-2"></i> +251 934 355 501</p>
                <p class="small mb-0 text-truncate"><i class="fas fa-envelope text-danger me-2"></i> Alem@gmail.com</p>
            </div>
        </div>
    </div>

    {{--  Card 3 --}}
    <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 text-center p-3 developer-card">
            <div class="mb-3 image-container">
                <img src="{{ asset('image/kasu.jpg') }}" alt="Kasaye Tarekgne" class="rounded-circle img-fluid shadow-sm developer-image">
            </div>
            <h6 class="fw-bold mb-1">Kasaye Tarekgne</h6>
            <p class="small text-muted mb-3">Database Designer</p>
            <div class="border-top pt-2">
                <p class="small mb-1"><i class="fas fa-phone text-success me-2"></i> +251 976 231 703</p>
                <p class="small mb-0 text-truncate"><i class="fas fa-envelope text-danger me-2"></i> Kasech@gmail.com</p>
            </div>
        </div>
    </div>

    {{--  Card 4 --}}
    <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 text-center p-3 developer-card">
            <div class="mb-3 image-container">
                <img src="{{ asset('image/abrh.jpg') }}" alt="Abreham Alemu" class="rounded-circle img-fluid shadow-sm developer-image">
            </div>
            <h6 class="fw-bold mb-1">Abreham Alemu</h6>
            <p class="small text-muted mb-3">UI/UX Designer</p>
            <div class="border-top pt-2">
                <p class="small mb-1"><i class="fas fa-phone text-success me-2"></i> +251 918 250 919</p>
                <p class="small mb-0 text-truncate"><i class="fas fa-envelope text-danger me-2"></i> Abrsh@gmail.com</p>
            </div>
        </div>
    </div>
</div>

    {{-- ICT Support Section --}}
    <div class="mt-5 p-4 bg-white rounded shadow-sm border-start border-warning border-5 text-center">
        <h5 class="fw-bold">University ICT Support</h5>
        <p class="mb-1">For official university issues, contact the ICT Directorate.</p>
        <p class="fw-bold text-primary mb-0"><i class="fas fa-envelope me-2"></i> FMS@inu.edu.et</p>
    </div>
</div>
<style>
    .image-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding-top: 10px;
    }

    .developer-image {
        width: 140px;  
        height: 180px; 
        object-fit: cover;
        border: 4px solid #ffffff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
        transition: transform 0.3s ease;
    }

    .developer-card:hover .developer-image {
        transform: scale(1.05);
        border-color: #0d6efd; 
    }

    .developer-card {
        transition: all 0.3s ease;
        border-radius: 15px; 
    }

/*
<div class="row g-4">
        {{-- Developer Card 1 --}}
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0 text-center p-3">
                <div class="mb-3">
                    <i class="fas fa-user-circle fa-4x text-primary"></i>
                </div>
                <h6 class="fw-bold mb-1">Tigist Yeshambel</h6>
                <p class="small text-muted mb-3">Backend Developer</p>
                <div class="border-top pt-2">
                    <p class="small mb-1"><i class="fas fa-phone text-success me-2"></i> +251 930 988 811</p>
                    <p class="small mb-0 text-truncate"><i class="fas fa-envelope text-danger me-2"></i>TtY@gmail.com</p>
                </div>
            </div>
        </div>

        {{-- Developer Card 2 --}}
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0 text-center p-3">
                <div class="mb-3">
                    <i class="fas fa-user-circle fa-4x text-primary"></i>
                </div>
                <h6 class="fw-bold mb-1">Alemnhe</h6>
                <p class="small text-muted mb-3">Frontend Developer</p>
                <div class="border-top pt-2">
                    <p class="small mb-1"><i class="fas fa-phone text-success me-2"></i> +251 934 355 501</p>
                    <p class="small mb-0 text-truncate"><i class="fas fa-envelope text-danger me-2"></i> Alem@gmail.com</p>
                </div>
            </div>
        </div>

        {{-- Developer Card 3 --}}
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0 text-center p-3">
                <div class="mb-3">
                    <i class="fas fa-user-circle fa-4x text-primary"></i>
                </div>
                <h6 class="fw-bold mb-1">Kasaye Tarekgne</h6>
                <p class="small text-muted mb-3">Database Designer</p>
                <div class="border-top pt-2">
                    <p class="small mb-1"><i class="fas fa-phone text-success me-2"></i> +251 976 231 703</p>
                    <p class="small mb-0 text-truncate"><i class="fas fa-envelope text-danger me-2"></i> Kasech@gmail.com</p>
                </div>
            </div>
        </div>

        {{-- Developer Card 4 --}}
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0 text-center p-3">
                <div class="mb-3">
                    <i class="fas fa-user-circle fa-4x text-primary"></i>
                </div>
                <h6 class="fw-bold mb-1">Abreham Alemu</h6>
                <p class="small text-muted mb-3">UI/UX Designer</p>
                <div class="border-top pt-2">
                    <p class="small mb-1"><i class="fas fa-phone text-success me-2"></i> +251 918 250 919</p>
                    <p class="small mb-0 text-truncate"><i class="fas fa-envelope text-danger me-2"></i> Abrsh@gmail.com</p>
                </div>
            </div>
        </div>
    </div>*/
    </style>
@endsection