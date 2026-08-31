<!DOCTYPE html>
<html lang="pt-BR" class="min-h-[100dvh]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#09090b">
    <title>encurta. — encurtador de URL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-[100dvh] bg-zinc-950 font-sans text-zinc-100 antialiased selection:bg-emerald-400/30">
    <div class="mx-auto flex min-h-[100dvh] w-full max-w-2xl flex-col px-6">

        <header class="flex items-center gap-2.5 py-8">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                <rect x="1" y="1" width="18" height="18" rx="5" class="fill-emerald-400"/>
                <path d="M6 12.5 12.5 6M8 6h4.5v4.5" stroke="#09090b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="text-lg font-semibold tracking-tight">encurta<span class="text-emerald-400">.</span></span>
        </header>

        <main class="flex-1">
            <section class="reveal pt-10 pb-12 md:pt-16">
                <h1 class="text-4xl font-semibold tracking-tighter text-zinc-50 md:text-5xl">
                    Cole um link.<br>Receba um link curto.
                </h1>
                <p class="mt-4 max-w-[45ch] leading-relaxed text-zinc-400">
                    Encurtador de URL direto ao ponto, sem cadastro e sem anúncios.
                </p>
            </section>

            <form method="POST" action="{{ route('shorten') }}" class="reveal group grid gap-2" style="animation-delay: 80ms">
                @csrf
                <label for="url" class="text-sm font-medium text-zinc-300">URL para encurtar</label>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <input
                        id="url"
                        name="url"
                        type="url"
                        placeholder="https://exemplo.com/pagina/muito/longa"
                        value="{{ old('url') }}"
                        required
                        class="h-12 w-full rounded-xl border border-white/10 bg-white/5 px-4 text-base text-zinc-100 placeholder:text-zinc-500 focus:border-emerald-400/60 focus:outline-none focus:ring-2 focus:ring-emerald-400/20"
                    >
                    <button
                        type="submit"
                        class="h-12 shrink-0 rounded-xl bg-emerald-400 px-6 font-semibold text-zinc-950 transition hover:bg-emerald-300 active:scale-[0.98] sm:w-auto"
                    >
                        Encurtar
                    </button>
                </div>
                <p class="text-xs text-zinc-500">Aceita endereços http e https completos.</p>
                @error('url')
                    <p class="text-sm text-rose-400">{{ $message }}</p>
                @enderror
            </form>

            @if (session('shortened'))
                @php($shortened = session('shortened'))
                <section class="reveal mt-8 rounded-2xl border border-emerald-400/25 bg-emerald-400/5 p-6" style="animation-delay: 40ms">
                    <p class="text-sm font-medium text-emerald-300">Link criado</p>
                    <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:items-center">
                        <code class="min-w-0 flex-1 truncate font-mono text-lg text-zinc-100">{{ $shortened['short_url'] }}</code>
                        <button
                            type="button"
                            data-copy="{{ $shortened['short_url'] }}"
                            class="h-10 shrink-0 rounded-lg border border-white/10 bg-white/5 px-4 text-sm font-medium text-zinc-200 transition hover:bg-white/10 active:scale-[0.98]"
                        >
                            Copiar
                        </button>
                    </div>
                    <p class="mt-3 truncate text-sm text-zinc-500">Original: {{ $shortened['original_url'] }}</p>
                </section>
            @endif

            <section class="mt-14 pb-16">
                <h2 class="text-sm font-medium text-zinc-400">Links recentes</h2>

                @if ($recent->isEmpty())
                    <div class="mt-4 rounded-2xl border border-dashed border-white/10 p-10 text-center">
                        <p class="text-zinc-300">Nenhum link encurtado ainda.</p>
                        <p class="mt-1 text-sm text-zinc-500">Cole uma URL acima para criar o primeiro.</p>
                    </div>
                @else
                    <ul class="mt-4 divide-y divide-white/5 rounded-2xl border border-white/10">
                        @foreach ($recent as $item)
                            <li class="flex items-center justify-between gap-4 px-5 py-4">
                                <div class="min-w-0">
                                    <a href="{{ '/' . $item->code }}" class="font-mono text-sm text-emerald-300 hover:text-emerald-200">{{ url('/') }}/{{ $item->code }}</a>
                                    <p class="mt-0.5 truncate text-sm text-zinc-500">{{ $item->original_url }}</p>
                                </div>
                                <span class="shrink-0 font-mono text-xs text-zinc-500">{{ $item->clicks }} {{ $item->clicks === 1 ? 'clique' : 'cliques' }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
        </main>

        <footer class="border-t border-white/5 py-6">
            <p class="text-xs text-zinc-600">encurta. — Laravel + SQLite, feito para testes de git.</p>
        </footer>
    </div>
</body>
</html>
