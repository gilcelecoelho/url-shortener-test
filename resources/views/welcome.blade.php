<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Encurtador de URL</title>
</head>
<body>
    <main>
        <h1>Encurtador de URL</h1>
        <form method="POST" action="{{ route('shorten') }}">
            @csrf
            <label for="url">URL</label>
            <input id="url" name="url" type="url" placeholder="https://exemplo.com" required>
            @error('url')<p>{{ $message }}</p>@enderror
            <button type="submit">Encurtar</button>
        </form>

        @if (session('shortened'))
            <p>Link curto: <a href="{{ session('shortened.short_url') }}">{{ session('shortened.short_url') }}</a></p>
        @endif

        @if ($recent->isNotEmpty())
            <h2>Recentes</h2>
            <ul>
                @foreach ($recent as $item)
                    <li>{{ $item->code }} → {{ $item->original_url }} ({{ $item->clicks }} cliques)</li>
                @endforeach
            </ul>
        @endif
    </main>
</body>
</html>
