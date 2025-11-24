<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register New User</title>
    <!-- Adjust this layout/theme according to your Laravel project's master layout -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 600px; margin-top: 50px; padding: 30px; background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #007bff; margin-bottom: 25px; }
    </style>
</head>
<body>

<div class="container">
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

        <div class="form-group mb-4">
            <label for="unit_id">Assigned Unit:</label>
            <select id="unit_id" name="unit_id" {{-- Controller uses 'unit_id' --}}
                    class="form-control @error('unit_id') is-invalid @enderror" required>
                <option value="">Select Your Unit</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}" 
                            {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                        {{ $unit->{'name-en'} }} ({{ $unit->code }})
                    </option>
                @endforeach
            </select>
            @error('unit_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">Create Account</button>
    </form>
</div>

</body>
</html>