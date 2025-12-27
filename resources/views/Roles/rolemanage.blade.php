@extends('layouts.wel')
@section('content')
<div class="login-container">
   <h2><img src="{{asset('image/logo.jfif')}}" width="70" height="60" alt="log in" class=""></h2>

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
            <input type="text" id="name" name="Name" class="form-control @error('Name') is-invalid @enderror" value="{{ old('Name') }}" required autofocus>
            @error('Name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="Email" class="form-control @error('Email') is-invalid @enderror" value="{{ old('Email') }}" required>
            @error('Email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
       
    

        <div class="form-group mb-3">
            <label for="college_id">College (Optional):</label>
            <select name="college_id" id="college_id" class="form-control">
                <option value="">-- Select College --</option>
                @foreach($colleges as $college)
                    <option value="{{ $college->id }}">{{ $college->name_en }}</option>
                @endforeach
            </select>
        </div>

       {{--departemnt  --}}
     
        <div class="form-group mb-3">
            <label for="department_id">Department (Optional):</label>
            <select name="department_id" id="department_id" class="form-control">
                <option value="">-- Select Department --</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name_en }}</option>
                @endforeach
            </select>
        </div>

        {{-- directory --}}
        <div class="form-group mb-3">
            <label for="directory_id">Directory (Optional):</label>
            <select name="directory_id" id="directory_id" class="form-control">
                <option value="">-- Select Directory --</option>
                @foreach($directories as $dir)
                    <option value="{{ $dir->id }}">{{ $dir->name_en }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="password">Password:</label>
            <input type="password" id="password" name="Password" class="form-control @error('Password') is-invalid @enderror" required>
            @error('Password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Create Account</button>
    </form>
</div>
@endsection