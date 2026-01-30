<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold">
            {{ __('app.reports') }}
        </h2>
    </x-slot>

    <!-- Date Filter -->
    <div class="glass-panel p-6 rounded-3xl border border-white/10 mb-6">
        <form method="GET" action="{{ route('reports.usageResult') }}"
              class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">

            <div>
                <label class="block text-sm mb-1 opacity-70">
                    {{ app()->getLocale() === 'ar' ? 'من تاريخ' : 'From Date' }}
                </label>
                <input type="date" name="from"
                       value="{{ $from ?? '' }}"
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:border-indigo-500/50"
                       required>
            </div>

            <div>
                <label class="block text-sm mb-1 opacity-70">
                    {{ app()->getLocale() === 'ar' ? 'إلى تاريخ' : 'To Date' }}
                </label>
                <input type="date" name="to"
                       value="{{ $to ?? '' }}"
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:border-indigo-500/50"
                       required>
            </div>

            <button
                class="pill-btn bg-gradient-to-r from-indigo-500 to-cyan-400 text-slate-900 font-semibold px-6 py-2 shadow-lg">
                {{ app()->getLocale() === 'ar' ? 'عرض التقرير' : 'Show Report' }}
            </button>
        </form>
    </div>

    <!-- Results -->
    @isset($transactions)
        <div class="glass-panel p-6 rounded-3xl border border-white/10">
            <div class="overflow-x-auto">
                <table class="eems-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'المعدة' : 'Equipment' }}</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'العملية' : 'Action' }}</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'بواسطة' : 'By' }}</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'ملاحظة' : 'Note' }}</th>
                            <th>{{ app()->getLocale() === 'ar' ? 'التاريخ' : 'Date' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $t)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-semibold text-indigo-400">{{ $t->equipment->name }}</td>
                                <td>
                                    @if($t->action === 'check_out')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-rose-500/15 text-rose-300 text-xs">
                                            {{ app()->getLocale() === 'ar' ? 'استلام' : 'Check Out' }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-300 text-xs">
                                            {{ app()->getLocale() === 'ar' ? 'إرجاع' : 'Check In' }}
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $t->user->name }}</td>
                                <td class="text-slate-400 text-xs italic">{{ $t->note ?? '-' }}</td>
                                <td class="text-slate-300 text-sm">
                                    {{ $t->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 text-slate-400">
                                    <div class="flex flex-col items-center gap-2 opacity-60">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'لا توجد سجلات' : 'No records found' }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endisset

</x-app-layout>
