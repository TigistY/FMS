<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Ethiopic:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Noto Sans Ethiopic', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="p-4 sm:p-8">
    <div class="max-w-3xl mx-auto bg-white p-6 md:p-8 rounded-xl shadow-2xl border border-gray-100">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-2">Report Response Form</h1>
        
        <div class="bg-gray-50 p-6 rounded-lg mb-6 border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-700 mb-3">Report Details: Complaint #1024</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="font-medium text-gray-600">Report Type:</p>
                    <p class="text-lg text-red-600 font-bold">Complaint</p>
                </div>
                <div>
                    <p class="font-medium text-gray-600">Concerned Unit:</p>
                    <p class="text-lg text-gray-800">Registrar Office (RG)</p>
                </div>
                <div>
                    <p class="font-medium text-gray-600">Reporter:</p>
                    <p class="text-lg text-blue-600">Abebe Kebede (Guest - abe@mail.com)</p>
                </div>
                 <div>
                    <p class="font-medium text-gray-600">Status:</p>
                    <p class="text-lg font-bold text-yellow-600">In Progress</p>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="font-medium text-gray-600 mb-2">Original Message (Description):</p>
                <p class="text-gray-900 bg-white p-3 rounded-md border">
                    The Registrar's Office has been closed for three days, causing the Add/Drop period to pass. Students could not access this service. Please extend the deadline.
                </p>
            </div>
        </div>
        
        <form action="/respond-to-report/1024" method="POST" class="space-y-6">
            @csrf
            @method('PUT') <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border p-4 rounded-lg bg-indigo-50">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Update Status:</label>
                    <select id="status" name="status" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                        <option value="In Progress" selected>In Progress</option>
                        <option value="Resolved">Resolved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority:</label>
                    <select id="priority" name="priority"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                        <option value="Low">Low</option>
                        <option value="Medium" selected>Medium</option>
                        <option value="High">High</option>
                        <option value="Urgent">Urgent</option>
                    </select>
                </div>
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Due Date for Response:</label>
                    <input type="date" id="due_date" name="due_date" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                </div>
            </div>

            <div>
                <label for="response_text" class="block text-sm font-medium text-gray-700 mb-1">Your Response:</label>
                <textarea id="response_text" name="response_text" rows="8" required 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-150"
                          placeholder="Write a detailed response to the report. This response will be sent to the reporter."></textarea>
            </div>
            
            <button type="submit" 
                    class="w-full py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-200 shadow-md">
                Submit Response and Close Report
            </button>
        </form>
    </div>
</body>
</html>