<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function checkOut(Equipment $equipment)
    {
        if ($equipment->status === 'checked_out') {
            return back()->withErrors(
                app()->getLocale() === 'ar'
                    ? 'المعدة قيد الاستخدام'
                    : 'Equipment already checked out'
            );
        }

        Transaction::create([
            'equipment_id' => $equipment->id,
            'user_id'      => auth()->id(),
            'action'       => 'check_out',
            'note'         => null,
        ]);

        $equipment->update([
            'status' => 'checked_out',
        ]);

        return back()->with(
            'success',
            app()->getLocale() === 'ar'
            ? 'تمت العملية بنجاح'
            : 'Operation completed successfully'
        );

    }

    public function checkIn(Request $request, Equipment $equipment)
    {
        $request->validate([
            'note' => 'nullable|string|max:500',
        ]);

        Transaction::create([
            'equipment_id' => $equipment->id,
            'user_id'      => auth()->id(),
            'action'       => 'check_in',
            'note'         => $request->note,
        ]);

        $equipment->update([
            'status' => 'available',
        ]);

        return back()->with(
            'success',
            app()->getLocale() === 'ar'
                ? 'تمت العملية بنجاح'
                : 'Operation completed successfully'
        );
    }
}
