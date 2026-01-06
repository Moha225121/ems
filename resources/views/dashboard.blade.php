<x-app-layout>

    {{-- Page Header --}}
    <x-slot name="header">
        <div class="flex items-center gap-3 text-white">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 border border-white/10 text-lg font-semibold">📊</span>
            <div>
                <h2 class="text-2xl font-semibold">{{ __('app.dashboard') }}</h2>
                <p class="text-sm text-slate-200/80">{{ app()->getLocale() === 'ar' ? 'نظرة عامة على الحالة الحالية' : 'At-a-glance equipment health' }}</p>
            </div>
        </div>
    </x-slot>

    {{-- Content --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Available Equipment --}}
        <div class="glass-panel rounded-2xl p-6 border border-white/10">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-slate-200/80">{{ __('app.available') }}</p>
                    <p class="text-3xl font-bold text-white">{{ $availableCount ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-2xl">✔</div>
            </div>
        </div>

        {{-- Reserved Equipment --}}
        <div class="glass-panel rounded-2xl p-6 border border-white/10">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-slate-200/80">{{ __('app.reserved') }}</p>
                    <p class="text-3xl font-bold text-white">{{ $reservedCount ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-amber-500/20 text-amber-300 flex items-center justify-center text-2xl">⏳</div>
            </div>
        </div>

        {{-- Checked Out Equipment --}}
        <div class="glass-panel rounded-2xl p-6 border border-white/10">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-slate-200/80">{{ __('app.checked_out') }}</p>
                    <p class="text-3xl font-bold text-white">{{ $checkedOutCount ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-rose-500/20 text-rose-300 flex items-center justify-center text-2xl">✖</div>
            </div>
        </div>

    </div>

    {{-- Quick Actions --}}
    <div class="mt-10 grid grid-cols-1 md:grid-cols-4 gap-6">

        {{-- Equipment --}}
        <a href="{{ route('equipment.index') }}" class="glass-panel border border-white/10 rounded-2xl p-6 hover:border-white/20 transition">
            <h3 class="text-lg font-semibold text-white mb-2">{{ __('app.equipment') }}</h3>
            <p class="text-sm text-slate-200/80">
                {{ app()->getLocale() === 'ar'
                    ? 'إدارة المعدات والحالة والحجوزات'
                    : 'Manage equipment, status and reservations' }}
            </p>
        </a>

        {{-- Reservations --}}
        <a href="{{ route('reservations.index') }}" class="glass-panel border border-white/10 rounded-2xl p-6 hover:border-white/20 transition">
            <h3 class="text-lg font-semibold text-white mb-2">{{ app()->getLocale() === 'ar' ? 'الحجوزات' : 'Reservations' }}</h3>
            <p class="text-sm text-slate-200/80">
                {{ app()->getLocale() === 'ar'
                    ? 'عرض وإدارة طلبات الحجز'
                    : 'View and manage reservation requests' }}
            </p>
        </a>

        {{-- Reports --}}
        <a href="{{ route('reports.usageForm') }}" class="glass-panel border border-white/10 rounded-2xl p-6 hover:border-white/20 transition">
            <h3 class="text-lg font-semibold text-white mb-2">{{ __('app.reports') }}</h3>
            <p class="text-sm text-slate-200/80">
                {{ app()->getLocale() === 'ar'
                    ? 'عرض تقارير الاستخدام وسجل العمليات'
                    : 'View usage reports and history logs' }}
            </p>
        </a>

        {{-- Add Equipment --}}
        <a href="{{ route('equipment.create') }}" class="glass-panel border border-white/10 rounded-2xl p-6 hover:border-white/20 transition">
            <h3 class="text-lg font-semibold text-white mb-2">{{ __('app.add_equipment') }}</h3>
            <p class="text-sm text-slate-200/80">
                {{ app()->getLocale() === 'ar'
                    ? 'إضافة معدات جديدة للنظام'
                    : 'Add new equipment to the system' }}
            </p>
        </a>

    </div>

</x-app-layout>
