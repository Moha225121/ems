<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div>
                <h2 class="text-2xl font-semibold">{{ app()->getLocale() === 'ar' ? 'تفاصيل الحجز' : 'Reservation Details' }}</h2>
                <p class="text-sm text-slate-200/80">#{{ $reservation->id }}</p>
            </div>
            <a href="{{ route('reservations.index') }}" class="pill-btn bg-white/10 border border-white/20 text-white px-4 py-2 hover:bg-white/20">
                {{ app()->getLocale() === 'ar' ? 'كل الحجوزات' : 'All Reservations' }}
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="glass-panel rounded-2xl p-6 border border-white/10 text-white">
            <h3 class="text-lg font-semibold mb-4">{{ app()->getLocale() === 'ar' ? 'البيانات' : 'Info' }}</h3>

            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-slate-300">{{ app()->getLocale() === 'ar' ? 'المعدة' : 'Equipment' }}</dt>
                    <dd class="font-semibold">{{ $reservation->equipment->name ?? '—' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-300">{{ app()->getLocale() === 'ar' ? 'المستخدم' : 'User' }}</dt>
                    <dd class="font-semibold">{{ $reservation->user->name ?? '—' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-300">{{ app()->getLocale() === 'ar' ? 'التاريخ' : 'Date' }}</dt>
                    <dd class="font-semibold">{{ $reservation->date }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-300">{{ app()->getLocale() === 'ar' ? 'الوقت' : 'Time' }}</dt>
                    <dd class="font-semibold">{{ $reservation->time }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-300">{{ __('app.status') }}</dt>
                    <dd class="font-semibold">
                        @if($reservation->status === 'active')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-200 text-xs">✔ {{ app()->getLocale() === 'ar' ? 'نشط' : 'Active' }}</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-rose-500/15 text-rose-200 text-xs">✖ {{ app()->getLocale() === 'ar' ? 'ملغى' : 'Cancelled' }}</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-slate-300 mb-1">{{ app()->getLocale() === 'ar' ? 'ملاحظة' : 'Note' }}</dt>
                    <dd class="font-normal text-slate-100/90">{{ $reservation->note ?: '—' }}</dd>
                </div>
            </dl>

            @if($reservation->status === 'active')
                <form method="POST" action="{{ route('reservations.cancel', $reservation->id) }}" class="mt-6" x-data @submit.prevent=" if(confirm('{{ app()->getLocale()==='ar' ? 'إلغاء هذا الحجز؟' : 'Cancel this reservation?' }}')) $el.submit(); ">
                    @csrf
                    <button class="pill-btn px-4 py-2 bg-amber-500 text-slate-900 font-semibold">{{ app()->getLocale() === 'ar' ? 'إلغاء الحجز' : 'Cancel Reservation' }}</button>
                </form>
            @endif
        </div>

        <div class="glass-panel rounded-2xl p-6 border border-white/10 text-white">
            <h3 class="text-lg font-semibold mb-4">{{ app()->getLocale() === 'ar' ? 'المعدة' : 'Equipment' }}</h3>
            <div class="text-sm space-y-2">
                <p><span class="text-slate-300">{{ app()->getLocale() === 'ar' ? 'الاسم:' : 'Name:' }}</span> <span class="font-semibold">{{ $reservation->equipment->name ?? '—' }}</span></p>
                <p><span class="text-slate-300">{{ app()->getLocale() === 'ar' ? 'النوع:' : 'Type:' }}</span> <span class="font-semibold">{{ $reservation->equipment->type ?? '—' }}</span></p>
                <p><span class="text-slate-300">{{ app()->getLocale() === 'ar' ? 'حالة المعدة:' : 'Equipment Status:' }}</span> <span class="font-semibold">{{ $reservation->equipment->status ?? '—' }}</span></p>
            </div>
        </div>
    </div>

</x-app-layout>
