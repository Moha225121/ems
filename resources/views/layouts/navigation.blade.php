<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16 items-center">

            <!-- Left: Logo / App Name -->
            <div class="flex items-center gap-6">
                <span class="text-lg font-bold text-gray-800">
                    {{ config('app.name', 'EMS') }}
                </span>

                <!-- Main Links -->
                <div class="hidden md:flex gap-4">

                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium
                       {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        {{ __('app.dashboard') }}
                    </a>

                    <a href="{{ route('equipment.index') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium
                       {{ request()->routeIs('equipment.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        {{ __('app.equipment') }}
                    </a>

                    <a href="{{ route('reports.usageForm') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium
                       {{ request()->routeIs('reports.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        {{ __('app.reports') }}
                    </a>

                </div>
            </div>

            <!-- Right: Language + User -->
            <div class="flex items-center gap-6">

                <!-- Language Switcher -->
                <div class="flex gap-2 text-sm">
                    <a href="/lang/en"
                       class="{{ app()->getLocale() === 'en' ? 'font-bold underline' : 'hover:underline' }}">
                        EN
                    </a>
                    <a href="/lang/ar"
                       class="{{ app()->getLocale() === 'ar' ? 'font-bold underline' : 'hover:underline' }}">
                        AR
                    </a>
                </div>

                <!-- User Dropdown -->
                <div class="relative">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="text-sm text-red-600 hover:underline"
                        >
                            {{ __('app.logout') }}
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="md:hidden border-t border-gray-200 px-4 py-3 space-y-2">

        <a href="{{ route('dashboard') }}"
           class="block px-3 py-2 rounded-md text-sm font-medium
           {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            {{ __('app.dashboard') }}
        </a>

        <a href="{{ route('equipment.index') }}"
           class="block px-3 py-2 rounded-md text-sm font-medium
           {{ request()->routeIs('equipment.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            {{ __('app.equipment') }}
        </a>

        <a href="{{ route('reports.usageForm') }}"
           class="block px-3 py-2 rounded-md text-sm font-medium
           {{ request()->routeIs('reports.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            {{ __('app.reports') }}
        </a>

    </div>
</nav>
