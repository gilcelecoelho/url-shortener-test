<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ShortUrlController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'recent' => ShortUrl::latest()->take(5)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'url' => ['required', 'url', 'max:2048'],
        ]);

        $shortUrl = ShortUrl::create([
            'original_url' => $validated['url'],
            'code' => ShortUrl::generateUniqueCode(),
        ]);

        return back()->with('shortened', [
            'code' => $shortUrl->code,
            'original_url' => $shortUrl->original_url,
            'short_url' => URL::to('/' . $shortUrl->code),
        ]);
    }

    public function redirect(ShortUrl $shortUrl)
    {
        $shortUrl->increment('clicks');

        return redirect()->away($shortUrl->original_url, 302);
    }
}
