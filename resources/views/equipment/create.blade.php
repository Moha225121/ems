<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center gap-3 text-white">
            <span class="h-10 w-10 rounded-2xl bg-white/10 border border-white/10 flex items-center justify-center">➕</span>
            <div>
                <h2 class="text-2xl font-semibold">{{ __('app.add_equipment') }}</h2>
                <p class="text-sm text-slate-200/80">{{ app()->getLocale() === 'ar' ? 'إضافة معدة جديدة للنظام' : 'Add a new piece of equipment' }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl glass-panel rounded-3xl border border-white/10 p-6">

        <form method="POST" action="{{ route('equipment.store') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label class="block text-sm text-slate-200/80 mb-1">
                    {{ app()->getLocale() === 'ar' ? 'اسم المعدة' : 'Equipment Name' }}
                </label>
                <input
                    type="text"
                    name="name"
                    required
                    class="w-full rounded-xl bg-white/5 border border-white/10 px-3 py-2 text-white placeholder:text-slate-300/70 focus:border-cyan-300 focus:outline-none"
                >
            </div>

            <!-- Type -->
            <div>
                <label class="block text-sm text-slate-200/80 mb-1">
                    {{ app()->getLocale() === 'ar' ? 'النوع' : 'Type' }}
                </label>
                <input
                    type="text"
                    name="type"
                    class="w-full rounded-xl bg-white/5 border border-white/10 px-3 py-2 text-white placeholder:text-slate-300/70 focus:border-cyan-300 focus:outline-none"
                >
            </div>

            <!-- Buttons -->
            <div class="flex gap-3">
                <button
                    type="submit"
                    class="pill-btn bg-gradient-to-r from-indigo-500 to-cyan-400 text-slate-900 font-semibold px-5 py-2 shadow-lg">
                    {{ app()->getLocale() === 'ar' ? 'حفظ' : 'Save' }}
                </button>

                <a href="{{ route('equipment.index') }}"
                   class="pill-btn px-5 py-2 border border-white/15 text-white hover:border-white/30">
                    {{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}
                </a>
            </div>

        </form>

    </div>

</x-app-layout>
