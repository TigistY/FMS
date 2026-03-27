@canany(['role-management', 'view-complaints'])
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm" style="border-left: 5px solid #0d6efd !important;">
                <div class="card-body p-4 text-center text-md-start">
                    <h6 class="text-secondary mb-1 small">{{ __('messages.Total Complaint') }}</h6>
                    <h2 class="fw-bold mb-0 text-primary">{{ $totalComplaints }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm" style="border-left: 5px solid #198754 !important;">
                <div class="card-body p-4 text-center text-md-start">
                    <h6 class="text-secondary mb-1 small">{{ __('messages.Total Feedback') }}</h6>
                    <h2 class="fw-bold mb-0 text-success">{{ $totalFeedback }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm" style="border-left: 5px solid #ffc107 !important;">
                <div class="card-body p-4 text-center text-md-start">
                    <h6 class="text-secondary mb-1 small">{{ __('messages.Accessed User') }}</h6>
                    <h2 class="fw-bold mb-0 text-warning">{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>
    </div>

    @can('role-management')
    <div class="row mt-2">
        <div class="col-12"><h5 class="fw-bold mb-3">{{ __('messages.Feedback Sentiment Analysis') }}</h5></div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-white" style="background-color: #198754;">
                <div class="card-body p-4 d-flex justify-content-between text-white">
                    <div><h6 class="text-white-50">{{ __('messages.Positive') }}</h6><h2 class="text-white">{{ $sentimentStats['Positive'] ?? 0 }}</h2></div>
                    <i class="fas fa-smile fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-dark" style="background-color: #ffc107;">
                <div class="card-body p-4 d-flex justify-content-between">
                    <div><h6 class="text-black-50">{{ __('messages.Neutral') }}</h6><h2 class="text-dark">{{ $sentimentStats['Neutral'] ?? 0 }}</h2></div>
                    <i class="fas fa-meh fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-white" style="background-color: #dc3545;">
                <div class="card-body p-4 d-flex justify-content-between text-white">
                    <div><h6 class="text-white-50">{{ __('messages.Negative') }}</h6><h2 class="text-white">{{ $sentimentStats['Negative'] ?? 0 }}</h2></div>
                    <i class="fas fa-frown fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    @endcan
    @endcanany
