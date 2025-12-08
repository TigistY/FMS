
@extends('layouts.wel')
@section('content')
<div class="login-container">
    <h2>Create Account</h2>

    @if(session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif


    <form method="POST" action="{{ route('storeaccount.link') }}"> 
        @csrf 

        <div class="form-group mb-3">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="Name" {{-- Controller uses 'Name' --}}
                   class="form-control @error('Name') is-invalid @enderror" 
                   value="{{ old('Name') }}" required autofocus>
            @error('Name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="Email" {{-- Controller uses 'Email' --}}
                   class="form-control @error('Email') is-invalid @enderror" 
                   value="{{ old('Email') }}" required>
            @error('Email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password">Password:</label>
            <input type="password" id="password" name="Password" {{-- Controller uses 'Password' --}}
                   class="form-control @error('Password') is-invalid @enderror" required>
            @error('Password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Create Account</button>
    </form>
</div>
@endsection
