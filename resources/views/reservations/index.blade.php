<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div>
                <h2 class="text-2xl font-semibold">{{ app()->getLocale() === 'ar' ? 'الحجوزات' : 'Reservations' }}</h2>
                <p class="text-sm text-slate-200/80">{{ app()->getLocale() === 'ar' ? 'تتبع حالة الحجوزات وإدارتها' : 'Track and manage reservation status' }}</p>
            </div>
            <a href="{{ route('equipment.index') }}" class="pill-btn bg-white/10 border border-white/20 text-white px-4 py-2 hover:bg-white/20">
                {{ app()->getLocale() === 'ar' ? 'العودة للمعدات' : 'Back to Equipment' }}
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="glass-panel rounded-2xl p-4 border border-white/10 flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-200/80">{{ app()->getLocale() === 'ar' ? 'نشطة' : 'Active' }}</p>
                <p class="text-3xl font-bold text-white">{{ $stats['active'] ?? 0 }}</p>
            </div>
            <span class="h-12 w-12 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-2xl">✔</span>
        </div>
        <div class="glass-panel rounded-2xl p-4 border border-white/10 flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-200/80">{{ app()->getLocale() === 'ar' ? 'ملغاة' : 'Cancelled' }}</p>
                <p class="text-3xl font-bold text-white">{{ $stats['cancelled'] ?? 0 }}</p>
            </div>
            <span class="h-12 w-12 rounded-xl bg-rose-500/20 text-rose-300 flex items-center justify-center text-2xl">✖</span>
        </div>
    </div>

    <div class="glass-panel rounded-3xl border border-white/10 p-6">
        <div class="flex items-center justify-between mb-4 text-white">
            <div>
                <h3 class="text-lg font-semibold">{{ app()->getLocale() === 'ar' ? 'سجل الحجوزات' : 'Reservation Log' }}</h3>
                <p class="text-sm text-slate-200/80">{{ app()->getLocale() === 'ar' ? 'أحدث الحجوزات بترتيب زمني' : 'Latest reservations in chronological order' }}</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-slate-100/90">
                <thead class="bg-white/5 text-left uppercase text-xs tracking-wide">
                    <tr class="text-slate-200">
                        <th class="px-4 py-3 font-semibold">#</th>
                        <th class="px-4 py-3 font-semibold">{{ app()->getLocale() === 'ar' ? 'المعدة' : 'Equipment' }}</th>
                        <th class="px-4 py-3 font-semibold">{{ app()->getLocale() === 'ar' ? 'المستخدم' : 'User' }}</th>
                        <th class="px-4 py-3 font-semibold">{{ app()->getLocale() === 'ar' ? 'الوقت' : 'Date & Time' }}</th>
                        <th class="px-4 py-3 font-semibold">{{ __('app.status') }}</th>
                        <th class="px-4 py-3 font-semibold">{{ app()->getLocale() === 'ar' ? 'ملاحظة' : 'Note' }}</th>
                        <th class="px-4 py-3 text-center font-semibold">{{ app()->getLocale() === 'ar' ? 'إجراء' : 'Action' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($reservations as $reservation)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-4 py-3">{{ $reservations->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3 font-semibold text-white">
                                <a href="{{ route('reservations.show', $reservation->id) }}" class="hover:underline">
                                    {{ $reservation->equipment->name ?? '—' }}
                                </a>
                            </td>
                            <td class="px-4 py-3">{{ $reservation->user->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                {{ \Illuminate\Support\Carbon::parse($reservation->date.' '.$reservation->time)->format('Y-m-d H:i') }}
                            </td>
                            <td class="px-4 py-3">
                                @if($reservation->status === 'active')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-200 text-xs">✔ {{ app()->getLocale() === 'ar' ? 'نشط' : 'Active' }}</span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-rose-500/15 text-rose-200 text-xs">✖ {{ app()->getLocale() === 'ar' ? 'ملغى' : 'Cancelled' }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-100/80">
                                {{ $reservation->note ? \Illuminate\Support\Str::limit($reservation->note, 40) : '—' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($reservation->status === 'active')
                                    <form method="POST" action="{{ route('reservations.cancel', $reservation->id) }}" class="inline" x-data @submit.prevent=" if(confirm('{{ app()->getLocale()==='ar' ? 'إلغاء هذا الحجز؟' : 'Cancel this reservation?' }}')) $el.submit(); ">
                                        @csrf
                                        <button class="pill-btn px-3 py-1 bg-amber-500 text-slate-900 font-semibold">{{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}</button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-300">{{ app()->getLocale() === 'ar' ? 'لا يوجد إجراء' : 'No action' }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-slate-200/70">
                                {{ app()->getLocale() === 'ar' ? 'لا توجد حجوزات بعد' : 'No reservations yet' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reservations->hasPages())
            <div class="mt-6">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>

</x-app-layout>
