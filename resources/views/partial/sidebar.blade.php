



<div class="sidebar d-flex flex-column p-3">
    <!-- Sidebar Header -->
    <div class="sidebar-header text-center">
        <a class="navbar-brand" href="#"><img class="logo" src="{{asset(('imag/f1.jpg'))}}" width="80" height="80">FMS</a>
    </div>

    <hr class="text-secondary">

    <!-- Navigation Links -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link active">
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard
            </a>
        </li>

<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           Resopnse
          </a>
    <ul class="dropdown-menu bg-info" >
        
    <li><a class="dropdown-item" href="#"><i class="fas fa-eye mx-2"></i>Feedback Resopnse </a></li>
    <li><a class="dropdown-item" href="#"><i class="fas fa-eye mx-2"></i>Complaint Resopnse</a></li>
    
          </ul>
      </li>

 <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           Admin
          </a>
    <ul class="dropdown-menu bg-info" >
        
    <li><a class="dropdown-item" href="#"><i class="fas fa-eye mx-2"></i>Unit Management </a></li>
    <li><a class="dropdown-item" href="#"><i class="fas fa-eye mx-2"></i>View complaint</a></li>
    <li><a class="dropdown-item" href="#"><i class="fas fa-eye mx-2"></i>View feedback</a></li>
    <li><a class="dropdown-item" href="#"><i class="fas fa-eye mx-2"></i>View feedback</a></li>
          </ul>
      </li>
 
        <li class="nav-item mx-4 my-4 ">
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                <button style="margin-top: 100px;" type="submit" class="btn btn-outline-secondary btn-success text-light text-end">LogOut</button>
                     </form>
           </li>
</ul>
   

    <hr class="text-secondary">
    
    
<!-- User Profile at Bottom -->
<div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://placehold.co/100x100/E2E8F0/4A5568?text=User" alt="admin" width="32" height="32" class="rounded-circle me-2">
    
        <strong>{{ Auth::user()->name }}</strong>
    </a>
    
</div>
</div>
























    

