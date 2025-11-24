<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>የተጠቃሚ ሮል አስተዳደር</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Ethiopic:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Noto Sans Ethiopic', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="p-4 sm:p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 md:p-8 rounded-xl shadow-2xl border border-gray-100">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">የተጠቃሚ ሮል እና ክፍል ምደባ</h1>
        
        <!-- Search and Filter (Conceptual) -->
        <div class="mb-6">
            <input type="text" placeholder="ተጠቃሚ በስም ወይም በኢሜይል ፈልግ..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- User List Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ስም / ኢሜይል</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">የተመደበበት ክፍል (Unit)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ሮሎች (Roles)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ድርጊት (Action)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                    <!-- Example User Row (This should be generated via a @foreach loop in Laravel) -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">አበበ ከበደ</div>
                            <div class="text-sm text-gray-500">abebe@university.edu</div>
                        </td>
                        <!-- Unit Assignment -->
                        <td class="px-6 py-4 whitespace-nowrap">
                             <select name="unit_id" class="text-sm border-gray-300 rounded-md">
                                <option value="null">ክፍል አልተመደበም</option>
                                <option value="1" selected>Computer Science Department (CS)</option>
                                <option value="3">Registrar Office (RG)</option>
                                <!-- @foreach ($units as $unit) -->
                                <!-- @endforeach -->
                            </select>
                        </td>
                        <!-- Role Assignment -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="space-y-1">
                                <!-- @foreach ($roles as $role) -->
                                <label class="flex items-center text-sm text-gray-700">
                                    <input type="checkbox" name="roles[]" value="1" class="rounded text-indigo-600 mr-2" checked>
                                    Feedback Responder
                                </label>
                                <label class="flex items-center text-sm text-gray-700">
                                    <input type="checkbox" name="roles[]" value="2" class="rounded text-indigo-600 mr-2">
                                    Complaint Receiver
                                </label>
                                <label class="flex items-center text-sm text-gray-700">
                                    <input type="checkbox" name="roles[]" value="3" class="rounded text-indigo-600 mr-2">
                                    System Administrator
                                </label>
                                <!-- @endforeach -->
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button type="submit" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 px-3 py-1 rounded-md transition duration-150">
                                አስቀምጥ
                            </button>
                        </td>
                    </tr>
                    
                    <!-- ... Other User Rows ... -->
                </tbody>
            </table>
        </div>
        
    </div>
</body>
</html>