<!-- Top Header Bar -->
<header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-10">
    

    <nav class="navbar navbar-expand-lg navbar-light shadow-sm " style="background-image: url('{{asset('imag/f4.jpg')}}');">
    <div class="container-fluid">
        <!-- Sidebar Toggle Button (for mobile) -->
        <button class="btn btn-dark d-md-none" type="button" id="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Language Selector -->
    <div class="flex items-center space-x-4">
        <label for="language_selector" class="text-sm font-medium text-gray-600" id="label-language">Language:</label>
        <select id="language_selector" onchange="switchLanguage(this.value)"
                class="px-3 py-1 items-end border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-blue-50">
            <option value="am">አማርኛ</option>
            <option value="en">English</option>
        </select>
    </div>

</nav>
</header>