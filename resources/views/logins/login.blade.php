<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <!-- Adjust this layout/theme according to your Laravel project's master layout -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { 
            background-color: #f0f2f5; 
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-container { 
            max-width: 450px; 
            padding: 40px; 
            background: white; 
            border-radius: 12px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
        }
        h2 { 
            text-align: center; 
            color: #007bff; 
            margin-bottom: 30px; 
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Log In</h2>

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

        <button type="submit" class="btn btn-primary w-100 py-2">Log In</button>
        
        <div class="text-center mt-3">
            <a href="{{ route('create.link') }}" class="text-decoration-none">Don't have an account? Register here.</a>
        </div>
    </form>
</div>

</body>
</html>