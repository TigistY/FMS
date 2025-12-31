@extends('layouts.app')

@section('content')
<div class="container-fluid">
   
    <div class="row mb-4 align-items-center">
        <div class="col-md-8 text-center text-md-start">
            <h3 class="fw-bold text-dark mb-1">እንኳን ደህና መጡ፣ {{ Auth::user()->name }}!</h3>
            <div class="d-flex flex-wrap justify-content-center justify-content-md-start align-items-center gap-2">
                <span class="text-secondary small">የሥራ ድርሻዎ፦</span>
                @foreach(Auth::user()->roles as $role)
                    <span class="badge rounded-pill bg-info text-dark px-3 shadow-sm">
                        <i class="fas fa-user-tag me-1 small"></i> {{ $role->name }}
                    </span>
                @endforeach
            </div>
        </div>
        <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
            <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> Date፡ {{ date('M d, Y') }}</span>
        </div>
    </div>

    {{--  Summary Cards  Admin and  Unit Responder --}}
    @canany(['role-management', 'view-complaints'])
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm card-hover-effect" style="border-left: 5px solid #0d6efd !important;">
                <div class="card-body p-4 text-center text-md-start">
                    <h6 class="text-secondary mb-1 small">ጠቅላላ ቅሬታዎች</h6>
                    <h2 class="fw-bold mb-0 text-primary">{{ $totalComplaints }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm card-hover-effect" style="border-left: 5px solid #198754 !important;">
                <div class="card-body p-4 text-center text-md-start">
                    <h6 class="text-secondary mb-1 small">አጠቃላይ ግብረ-መልስ</h6>
                    <h2 class="fw-bold mb-0 text-success">{{ $totalFeedback }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm card-hover-effect" style="border-left: 5px solid #ffc107 !important;">
                <div class="card-body p-4 text-center text-md-start">
                    <h6 class="text-secondary mb-1 small">የሲስተም ተጠቃሚዎች</h6>
                    <h2 class="fw-bold mb-0 text-warning">{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>
        @can('role-management')
        <div class="col-md-4 mb-4">
    <div class="card border-0 shadow-sm" style="border-left: 5px solid #6c757d !important;">
        <div class="card-body p-4">
            <h6 class="text-secondary mb-1 small">ማንነታቸው ያልታወቁ ተጠቃሚዎች </h6>
            <h2 class="fw-bold mb-0 text-dark">{{ $totalAnonymousRequests }}</h2>
            <p class="extra-small text-muted mt-2">
                (ስም ሳይጠቀሱ የቀረቡ ቅሬታዎችና አስተያየቶች)
            </p>
        </div>
    </div>
</div>
        
        @endcan
    </div>
    @endcanany

    {{-- 2. Task Guidelines Section (ለ Admin እና Unit Responder ብቻ የሚታይ) --}}
    @canany(['role-management', 'view-complaints'])
    <div class="row mt-2 mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 p-4">
                <h5 class="fw-bold text-primary mb-3"><i class="fas fa-tasks me-2 text-info"></i> የሚጠበቁ ተግባራት</h5>
                <hr>
                
                {{-- Admin  --}}
                @can('role-management')
                <div class="alert alert-light border-start border-warning border-4 mb-3">
                    <h6 class="fw-bold"><i class="fas fa-user-shield text-warning me-2"></i> Admin፡</h6>
                    <ul class="mb-0 small text-dark">
                        <li>አዳዲስ ተጠቃሚዎችን መመዝገብ እና ፐርሚሽን (Roles) መስጠት።</li>
                        <li>የኮሌጅ፣ የዲፓርትመንት እና የዳይሬክቶሬት መረጃዎችን ማደራጀት።</li>
                        <li>አጠቃላይ የሲስተሙን እንቅስቃሴ እና ደህንነት መከታተል።</li>
                    </ul>
                </div>
                @endcan

                {{-- unit Respond --}}
                @cannot('role-management')
                <div class="alert alert-light border">
                    <h6><i class="fas fa-reply-all text-success me-2"></i> Unit Responder፡</h6>
                    <ul class="mb-0">
                        <li>ለሚመጡ ቅሬታዎች ፈጣን ምላሽ መስጠት።</li>
                        <li>የተሰጡ ግብረ-መልሶችን መገምገም።</li>
                    
                    </ul>
                </div>
                @endcannot
            </div>
        </div>
    </div>
    @endcanany

    {{-- General User --}}
    @cannot('view-complaints')
    <div class="row justify-content-center py-4">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm bg-light p-4">
                <h4 class="text-center fw-bold mb-4 text-dark">ምን ማድረግ ይፈልጋሉ?</h4>
                <div class="row g-4">
                    <div class="col-md-6">
                        <a href="{{ route('create') }}" class="text-decoration-none h-100">
                            <div class="card h-100 border-0 shadow-sm card-hover-effect p-4 text-center">
                                <div class="mb-3"><i class="fas fa-edit text-danger fa-3x"></i></div>
                                <h5 class="fw-bold text-dark">ቅሬታ አቅርብ</h5>
                                <p class="text-muted small mb-0 text-dark">ያጋጠመዎትን ችግር እዚህ ያሳውቁን።</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('feedback.link') }}" class="text-decoration-none h-100">
                            <div class="card h-100 border-0 shadow-sm card-hover-effect p-4 text-center">
                                <div class="mb-3"><i class="fas fa-comment-dots text-success fa-3x"></i></div>
                                <h5 class="fw-bold text-dark">ግብረ-መልስ ስጥ</h5>
                                <p class="text-muted small mb-0 text-dark">ስለ አገልግሎታችን ያለዎትን አስተያየት ያጋሩን።</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcannot

</div>
@endsection