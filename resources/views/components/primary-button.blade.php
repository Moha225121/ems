<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-2 bg-gradient-to-r from-indigo-500 to-cyan-400 border border-transparent rounded-full font-bold text-xs text-slate-900 uppercase tracking-widest hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-indigo-500/20']) }}>
    {{ $slot }}
</button>
