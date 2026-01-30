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
            <table class="eems-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ app()->getLocale() === 'ar' ? 'اسم المعدة' : 'Name' }}</th>
                        <th>{{ app()->getLocale() === 'ar' ? 'النوع' : 'Type' }}</th>
                        <th>{{ __('app.status') }}</th>
                        <th class="text-center">{{ app()->getLocale() === 'ar' ? 'إجراءات' : 'Actions' }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($equipment as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="font-semibold text-indigo-400">{{ $item->name }}</td>
                            <td>{{ $item->type ?? '-' }}</td>
                            <td>
                                @if($item->status === 'available')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-200 text-xs">✔ {{ __('app.available') }}</span>
                                @elseif($item->status === 'reserved')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-500/15 text-amber-200 text-xs">⏳ {{ __('app.reserved') }}</span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-rose-500/15 text-rose-200 text-xs">❌ {{ __('app.checked_out') }}</span>
                                @endif
                            </td>
                            <td class="text-center space-x-2">
                                @if($item->status === 'available')
                                    <div x-data="{ open: false }" class="inline">
                                        <button @click="open = true" class="pill-btn px-3 py-1 bg-amber-500 text-slate-900 font-semibold">{{ __('app.reserve') }}</button>

                                        <!-- Modal -->
                                        <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
                                            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="open = false"></div>
                                            <div class="relative w-full max-w-md glass-panel rounded-3xl border border-white/10 p-6 text-white overflow-hidden">
                                                <div class="flex items-center justify-between mb-4">
                                                    <h3 class="text-lg font-semibold">{{ app()->getLocale()==='ar' ? 'حجز المعدة' : 'Reserve Equipment' }} — {{ $item->name }}</h3>
                                                    <button class="text-slate-300 hover:text-white" @click="open = false">✖</button>
                                                </div>
                                                <form method="POST" action="{{ route('equipment.reserve', $item->id) }}" class="space-y-4 text-left {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                                    @csrf
                                                    <div>
                                                        <label class="block text-sm mb-1 opacity-70">{{ app()->getLocale()==='ar' ? 'التاريخ' : 'Date' }}</label>
                                                        <input type="date" name="date" value="{{ now()->toDateString() }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:border-indigo-500/50" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm mb-1 opacity-70">{{ app()->getLocale()==='ar' ? 'الوقت' : 'Time' }}</label>
                                                        <input type="time" name="time" value="{{ now()->format('H:i') }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:border-indigo-500/50" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm mb-1 opacity-70">{{ app()->getLocale()==='ar' ? 'ملاحظة' : 'Note' }}</label>
                                                        <textarea name="note" rows="3" placeholder="{{ app()->getLocale()==='ar' ? 'معلومة إضافية اختيارية' : 'Optional additional info' }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:border-indigo-500/50"></textarea>
                                                    </div>
                                                    <div class="flex items-center justify-end gap-2 pt-2">
                                                        <button type="button" @click="open = false" class="pill-btn px-4 py-2 bg-white/10 border border-white/20 text-sm">{{ app()->getLocale()==='ar' ? 'إلغاء' : 'Cancel' }}</button>
                                                        <button class="pill-btn px-4 py-2 bg-gradient-to-r from-indigo-500 to-cyan-400 text-slate-900 font-semibold text-sm">{{ __('app.reserve') }}</button>
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
                                    <input type="text" name="note" placeholder="{{ app()->getLocale()==='ar' ? 'ملاحظة' : 'Note' }}" class="bg-white/5 border border-white/10 rounded-full px-3 py-1 text-xs text-white placeholder:text-slate-300/50 mr-1 focus:outline-none focus:border-indigo-500/50">
                                    <button class="pill-btn px-3 py-1 bg-emerald-500 text-slate-900 font-semibold">{{ __('app.check_in') }}</button>
                                </form>

                                <!-- Delete Action -->
                                <form method="POST" action="{{ route('equipment.destroy', $item->id) }}" class="inline" x-data @submit.prevent=" if(confirm('{{ app()->getLocale()==='ar' ? 'هل أنت متأكد من حذف هذه المعدة؟ لا يمكن التراجع عن هذا الإجراء.' : 'Are you sure you want to delete this equipment? This action cannot be undone.' }}')) $el.submit(); ">
                                    @csrf
                                    @method('DELETE')
                                    <button class="pill-btn px-3 py-1 bg-white/10 border border-white/10 text-rose-400 hover:bg-rose-500/20 hover:text-rose-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-slate-400">
                                <div class="flex flex-col items-center gap-2 opacity-60">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <span>{{ app()->getLocale() === 'ar' ? 'لا توجد معدات' : 'No equipment found' }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    </div>

</x-app-layout>
