@extends('layouts.wel')
@section('content')

<nav class="navbar navbar-expand-lg bg-info my-5">
  <div class="container-fluid">
    <div class="collapse navbar-collapse fs-4" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{route('home.link')}}">Home</a>
        </li>
         <li class="nav-item dropdown mx-5">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           Reporte
          </a>
           <ul class="dropdown-menu bg-info" >  
              <li><a class="dropdown-item" href="{{route('feedback.link')}}">Feedback Form</a></li>
              <li><a class="dropdown-item" href="#">Complaint Form</a></li>
          </ul>
      </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Help Center</a>
        </li>
      </ul>
      <div style="border-radius: 10px; background-color: cyan;">
       <a class="nav-link float-end px-4 " href="{{route('login')}}">Login</a>
       </div>
    </div>
  </div>
</nav>
@endsection