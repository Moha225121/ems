<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function usageForm()
    {
        return view('reports.usage');
    }

    public function usageResult(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to'   => 'required|date|after_or_equal:from',
        ]);

        $transactions = Transaction::with(['equipment', 'user'])
            ->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to . ' 23:59:59',
            ])
            ->latest()
            ->get();

        return view('reports.usage', [
            'transactions' => $transactions,
            'from' => $request->from,
            'to'   => $request->to,
        ]);
    }
}
