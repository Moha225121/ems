<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold">
            {{ __('app.reports') }}
        </h2>
    </x-slot>

    <!-- Date Filter -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <form method="GET" action="{{ route('reports.usageResult') }}"
              class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

            <div>
                <label class="block text-sm mb-1">
                    {{ app()->getLocale() === 'ar' ? 'من تاريخ' : 'From Date' }}
                </label>
                <input type="date" name="from"
                       value="{{ $from ?? '' }}"
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>

            <div>
                <label class="block text-sm mb-1">
                    {{ app()->getLocale() === 'ar' ? 'إلى تاريخ' : 'To Date' }}
                </label>
                <input type="date" name="to"
                       value="{{ $to ?? '' }}"
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>

            <button
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                {{ app()->getLocale() === 'ar' ? 'عرض التقرير' : 'Show Report' }}
            </button>
        </form>
    </div>

    <!-- Results -->
    @isset($transactions)
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="overflow-x-auto">
                <table class="min-w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 text-left">#</th>
                            <th class="px-3 py-2 text-left">
                                {{ app()->getLocale() === 'ar' ? 'المعدة' : 'Equipment' }}
                            </th>
                            <th class="px-3 py-2 text-left">
                                {{ app()->getLocale() === 'ar' ? 'العملية' : 'Action' }}
                            </th>
                            <th class="px-3 py-2 text-left">
                                {{ app()->getLocale() === 'ar' ? 'بواسطة' : 'By' }}
                            </th>
                            <th class="px-3 py-2 text-left">
                                {{ app()->getLocale() === 'ar' ? 'ملاحظة' : 'Note' }}
                            </th>
                            <th class="px-3 py-2 text-left">
                                {{ app()->getLocale() === 'ar' ? 'التاريخ' : 'Date' }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $t)
                            <tr class="border-t">
                                <td class="px-3 py-2">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2">{{ $t->equipment->name }}</td>
                                <td class="px-3 py-2">
                                    @if($t->action === 'check_out')
                                        <span class="text-red-600 font-semibold">
                                            {{ app()->getLocale() === 'ar' ? 'استلام' : 'Check Out' }}
                                        </span>
                                    @else
                                        <span class="text-green-600 font-semibold">
                                            {{ app()->getLocale() === 'ar' ? 'إرجاع' : 'Check In' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-2">{{ $t->user->name }}</td>
                                <td class="px-3 py-2">{{ $t->note ?? '-' }}</td>
                                <td class="px-3 py-2">
                                    {{ $t->created_at->format('Y-m-d H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-500">
                                    {{ app()->getLocale() === 'ar'
                                        ? 'لا توجد نتائج'
                                        : 'No records found'
                                    }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endisset

</x-app-layout>
