@extends('layouts.wel')
@section('content')
<div class="container mt-5 mx-2">

<div class="section-card" onclick="window.location.href='complaint_form.html'">
            <h2 class="section-title">Welcome to the Feedback and Complaint System</h2>
            <p class="mb-4 mb-0">
            This system is designed to provide students, staff, and the community with a structured way to submit feedback, suggestions, or formal complaints regarding university services, staff, or facilities. Your input is vital for continuous improvement.
        </p>
   
        </div>
    </div>
<section id="main-banner" class="mx-4">
        <p>ለቀጣይ መሻሻል ግብዓትዎን ያስገቡ የእርስዎ ድምጽ ለዩኒቨርሲቲያችን ወሳኝ ነው።</p>
        
    </section>

    <section id="quick-links" class="mx-4 mt-2">
    <h2 class="px-4">ደንቦችን ይመልከቱ እና ሪፖርት ያድርጉ</h2>
        <div class="card-container">
            <div class="card"><a href="{{ url('feedback') }}">አጠቃላይ ግብረመልስ ይስጡ</a></div>
            <div class="card"><a href="{{ url('create') }}">መደበኛ ቅሬታ ያቅርቡ</a></div>
           
        </div>
    </section>
@endsection
