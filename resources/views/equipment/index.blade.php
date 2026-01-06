<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div>
                <h2 class="text-2xl font-semibold">{{ __('app.equipment') }}</h2>
                <p class="text-sm text-slate-200/80">{{ app()->getLocale() === 'ar' ? 'إدارة المخزون والحجوزات' : 'Manage inventory and reservations' }}</p>
            </div>
            <a href="{{ route('equipment.create') }}"
               class="pill-btn bg-gradient-to-r from-indigo-500 to-cyan-400 text-slate-900 font-semibold px-4 py-2 shadow-lg">
                {{ __('app.add_equipment') }}
            </a>
        </div>
    </x-slot>

    <div class="glass-panel rounded-3xl border border-white/10 p-6">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-slate-100/90">
                <thead class="bg-white/5 text-left uppercase text-xs tracking-wide">
                    <tr class="text-slate-200">
                        <th class="px-4 py-3 font-semibold">#</th>
                        <th class="px-4 py-3 font-semibold">{{ app()->getLocale() === 'ar' ? 'اسم المعدة' : 'Name' }}</th>
                        <th class="px-4 py-3 font-semibold">{{ app()->getLocale() === 'ar' ? 'النوع' : 'Type' }}</th>
                        <th class="px-4 py-3 font-semibold">{{ __('app.status') }}</th>
                        <th class="px-4 py-3 text-center font-semibold">{{ app()->getLocale() === 'ar' ? 'إجراءات' : 'Actions' }}</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/5">
                    @forelse($equipment as $item)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-semibold text-white">{{ $item->name }}</td>
                            <td class="px-4 py-3">{{ $item->type ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if($item->status === 'available')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-200 text-xs">✔ {{ __('app.available') }}</span>
                                @elseif($item->status === 'reserved')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-500/15 text-amber-200 text-xs">⏳ {{ __('app.reserved') }}</span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-rose-500/15 text-rose-200 text-xs">❌ {{ __('app.checked_out') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center space-x-2">
                                @if($item->status === 'available')
                                    <div x-data="{ open: false }" class="inline">
                                        <button @click="open = true" class="pill-btn px-3 py-1 bg-amber-500 text-slate-900 font-semibold">{{ __('app.reserve') }}</button>

                                        <!-- Modal -->
                                        <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center">
                                            <div class="absolute inset-0 bg-black/50" @click="open = false"></div>
                                            <div class="relative w-full max-w-md mx-auto glass-panel rounded-2xl border border-white/10 p-6 text-white">
                                                <div class="flex items-center justify-between mb-4">
                                                    <h3 class="text-lg font-semibold">{{ app()->getLocale()==='ar' ? 'حجز المعدة' : 'Reserve Equipment' }} — {{ $item->name }}</h3>
                                                    <button class="text-slate-300 hover:text-white" @click="open = false">✖</button>
                                                </div>
                                                <form method="POST" action="{{ route('equipment.reserve', $item->id) }}" class="space-y-4">
                                                    @csrf
                                                    <div>
                                                        <label class="block text-sm mb-1">{{ app()->getLocale()==='ar' ? 'التاريخ' : 'Date' }}</label>
                                                        <input type="date" name="date" value="{{ now()->toDateString() }}" class="w-full bg-white/5 border border-white/10 rounded px-3 py-2 text-white" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm mb-1">{{ app()->getLocale()==='ar' ? 'الوقت' : 'Time' }}</label>
                                                        <input type="time" name="time" value="{{ now()->format('H:i') }}" class="w-full bg-white/5 border border-white/10 rounded px-3 py-2 text-white" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm mb-1">{{ app()->getLocale()==='ar' ? 'ملاحظة' : 'Note' }}</label>
                                                        <textarea name="note" rows="3" placeholder="{{ app()->getLocale()==='ar' ? 'معلومة إضافية اختيارية' : 'Optional additional info' }}" class="w-full bg-white/5 border border-white/10 rounded px-3 py-2 text-white"></textarea>
                                                    </div>
                                                    <div class="flex items-center justify-end gap-2">
                                                        <button type="button" @click="open = false" class="pill-btn px-4 py-2 bg-white/10 border border-white/20">{{ app()->getLocale()==='ar' ? 'إلغاء' : 'Cancel' }}</button>
                                                        <button class="pill-btn px-4 py-2 bg-gradient-to-r from-indigo-500 to-cyan-400 text-slate-900 font-semibold">{{ __('app.reserve') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($item->status === 'available' || $item->status === 'reserved')
                                    <form method="POST" action="{{ route('equipment.checkOut', $item->id) }}" class="inline" x-data @submit.prevent=" if(confirm('{{ app()->getLocale()==='ar' ? 'هل أنت متأكد من الاستلام؟' : 'Confirm check out?' }}')) $el.submit(); ">
                                        @csrf
                                        <button class="pill-btn px-3 py-1 bg-rose-500 text-white font-semibold">{{ __('app.check_out') }}</button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('equipment.checkIn', $item->id) }}" class="inline" x-data @submit.prevent=" if(confirm('{{ app()->getLocale()==='ar' ? 'هل أنت متأكد من الإرجاع؟' : 'Confirm check in?' }}')) $el.submit(); ">
                                    @csrf
                                    <input type="text" name="note" placeholder="{{ app()->getLocale()==='ar' ? 'ملاحظة' : 'Note' }}" class="bg-white/5 border border-white/10 rounded px-2 py-1 text-xs text-white placeholder:text-slate-300/70 mr-1">
                                    <button class="pill-btn px-3 py-1 bg-emerald-500 text-slate-900 font-semibold">{{ __('app.check_in') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-slate-200/70">
                                {{ app()->getLocale() === 'ar' ? 'لا توجد معدات' : 'No equipment found' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</x-app-layout>
