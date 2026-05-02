@extends('layouts.wel')

@section('content')
<div class="login-container">
    <div class="text-center mb-4">
        <img src="{{asset('image/logo.jfif')}}" width="70" height="60" alt="logo">
        <h2 class="mt-2">Create Account</h2>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('storeaccount.link') }}"> 
        @csrf 

        <div class="form-group mb-3">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="Name" class="form-control @error('Name') is-invalid @enderror" value="{{ old('Name') }}" required autofocus>
            @error('Name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="Email" class="form-control @error('Email') is-invalid @enderror" value="{{ old('Email') }}" required>
            @error('Email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password" class="form-label">Password:</label>
            <div class="input-group">
                <input type="password" id="password" name="Password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       required placeholder="Enter your password">
                
        
                <span class="input-group-text" id="togglePassword" style="cursor: pointer; background: white;">
                    <i class="fas fa-eye" id="eyeIcon"></i>
                </span>

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Create Account</button>
    </form>
</div>

<script>
    
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#password');
        const icon = document.querySelector('#eyeIcon');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                
                const isPassword = passwordField.getAttribute('type') === 'password';
                passwordField.setAttribute('type', isPassword ? 'text' : 'password');
                
                
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }
    });
</script>
@endsection