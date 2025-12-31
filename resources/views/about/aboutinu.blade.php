@extends('layouts.wel')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        
        {{-- የዩኒቨርሲቲው ምስል መለጠፊያ (Main Banner) --}}
        <div class="position-relative text-white p-5 text-center" style="background: url('{{ asset('image/f4.jpg') }}') center/cover no-repeat; min-height: 350px;">
            {{-- የጥቁር ጥላ ውጤት (Overlay) --}}
            <div class="position-absolute top-0 start-0 w-100 h-100 shadow-inset" style="background: rgba(0, 0, 0, 0.5);"></div>
            
            <div class="position-relative mt-4">
                {{-- የዩኒቨርሲቲው ሎጎ (Logo) --}}
                <div class="mb-3">
                    <img src="{{ asset('image/logo.jfif') }}" alt="IU Logo" class="rounded-circle border border-4 border-white shadow" style="width: 120px; height: 120px; object-fit: cover; background: white;">
                </div>
                
                <h1 class="fw-bold display-5">Injibara University | እንጅባራ ዩኒቨርሲቲ</h1>
                <p class="lead fst-italic">"Explore Your Creative Potentials"</p>
            </div>
        </div>

        <div class="card-body p-5">
            <div class="row">
                <div class="col-md-7">
                    <h3 class="text-primary fw-bold mb-3 border-bottom pb-2">
                        <i class="fas fa-history me-2"></i>Background | ታሪካዊ ዳራ
                    </h3>
                    <p class="text-muted lh-lg">
                        Injibara University is one of the public higher education institutions in Ethiopia, located in Awi Zone, Injibara town. It was established with the goal of producing competent graduates and conducting research that solves societal problems.
                    </p>
                    <p class="text-muted lh-lg">
                        እንጅባራ ዩኒቨርሲቲ በአዊ ዞን በንጅባራ ከተማ የሚገኝ የመንግስት ከፍተኛ ትምህርት ተቋም ነው። ዩኒቨርሲቲው ብቁ ምሩቃንን ለማፍራት እና ማህበረሰባዊ ችግሮችን የሚፈቱ ምርምሮችን ለማካሄድ ተመስርቷል።
                    </p>
                    
                    <div class="row mt-4 g-3">
                        <div class="col-sm-6">
                            <div class="p-3 border rounded shadow-sm bg-light h-100">
                                <h5 class="fw-bold text-primary"><i class="fas fa-eye me-2"></i> Vision | ራዕይ</h5>
                                <p class="small mb-0">To be one of the top ten comprehensive universities in Ethiopia by 2030.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 border rounded shadow-sm bg-light h-100">
                                <h5 class="fw-bold text-success"><i class="fas fa-bullseye me-2"></i> Mission | ተልዕኮ</h5>
                                <p class="small mb-0">Producing competent and ethically grounded graduates through quality education and research.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-5 mt-4 mt-md-0">
                    <div class="row g-2">
                        <div class="col-6">
                            <img src="{{ asset('image/inu10.jfif') }}" class="img-fluid rounded-3 shadow-sm hover-zoom" alt="INU Building">
                        </div>
                        <div class="col-6">
                            <img src="{{ asset('image/inu7.jfif') }}" class="img-fluid rounded-3 shadow-sm hover-zoom" alt="INU Gate">
                        </div>
                        <div class="row g-2">
                        <div class="col-6">
                            <img src="{{ asset('image/inu9.jfif') }}" class="img-fluid rounded-3 shadow-sm hover-zoom" alt="INU Building">
                        </div>
                        <div class="col-6">
                            <img src="{{ asset('image/inu5.jfif') }}" class="img-fluid rounded-3 shadow-sm hover-zoom" alt="INU Gate">
                        </div>
                        <div class="col-12 mt-3">
                            <div class="p-4 bg-white border border-start border-primary border-4 rounded shadow-sm">
                                <h6 class="fw-bold text-primary"><i class="fas fa-map-marker-alt me-2"></i> Location | አድራሻ</h6>
                                <p class="small mb-0 text-muted">Injibara Town, Awi Zone, Amhara Region, Ethiopia</p>
                                <hr class="my-2">
                                <p class="small mb-0"><strong>Contact:</strong> FMS@inu.edu.et</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ምስሎቹ ላይ ማውስ ሲያርፍ በትንሹ እንዲያድጉ (Zoom) */
    .hover-zoom {
        transition: transform 0.3s ease;
    }
    .hover-zoom:hover {
        transform: scale(1.05);
    }
    
    .shadow-inset {
        box-shadow: inset 0 0 100px rgba(0,0,0,0.5);
    }
</style>
@endsection