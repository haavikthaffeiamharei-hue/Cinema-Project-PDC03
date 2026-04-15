<?php

namespace App\Http\Controllers;

use App\Models\Movies;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');

        $query = Movies::with('genre')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('genre', function ($genreQuery) use ($search) {
                      $genreQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $movies = $query->get();
        return view('movies.index', compact('movies', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Movies $movie)
    {
        $showtimes = $movie->showtimes()->with('hall.cinema')->get();
        $reviews = $movie->reviews()->with('user')->latest()->get();
        $averageRating = $movie->reviews()->avg('rating');
        $reviewCount = $movie->reviews()->count();

        return view('movies.show', compact('movie', 'showtimes', 'reviews', 'averageRating', 'reviewCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movies $movies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movies $movies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movies $movies)
    {
        //
    }
}
