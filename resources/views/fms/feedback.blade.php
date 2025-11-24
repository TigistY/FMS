<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="doc-title-feedback">Feedback Submission Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Ethiopic:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: 'Noto Sans Ethiopic', sans-serif; background-color: #f3f4f6; }
        /* Style for Feedback (Blue Theme) */
        .feedback-theme { border-left: 6px solid #3b82f6; }
        .feedback-button { background-color: #3b82f6; }
        .feedback-button:hover { background-color: #2563eb; }
        .feedback-ring { --tw-ring-color: #3b82f6; }
    </style>
</head>
<body class="p-4 sm:p-8">
    <div class="max-w-xl mx-auto bg-white p-6 md:p-8 rounded-xl shadow-2xl border border-gray-100 feedback-theme">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center" id="main-title">Feedback Submission</h1>
        <p class="text-gray-600 mb-6 text-center" id="subtitle">Please select the relevant unit and enter the details of your advice, appreciation, or suggestion.</p>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
 @if(session('success'))
        <div class="alert alert-success mb-4 text-center">{{ session('success') }}</div>
    @endif

        <form action="{{route('feedback.submit')}}" method="POST" class="space-y-6">
            @csrf <div>
                <label for="language_selector" class="block text-sm font-medium text-gray-700 mb-1" id="label-language">Select Language:</label>
                <select id="language_selector" onchange="window.switchLanguage(this.value)"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150 bg-blue-50 feedback-ring">
                    <option value="am">አማርኛ</option>
                    <option value="en" selected>English</option>
                </select>
            </div>
            
            <div>
                <label for="unit_id" class="block text-sm font-medium text-gray-700 mb-1" id="label-unit">Unit/Department Concerned:</label>
                <select id="unit_id" name="unit_id" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150 feedback-ring">
                    <option value="" id="option-select-unit">Select Unit</option>
                    </select>
            </div>

            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1" id="label-subject">Subject:</label>
                <input type="text" id="subject" name="subject" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150 feedback-ring"
                       placeholder="Short and clear subject" id="placeholder-subject">
            </div>

            <div>
                <label for="body" class="block text-sm font-medium text-gray-700 mb-1" id="label-description">Detailed Description (min 50 words):</label>
                <textarea id="body" name="body" rows="5" required 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150 feedback-ring"
                          placeholder="Describe your feedback in detail..." id="placeholder-description"></textarea>
            </div>
            
            <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                <input id="is_anonymous" name="is_anonymous" type="checkbox" onchange="window.toggleGuestFields()" 
                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 feedback-ring">
                <label for="is_anonymous" class="text-sm font-medium text-blue-800" id="label-anonymous">I wish to remain Anonymous.</label>
            </div>
            <p class="text-xs text-blue-500" id="text-anonymous-warning">If you choose this, your identity will be hidden, but you may not receive a response.</p>

            <div id="guest-fields" class="space-y-4 pt-4 border-t border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800" id="title-contact">Contact Information (Optional)</h2>
                <div>
                    <label for="guest_email" class="block text-sm font-medium text-gray-700 mb-1" id="label-email">Email (for response):</label>
                    <input type="email" id="guest_email" name="guest_email" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150 feedback-ring"
                           placeholder="Email where you expect a response" id="placeholder-email">
                </div>
                <div>
                    <label for="guest_name" class="block text-sm font-medium text-gray-700 mb-1" id="label-name">Name (Optional):</label>
                    <input type="text" id="guest_name" name="guest_name" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150 feedback-ring"
                           placeholder="Full Name" id="placeholder-name">
                </div>
                <div>
                    <label for="guest_type" class="block text-sm font-medium text-gray-700 mb-1" id="label-type">Reporter Type:</label>
                    <select id="guest_type" name="guest_type" 
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150 feedback-ring">
                        <option value="" id="option-select-type">Select Type</option>
                        <option value="Student" id="option-student">Student</option>
                        <option value="Teacher" id="option-teacher">Teacher</option>
                        <option value="Employee" id="option-employee">Employee</option>
                        <option value="Other" id="option-other">Other</option>
                    </select>
                </div>
            </div>

            <button type="submit" id="button-submit"
                    class="w-full py-3 text-white font-semibold rounded-lg transition duration-200 shadow-md feedback-button">
                Submit Feedback
            </button>
        </form>
    </div>

    <script>
        // Shared Data and Logic (Encapsulated in window object for easy access)
        window.unitsData = [
            { id: 1, code: 'GENERAL', name_en: 'General Complaint Receiver', name_am: 'ጠቅላላ የቅሬታ ተቀባይ' },
            { id: 2, code: 'CS', name_en: 'Computer Science Department', name_am: 'የኮምፒውተር ሳይንስ ክፍል' },
            { id: 3, code: 'EE', name_en: 'Electrical Engineering Department', name_am: 'የኤሌክትሪካል ምህንድስና ክፍል' },
            { id: 4, code: 'RG', name_en: 'Registrar Office', name_am: 'ሬጅስትራር ጽ/ቤት' },
            { id: 5, code: 'LIB', name_en: 'Library Services', name_am: 'የቤተ-መጽሐፍት አገልግሎት' },
            { id: 6, code: 'CAFE', name_en: 'Cafeteria Services', name_am: 'የካፌቴሪያ አገልግሎት' },
            { id: 7, code: 'TC-DEAN', name_en: 'Technology College Dean Office', name_am: 'የቴክኖሎጂ ኮሌጅ ዲን ጽ/ቤት' },
            { id: 8, code: 'FB-DEAN', name_en: 'Business and Economics College Dean Office', name_am: 'የቢዝነስና ኢኮኖሚክስ ኮሌጅ ዲን ጽ/ቤት' },
            { id: 9, code: 'NC-DEAN', name_en: 'Natural and Computational Sciences College Dean Office', name_am: 'የተፈጥሮና የሒሳብ ሳይንስ ኮሌጅ ዲን ጽ/ቤት' },
            { id: 10, code: 'ST-PRES', name_en: 'Student President Office', name_am: 'የተማሪዎች ፕሬዝደንት ጽ/ቤት' },
            { id: 11, code: 'ADMIN', name_en: 'General Administration', name_am: 'ጠቅላላ አስተዳደር' },
        ];

        window.translations = {
            'am': {
                'doc-title-feedback': 'ግብረመልስ ማስገቢያ',
                'main-title': 'ግብረመልስ ማስገቢያ',
                'subtitle': 'አስተያየትዎን፣ ምስጋናዎን ወይም ምክርዎን የሚመለከተውን ክፍል በመምረጥ ያስገቡ።',
                'label-language': 'ቋንቋ ይምረጡ:',
                'label-unit': 'ግብረመልሱ የሚመለከተው ክፍል/ዩኒት:',
                'option-select-unit': 'ክፍል ይምረጡ',
                'label-subject': 'ርዕስ:',
                'placeholder-subject': 'አጭርና ግልጽ ርዕስ',
                'label-description': 'ዝርዝር መግለጫ (ቢያንስ 50 ቃላት):',
                'placeholder-description': 'አስተያየትዎን በዝርዝር ያስቀምጡ...',
                'label-anonymous': 'ስም-አልባ መሆን እፈልጋለሁ።',
                'text-anonymous-warning': 'ይህን ከመረጡ፣ ማንነትዎ ሙሉ በሙሉ ይደበቃል፣ ነገር ግን ምላሽ ላይደርስዎት ይችላል።',
                'title-contact': 'የእውቂያ መረጃ (አስገዳጅ አይደለም)',
                'label-email': 'ኢሜይል (ለአጸፋ መልስ):',
                'placeholder-email': 'ምላሽ የሚደርስበት ኢሜይል',
                'label-name': 'ስም (አማራጭ):',
                'placeholder-name': 'ሙሉ ስም',
                'label-type': 'የሪፖርተር አይነት:',
                'option-select-type': 'ይመድቡ',
                'option-student': 'ተማሪ',
                'option-teacher': 'መምህር',
                'option-employee': 'ሰራተኛ',
                'option-other': 'ሌላ',
                'button-submit': 'ግብረመልስ አስገባ',
            },
            'en': {
                'doc-title-feedback': 'Feedback Submission Form',
                'main-title': 'Feedback Submission',
                'subtitle': 'Please select the relevant unit and enter the details of your advice, appreciation, or suggestion.',
                'label-language': 'Select Language:',
                'label-unit': 'Unit/Department Concerned:',
                'option-select-unit': 'Select Unit',
                'label-subject': 'Subject:',
                'placeholder-subject': 'Short and clear subject',
                'label-description': 'Detailed Description (min 50 words):',
                'placeholder-description': 'Describe your feedback in detail...',
                'label-anonymous': 'I wish to remain Anonymous.',
                'text-anonymous-warning': 'If you choose this, your identity will be hidden, but you may not receive a response.',
                'title-contact': 'Contact Information (Optional)',
                'label-email': 'Email (for response):',
                'placeholder-email': 'Email where you expect a response',
                'label-name': 'Name (Optional):',
                'placeholder-name': 'Full Name',
                'label-type': 'Reporter Type:',
                'option-select-type': 'Select Type',
                'option-student': 'Student',
                'option-teacher': 'Teacher',
                'option-employee': 'Employee',
                'option-other': 'Other',
                'button-submit': 'Submit Feedback',
            }
        };

        window.updateUnitOptions = (lang) => {
            const unitSelect = document.getElementById('unit_id');
            const placeholderOption = document.getElementById('option-select-unit');
            const selectedUnitId = unitSelect.value;
            
            unitSelect.innerHTML = '';
            unitSelect.appendChild(placeholderOption);

            const nameKey = lang === 'am' ? 'name_am' : 'name_en';
            
            window.unitsData.forEach(unit => {
                const option = document.createElement('option');
                option.value = unit.id;
                option.textContent = `${unit[nameKey]} (${unit.code})`;
                if (unit.id == selectedUnitId) {
                    option.selected = true;
                }
                unitSelect.appendChild(option);
            });
            
            placeholderOption.textContent = window.translations[lang]['option-select-unit'];
        }

        window.switchLanguage = (lang) => {
            for (const key in window.translations[lang]) {
                const element = document.getElementById(key);
                if (element) {
                    // Handle input/textarea placeholders
                    if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                        element.placeholder = window.translations[lang][key];
                    } 
                    // Handle button and title text
                    else if (element.tagName === 'BUTTON' || element.id.startsWith('doc-title-')) {
                        element.textContent = window.translations[lang][key];
                    } 
                    // Handle all other text content (labels, titles, etc.)
                    else {
                        element.textContent = window.translations[lang][key];
                    }
                }
            }
            
            window.updateUnitOptions(lang);
        }

        window.toggleGuestFields = () => {
            const isAnonymous = document.getElementById('is_anonymous').checked;
    const guestFields = document.getElementById('guest-fields');
    const guestEmail = document.getElementById('guest_email');
    const guestName = document.getElementById('guest_name');
    const guestType = document.getElementById('guest_type');
    
    if (isAnonymous) {
        guestFields.style.display = 'none';
        
        // 🔑 እነዚህን መስኮች 'required' የሚለውን attribute ያስወግዱ
        guestEmail.removeAttribute('required');
        guestName.removeAttribute('required');
        guestType.removeAttribute('required');
        
        // Clear inputs when hiding (ትክክል ነው)
        guestEmail.value = '';
        guestName.value = '';
        guestType.value = '';
    } else {
        guestFields.style.display = 'block';
        
        // 🔑 እነዚህን መስኮች 'required' የሚለውን attribute ይጨምሩ
        guestEmail.setAttribute('required', 'required');
        guestName.setAttribute('required', 'required'); // Name አማራጭ ስለሆነ ማስቀረት ይችላሉ
        guestType.setAttribute('required', 'required'); // Type አማራጭ ስለሆነ ማስቀረት ይችላሉ
    }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            // Changed from 'am' to 'en' to make English the default display language
            window.switchLanguage('en'); 
            window.toggleGuestFields();
            // Set the language selector to 'en'
            document.getElementById('language_selector').value = 'en';
        });
    </script>
</body>
</html>