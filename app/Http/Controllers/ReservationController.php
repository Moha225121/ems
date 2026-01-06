<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function store(Request $request, Equipment $equipment)
    {
        if ($equipment->status !== 'available') {
            return back()->withErrors(
                app()->getLocale() === 'ar'
                    ? 'المعدة غير متاحة للحجز'
                    : 'Equipment is not available'
            );
        }

        $data = $request->validate([
            'date' => ['required','date','after_or_equal:today'],
            'time' => ['required','date_format:H:i'],
            'note' => ['nullable','string','max:500'],
        ]);

        Reservation::create([
            'equipment_id' => $equipment->id,
            'user_id'      => auth()->id(),
            'date'         => $data['date'],
            'time'         => $data['time'],
            'note'         => $data['note'] ?? null,
            'status'       => 'active',
        ]);

        $equipment->update([
            'status' => 'reserved',
        ]);

        return back()->with(
            'success',
            app()->getLocale() === 'ar'
            ? 'تم الحجز بنجاح'
            : 'Reserved successfully'
        );
    }

    public function index()
    {
        $reservations = Reservation::with(['equipment', 'user'])
            ->latest()
            ->paginate(10);

        $stats = [
            'active'    => Reservation::where('status', 'active')->count(),
            'cancelled' => Reservation::where('status', 'cancelled')->count(),
        ];

        return view('reservations.index', compact('reservations', 'stats'));
    }

    public function cancel(Reservation $reservation)
    {
        $reservation->update(['status' => 'cancelled']);

        $reservation->equipment->update([
            'status' => 'available',
        ]);

        return back()->with(
            'success',
            app()->getLocale() === 'ar'
            ? 'تم  إلغاء الحجز بنجاح'
            : 'Reservation cancelled successfully'
        );
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['equipment','user']);
        return view('reservations.show', compact('reservation'));
    }
}
