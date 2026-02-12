@extends('layouts.app')

@section('content')
<div class="container card shadow-sm p-5 border-0">
    <h2 class="text-primary fw-bold"><i class="fas fa-info-circle"></i> ስለ ሲስተሙ (System Info)</h2>
    <hr>
    
    <p>ይህ የቅሬታ እና ግብረ-መልስ ማስተዳደሪያ ሲስተም በእንጅባራ ዩኒቨርሲቲ የኮምፒውተር ሳይንስ ተማሪዎች የተገነባ ሲሆን፣ በዩኒቨርሲቲው ICT ዳይሬክቶሬት ክትትል እና ድጋፍ የሚደረግለት ሲስተም ነው።</p>
    
    <p>ዋና ዓላማው በዩኒቨርሲቲው ውስጥ ያለውን አገልግሎት አሰጣጥ ግልጽ፣ ፈጣን እና ተጠያቂነት የሰፈነበት ለማድረግ ነው።</p>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <h5 class="fw-bold text-secondary">ዝርዝር መረጃ</h5>
            <ul class="list-unstyled">
                
                <li class="mb-2"><i class="fas fa-user-graduate me-2"></i> <strong>Developers:</strong> INU Computer Science Students</li>
                <li class="mb-2"><i class="fas fa-chalkboard-teacher me-2"></i> <strong>Adviser:</strong> Mr. Andualem Muche (CS Teacher)</li>
                <li class="mb-2"><i class="fas fa-shield-alt me-2"></i> <strong>Managed by:</strong> INU ICT Directorate</li>
            </ul>
        </div>
    </div>
</div>
@endsection