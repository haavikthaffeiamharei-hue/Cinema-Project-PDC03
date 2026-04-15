<?php

namespace Database\Seeders;

use App\Models\Bookings;
use App\Models\Bookings_seats;
use App\Models\Cinemas;
use App\Models\Genres;
use App\Models\Halls;
use App\Models\Movies;
use App\Models\Payments;
use App\Models\Roles;
use App\Models\Seats;
use App\Models\Showtimes;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Roles::firstOrCreate(['name' => 'admin']);
        $customerRole = Roles::firstOrCreate(['name' => 'customer']);

        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@cinemax.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        // Create test customer
        User::firstOrCreate(
            ['email' => 'customer@cinemax.com'],
            [
                'name' => 'Test Customer',
                'password' => Hash::make('password'),
                'role_id' => $customerRole->id,
            ]
        );

        // Create genres
        $genres = [
            ['name' => 'Action'],
            ['name' => 'Adventure'],
            ['name' => 'Comedy'],
            ['name' => 'Drama'],
            ['name' => 'Fantasy'],
            ['name' => 'Horror'],
            ['name' => 'Romance'],
            ['name' => 'Sci-Fi'],
            ['name' => 'Thriller'],
            ['name' => 'Animation'],
        ];

        foreach ($genres as $genre) {
            Genres::firstOrCreate($genre);
        }

        // Create cinemas
        $cinemas = [
            ['name' => 'CineMax Downtown', 'location' => '123 Main St, City Center'],
            ['name' => 'CineMax Mall', 'location' => '456 Shopping Plaza, Mall Level 3'],
            ['name' => 'CineMax Luxury', 'location' => '789 Premium Ave, Uptown'],
        ];

        foreach ($cinemas as $cinema) {
            Cinemas::firstOrCreate($cinema);
        }

        // Create halls for each cinema
        $cinemas = Cinemas::all();
        foreach ($cinemas as $cinema) {
            for ($i = 1; $i <= 3; $i++) {
                Halls::firstOrCreate([
                    'name' => "Hall {$i}",
                    'cinema_id' => $cinema->id,
                    'capacity' => 100,
                ]);
            }
        }

        // Create seats for each hall (10x10 grid)
        $halls = Halls::all();
        foreach ($halls as $hall) {
            for ($row = 1; $row <= 10; $row++) {
                $rowLetter = chr(64 + $row); // A, B, C, etc.
                for ($number = 1; $number <= 10; $number++) {
                    Seats::firstOrCreate([
                        'hall_id' => $hall->id,
                        'row_number' => $rowLetter,
                        'number' => $number,
                    ]);
                }
            }
        }

        // Create movies with posters
        $movies = [
            [
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'description' => 'An orphaned boy enrolls in a school of wizardry, where he learns the truth about himself, his family and the terrible evil that haunts the magical world.',
                'genre_id' => Genres::where('name', 'Fantasy')->first()->id,
                'duration' => 152,
                'release_date' => '2001-11-16',
                'poster' => 'https://upload.wikimedia.org/wikipedia/en/a/a7/Harry_Potter_Philosopher%27s_Stone.jpg',
            ],
            [
                'title' => 'The Dark Knight',
                'description' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
                'genre_id' => Genres::where('name', 'Action')->first()->id,
                'duration' => 152,
                'release_date' => '2008-07-18',
                'poster' => 'https://images.moviesanywhere.com/bd47f9b7d090170d79b3085804075d41/c6140695-a35f-46e2-adb7-45ed829fc0c0.jpg',
            ],
            [
                'title' => 'Inception',
                'description' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
                'genre_id' => Genres::where('name', 'Sci-Fi')->first()->id,
                'duration' => 148,
                'release_date' => '2010-07-16',
                'poster' => 'https://upload.wikimedia.org/wikipedia/en/2/2e/Inception_%282010%29_theatrical_poster.jpg',
            ],
            [
                'title' => 'The Shawshank Redemption',
                'description' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
                'genre_id' => Genres::where('name', 'Drama')->first()->id,
                'duration' => 142,
                'release_date' => '1994-09-23',
                'poster' => 'https://upload.wikimedia.org/wikipedia/en/8/81/ShawshankRedemptionMoviePoster.jpg',
            ],
            [
                'title' => 'Pulp Fiction',
                'description' => 'The lives of two mob hitmen, a boxer, a gangster and his wife intertwine in four tales of violence and redemption.',
                'genre_id' => Genres::where('name', 'Thriller')->first()->id,
                'duration' => 154,
                'release_date' => '1994-10-14',
                'poster' => 'https://upload.wikimedia.org/wikipedia/en/3/3b/Pulp_Fiction.jpg',
            ],
            [
                'title' => 'The Lord of the Rings: The Fellowship of the Ring',
                'description' => 'A meek Hobbit from the Shire and eight companions set out on a journey to destroy the powerful One Ring and save Middle-earth from the Dark Lord Sauron.',
                'genre_id' => Genres::where('name', 'Fantasy')->first()->id,
                'duration' => 178,
                'release_date' => '2001-12-19',
                'poster' => 'https://upload.wikimedia.org/wikipedia/en/8/87/Fellowshipofthering_ver4.jpg',
            ],
            [
                'title' => 'Forrest Gump',
                'description' => 'The presidencies of Kennedy and Johnson, the Vietnam War, the Watergate scandal and other historical events unfold from the perspective of an Alabama man with an IQ of 75.',
                'genre_id' => Genres::where('name', 'Drama')->first()->id,
                'duration' => 142,
                'release_date' => '1994-07-06',
                'poster' => 'https://upload.wikimedia.org/wikipedia/en/6/67/Forrest_Gump.png',
            ],
            [
                'title' => 'The Matrix',
                'description' => 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.',
                'genre_id' => Genres::where('name', 'Sci-Fi')->first()->id,
                'duration' => 136,
                'release_date' => '1999-03-31',
                'poster' => 'https://upload.wikimedia.org/wikipedia/en/c/c1/The_Matrix_Poster.jpg',
            ],
            [
                'title' => 'Titanic',
                'description' => 'A seventeen-year-old aristocrat falls in love with a kind but poor artist aboard the luxurious, ill-fated R.M.S. Titanic.',
                'genre_id' => Genres::where('name', 'Romance')->first()->id,
                'duration' => 195,
                'release_date' => '1997-12-19',
                'poster' => 'https://upload.wikimedia.org/wikipedia/en/2/2e/Titanic_%281997%29_movie_poster.jpg',
            ],
            [
                'title' => 'The Avengers',
                'description' => 'Earth\'s mightiest heroes must come together and learn to fight as a team if they are going to stop the mischievous Loki and his alien army from enslaving humanity.',
                'genre_id' => Genres::where('name', 'Action')->first()->id,
                'duration' => 143,
                'release_date' => '2012-05-04',
                'poster' => 'https://upload.wikimedia.org/wikipedia/en/f/f9/TheAvengers2012Poster.jpg',
            ],
            [
                'title' => 'Toy Story',
                'description' => 'A cowboy doll is profoundly threatened and jealous when a new spaceman figure supplants him as top toy in a boy\'s room.',
                'genre_id' => Genres::where('name', 'Animation')->first()->id,
                'duration' => 81,
                'release_date' => '1995-11-22',
                'poster' => 'https://upload.wikimedia.org/wikipedia/en/1/13/Toy_Story.jpg',
            ],
            [
                'title' => 'The Conjuring',
                'description' => 'Paranormal investigators Ed and Lorraine Warren work to help a family terrorized by a dark presence in their farmhouse.',
                'genre_id' => Genres::where('name', 'Horror')->first()->id,
                'duration' => 112,
                'release_date' => '2013-07-19',
                'poster' => 'https://upload.wikimedia.org/wikipedia/en/5/5f/The_Conjuring_poster.jpg',
            ],
        ];

        foreach ($movies as $movie) {
            Movies::updateOrCreate(
                ['title' => $movie['title']],
                $movie
            );
        }

        // Create showtimes for movies
        $movies = Movies::all();
        $halls = Halls::all();

        foreach ($movies as $movie) {
            // Create 2-3 showtimes per movie per hall
            foreach ($halls->random(min(2, $halls->count())) as $hall) {
                $startTime = now()->addDays(rand(0, 7))->setHour(rand(10, 22))->setMinute(0);
                $endTime = $startTime->copy()->addMinutes($movie->duration);

                // Set prices based on movie genre and popularity (Philippine Peso)
                $basePrice = match($movie->genre->name) {
                    'Action', 'Adventure', 'Sci-Fi', 'Fantasy' => rand(350, 450), // Blockbusters
                    'Animation' => rand(300, 400), // Family movies
                    'Drama', 'Romance', 'Comedy' => rand(250, 350), // Regular movies
                    'Horror', 'Thriller' => rand(280, 380), // Genre movies
                    default => rand(250, 350)
                };

                Showtimes::firstOrCreate([
                    'movie_id' => $movie->id,
                    'hall_id' => $hall->id,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'price' => $basePrice,
                ]);
            }
        }
    }
}
