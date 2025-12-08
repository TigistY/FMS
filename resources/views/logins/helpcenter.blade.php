@extends('layouts.wel')

@section('content')

    <section id="help-header">
        <h1>የእርዳታ ማዕከል</h1>
        <p>የስርዓቱን አጠቃቀም በተመለከተ ለሚነሱ ጥያቄዎችዎ መልስ ያግኙ።</p>
        <input type="search" placeholder="ጥያቄዎን ወይም ቁልፍ ቃልዎን ይፈልጉ...">
    </section>

    <hr>

    <section id="faq-section">
        <h2>ተደጋጋሚ ጥያቄዎች (FAQs)</h2>
        <div class="faq-group">
            <h3>የግብዓት አቀራረብ</h3>
            <details>
                <summary>መደበኛ ቅሬታ ለማቅረብ ምን ያስፈልጋል?</summary>
                <p>የተፈጠረውን ችግር ዝርዝር መግለጫ፣ የተጎዳኙበትን ቀን እና ሰዓት እንዲሁም ማስረጃዎችን (ካሉ) ማቅረብ ይኖርብዎታል።</p>
            </details>
            <details>
                <summary>ግብዓት በስንት ጊዜ ውስጥ ምላሽ ያገኛል?</summary>
                <p>የተለመደው የግብረመልስ ጊዜ 3 የስራ ቀናት ሲሆን ለመደበኛ ቅሬታዎች ደግሞ እስከ 7 የስራ ቀናት ሊወስድ ይችላል።</p>
            </details>
            {{-- ሌሎች ጥያቄዎች --}}
        </div>
    </section>

    <hr>

    <section id="guidelines">
        <h2>መመሪያዎች እና ሰነዶች</h2>
        <ul>
            <li><a href="#">የግብረመልስ አቀራረብ የሂደት ፍሰት ቻርት (PDF)</a></li>
            <li><a href="#">የስርዓቱ አጠቃቀም አጭር መመሪያ</a></li>
            <li><a href="#">የአገልግሎት ደረጃዎች (SLAs)</a></li>
        </ul>
    </section>

    <section id="contact-support">
        <h2>ተጨማሪ እርዳታ ይፈልጋሉ?</h2>
        <h2>ተጨማሪ እርዳታ ይፈልጋሉ?</h2>
        <p>📞 ስልክ ቁጥር: 011-XXXXXXXX</p>
        <p>📧 ኢሜይል: support@university.edu</p>
    </section>

@endsection