<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        return view('equipment.index', [
            'equipment' => Equipment::latest()->get()
        ]);
    }

    public function create()
    {
        return view('equipment.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
        ]);

        Equipment::create([
            'name'   => $validated['name'],
            'type'   => $validated['type'] ?? null,
            'status' => 'available',
        ]);

        return redirect()
            ->route('equipment.index')
            ->with(
                'success',
                app()->getLocale() === 'ar'
                    ? 'تمت إضافة المعدة بنجاح'
                    : 'Equipment added successfully'
            );
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return redirect()
            ->route('equipment.index')
            ->with(
                'success',
                app()->getLocale() === 'ar'
                    ? 'تم حذف المعدة بنجاح'
                    : 'Equipment deleted successfully'
            );
    }
}
