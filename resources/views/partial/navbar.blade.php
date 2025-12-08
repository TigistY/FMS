<!-- Top Header Bar -->
<header class="bg-dark shadow-md p-4 flex justify-between  sticky top-0 z-10">
    

    <nav class="navbar navbar-expand-lg navbar-light shadow-sm " style="background-image: url('{{asset('imag/logo.jfif')}}');">
    <div class="container-fluid">
        <!-- Sidebar Toggle Button (for mobile) -->
        <button class="btn btn-dark d-md-none" type="button" id="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>

</nav>
 <div class="space-x-4 float-end mb-4 bg-blue-50">
        <label for="language_selector" class="text-sm font-medium text-white" id="label-language"><i class="fa-sharp fa-regular fa-globe"></i></label>
        <select id="language_selector" onchange="switchLanguage(this.value)"
                class="px-3 py-1 items-end border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-blue-50">
            <option value="am">አማርኛ</option>
            <option value="en">English</option>
        </select>
    </div>
</header>