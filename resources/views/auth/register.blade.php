<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - CineMax</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg:       #0d0d0f;
            --surface:  #141417;
            --surface2: #1c1c21;
            --accent:   #e8340a;
            --accent2:  #ff6b35;
            --gold:     #f5c518;
            --text:     #f0eff4;
            --muted:    rgba(240,239,244,0.5);
            --border:   rgba(240,239,244,0.08);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: rgba(13,13,15,0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0.9rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
            color: var(--accent) !important;
            letter-spacing: 2px;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none;
        }

        .navbar-brand .brand-dot {
            width: 8px;
            height: 8px;
            background: var(--accent);
            border-radius: 50%;
            display: inline-block;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.4; transform: scale(0.7); }
        }

        .nav-link {
            color: var(--muted) !important;
            font-size: 0.88rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            padding: 0.4rem 1rem !important;
            transition: color 0.2s;
        }

        .nav-link:hover { color: var(--text) !important; }

        .container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            min-height: calc(100vh - 94px);
        }

        .register-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 2rem;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }

        .register-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.2rem;
            color: var(--accent);
            text-align: center;
            margin-bottom: 1.5rem;
            letter-spacing: 1px;
        }

        .form-label {
            color: var(--text);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-control {
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            border-radius: 0.4rem;
            padding: 0.75rem;
            font-size: 0.95rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(232,52,10,0.2);
        }

        .form-control::placeholder { color: var(--muted); }

        .btn-register {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.85rem 1.5rem;
            border-radius: 0.4rem;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            width: 100%;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            margin-top: 1rem;
        }

        .btn-register:hover {
            background: #c42908;
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 1rem;
            color: var(--muted);
        }

        .login-link a {
            color: var(--accent);
            text-decoration: none;
        }

        .login-link a:hover { color: var(--accent2); }

        .alert {
            background: rgba(232,52,10,0.1);
            border: 1px solid rgba(232,52,10,0.3);
            color: var(--accent2);
            border-radius: 0.4rem;
            padding: 0.75rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: rgba(72, 187, 120, 0.12);
            border-color: rgba(72, 187, 120, 0.35);
            color: #8ce5a1;
        }

        .alert-danger {
            background: rgba(232,52,10,0.1);
            border-color: rgba(232,52,10,0.3);
            color: var(--accent2);
        }

        .text-danger { color: #ff6b35 !important; }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="/">
                <i class="bi bi-play-circle-fill"></i>
                CINEMAX
                <span class="brand-dot"></span>
            </a>

            <div class="d-flex align-items-center gap-3">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="/movies">Movies</a>
                @if(Auth::check())
                    <span class="navbar-text me-3">Welcome, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="register-card">
            <h1 class="register-title">JOIN CINEMAX</h1>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn-register">Create Account</button>
            </form>
            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Login here</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>