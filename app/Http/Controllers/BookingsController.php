<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Bookings_seats;
use App\Models\Payments;
use App\Models\Tickets;
use App\Models\Showtimes;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Bookings::with('showtime.movie', 'showtime.hall.cinema', 'bookings_seats.seat', 'payment', 'tickets')
            ->where('user_id', auth()->id())
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $showtimeId = $request->query('showtime');
        $showtime = \App\Models\Showtimes::with('hall.seats', 'movie')->findOrFail($showtimeId);
        $seats = $showtime->hall->seats;

        // Get already booked seats for this showtime
        $bookedSeatIds = Bookings_seats::whereHas('booking', function ($query) use ($showtimeId) {
            $query->where('showtime_id', $showtimeId)
                ->whereHas('payment', function ($paymentQuery) {
                    $paymentQuery->where('status', 'paid');
                });
        })->pluck('seat_id')->toArray();

        return view('bookings.create', compact('showtime', 'seats', 'bookedSeatIds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats' => 'required|array|min:1',
            'seats.*' => 'exists:seats,id',
        ]);

        $showtime = Showtimes::findOrFail($request->showtime_id);

        // Check if any selected seats are already booked for this showtime
        $bookedSeats = Bookings_seats::whereIn('seat_id', $request->seats)
            ->whereHas('booking', function ($query) use ($request) {
                $query->where('showtime_id', $request->showtime_id)
                    ->whereHas('payment', function ($paymentQuery) {
                        $paymentQuery->where('status', 'paid');
                    });
            })
            ->with('seat')
            ->get();

        if ($bookedSeats->isNotEmpty()) {
            $seatNumbers = $bookedSeats->map(fn($bs) => $bs->seat->row_number . $bs->seat->number)->implode(', ');
            return back()->withErrors(['seats' => "The following seats are already booked: $seatNumbers. Please select different seats."]);
        }

        $booking = Bookings::create([
            'user_id' => auth()->id(),
            'showtime_id' => $request->showtime_id,
            'date' => now(),
            'status' => 'pending',
        ]);

        $totalPrice = 0;
        foreach ($request->seats as $seatId) {
            Bookings_seats::create([
                'booking_id' => $booking->id,
                'seat_id' => $seatId,
            ]);
            $totalPrice += $showtime->price;
        }

        $booking->payment()->create([
            'amount' => $totalPrice,
            'method' => 'online',
            'status' => 'pending',
            'date' => now(),
        ]);

        return redirect()->route('bookings.show', $booking);
    }

    public function show(Bookings $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load('showtime.movie', 'showtime.hall.cinema', 'bookings_seats.seat', 'payment', 'tickets.seat');
        return view('bookings.show', compact('booking'));
    }

    public function pay(Request $request, Bookings $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load('payment', 'bookings_seats');

        if (! $booking->payment) {
            return back()->with('error', 'Payment record not found.');
        }

        if ($booking->payment->status !== 'pending') {
            return back()->with('info', 'This booking is already paid.');
        }

        $booking->payment->update(['status' => 'paid']);
        $booking->update(['status' => 'confirmed']);

        // Generate tickets for each booked seat
        foreach ($booking->bookings_seats as $bookedSeat) {
            $ticketCode = strtoupper(uniqid('TK')) . rand(1000, 9999);
            Tickets::create([
                'booking_id' => $booking->id,
                'seat_id' => $bookedSeat->seat_id,
                'code' => $ticketCode,
                'issued_at' => now(),
            ]);
        }

        return back()->with('success', 'Payment successful. Your booking is now confirmed.');
    }

    public function cancel(Request $request, Bookings $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status === 'canceled') {
            return back()->with('info', 'This booking has already been canceled.');
        }

        $booking->update(['status' => 'canceled']);

        if ($booking->payment) {
            $booking->payment->update(['status' => 'canceled']);
        }

        return back()->with('success', 'Your booking has been canceled.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bookings $bookings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bookings $bookings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookings $bookings)
    {
        //
    }
}
