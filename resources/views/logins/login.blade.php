
   @extends('layouts.wel')
   @section('content')

<div class="login-container">
    <h2><img src="{{asset('image/logo.jfif')}}" width="70" height="60" alt="log in" class=""></h2>
    @if(session('error'))
        <div class="alert alert-danger mb-4 text-center">{{ session('error') }}</div>
    @endif
    

    @if(session('message'))
        <div class="alert alert-success mb-4 text-center">{{ session('message') }}</div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}"> 
        @csrf 
        <div class="form-group mb-3">
            <label for="email" class="form-label">Email Address:</label>
            <input type="email" id="email" name="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   value="{{ old('email') }}" required autofocus placeholder="Enter your email">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   required placeholder="Enter your password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-outline-danger w-100 py-2 fw-bold">Log In</button>
        
        <div class="text-center mt-3">
            <a href="{{ route('create.link') }}" class="text-decoration-none">Don't have an account? Register here.</a>
        </div>
    </form>
</div>

@endsection