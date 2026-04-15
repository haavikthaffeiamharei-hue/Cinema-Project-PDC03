<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $movie->title }} - CineMax</title>
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
        }

        .navbar {
            background: rgba(13,13,15,0.85);
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
            padding: 2rem;
        }

        .movie-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3rem;
            color: var(--accent);
            margin-bottom: 1rem;
            letter-spacing: 1px;
        }

        .movie-header {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
            align-items: flex-start;
        }

        .movie-poster {
            flex-shrink: 0;
            width: 250px;
        }

        .movie-info {
            flex: 1;
        }

        .movie-details {
            margin-bottom: 1rem;
        }

        .movie-description {
            color: var(--muted);
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .movie-meta {
            display: flex;
            gap: 2rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .meta-item {
            color: var(--text);
            font-weight: 500;
        }

        .showtime-card {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .btn-book {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 0.4rem;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-book:hover {
            background: #c42908;
            transform: translateY(-2px);
            color: white;
        }

        .review-panel {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .review-panel h3 {
            margin-bottom: 1rem;
        }

        .review-item {
            border-top: 1px solid rgba(240,239,244,0.08);
            padding: 1rem 0;
        }

        .review-item:first-child {
            border-top: none;
        }

        .review-rating {
            color: var(--gold);
            margin-bottom: 0.5rem;
            display: inline-flex;
            gap: 0.15rem;
        }

        .review-author {
            color: var(--muted);
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .review-comment {
            color: var(--text);
            line-height: 1.6;
        }

        .review-form textarea,
        .review-form select,
        .review-form input {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            color: var(--text);
            border-radius: 0.5rem;
            padding: 0.8rem 1rem;
            width: 100%;
            margin-bottom: 1rem;
        }

        .review-form select option {
            background: #222;
            color: #000;
        }

        .review-form label {
            display: block;
            margin-bottom: 0.4rem;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .review-form button {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 600;
        }

        .review-form button:hover {
            background: #c42908;
            transform: translateY(-1px);
        }

        .review-summary {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .review-summary span {
            color: var(--muted);
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .navbar-text.welcome-text {
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: 0.8px;
            color: var(--text) !important;
        }

        .search-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 999px;
            padding: 0.35rem 0.9rem;
            min-width: 240px;
        }

        .search-wrap .bi-search {
            color: var(--muted);
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        .search-wrap input {
            background: transparent;
            border: none;
            outline: none;
            color: var(--text);
            width: 180px;
            min-width: 120px;
        }

        .search-wrap input::placeholder {
            color: var(--muted);
        }

        .section-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            color: var(--text);
            margin-bottom: 1rem;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container-fluid px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <a class="navbar-brand" href="/">
                    <i class="bi bi-play-circle-fill"></i>
                    CINEMAX
                    <span class="brand-dot"></span>
                </a>
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="/movies">Movies</a>
                @if(Auth::check())
                    <a class="nav-link" href="{{ route('bookings.index') }}">My Bookings</a>
                @endif
            </div>

            <form method="GET" action="{{ route('movies.index') }}" class="search-wrap d-flex align-items-center">
                <i class="bi bi-search"></i>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search movies, genres…">
            </form>

            <div class="navbar-user">
                @if(Auth::check())
                    <span class="navbar-text welcome-text">Welcome, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm">Register</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="movie-header">
            <div class="movie-poster">
                <img src="{{ $movie->poster }}" alt="{{ $movie->title }} Poster" style="width: 100%; height: auto; border-radius: 0.75rem; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
            </div>
            <div class="movie-info">
                <h1 class="movie-title">{{ $movie->title }}</h1>
                <div class="movie-details">
                    <p class="movie-description">{{ $movie->description }}</p>
                    <div class="movie-meta">
                        <span class="meta-item">Genre: {{ $movie->genre->name }}</span>
                        <span class="meta-item">Duration: {{ $movie->duration }} min</span>
                        <span class="meta-item">Release Date: {{ $movie->release_date }}</span>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="section-title">SHOWTIMES</h2>
        @foreach($showtimes as $showtime)
            <div class="showtime-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $showtime->hall->cinema->name }} - {{ $showtime->hall->name }}</strong><br>
                        <span>{{ $showtime->start_time->format('M j, Y g:i A') }} - {{ $showtime->end_time->format('g:i A') }}</span><br>
                        <span>Price: ₱{{ number_format($showtime->price, 0) }}</span>
                    </div>
                    @if(Auth::check())
                        <a href="{{ route('bookings.create', ['showtime' => $showtime->id]) }}" class="btn-book">Book Seats</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-book">Login to Book</a>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="review-panel">
            <h3>Movie Reviews</h3>

            <div class="review-summary">
                <strong>{{ $reviewCount }} review{{ $reviewCount === 1 ? '' : 's' }}</strong>
                @if($reviewCount)
                    <span>Average rating: {{ number_format($averageRating, 1) }} / 5</span>
                @else
                    <span>No reviews yet. Be the first to review this movie.</span>
                @endif
            </div>

            @if(session('success'))
                <div class="alert alert-success text-dark" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger text-dark" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            @auth
                <form method="POST" action="{{ route('movies.reviews.store', $movie) }}" class="review-form">
                    @csrf
                    <div>
                        <label for="rating">Your rating</label>
                        <select id="rating" name="rating" required>
                            <option value="">Select rating</option>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} star{{ $i === 1 ? '' : 's' }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="comment">Your review</label>
                        <textarea id="comment" name="comment" rows="4" required>{{ old('comment') }}</textarea>
                    </div>
                    <button type="submit">Submit review</button>
                </form>
            @else
                <p style="color: var(--text);">Please <a href="{{ route('login') }}">login</a> to write a review.</p>
            @endauth

            @foreach($reviews as $review)
                <div class="review-item">
                    <div class="review-rating">
                        @for($star = 1; $star <= 5; $star++)
                            <i class="bi bi-star-fill" style="opacity: {{ $star <= $review->rating ? '1' : '0.25' }}"></i>
                        @endfor
                    </div>
                    <div class="review-author">By {{ $review->user->name ?? 'Anonymous' }}</div>
                    <div class="review-comment">{{ $review->comment }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>