<?php

namespace Tests\Feature;

use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_shortens_valid_url(): void
    {
        $response = $this->post('/shorten', ['url' => 'https://example.com/very/long/path']);

        $response->assertRedirect('/')
            ->assertSessionHas('shortened.code');

        $this->assertDatabaseHas('short_urls', ['original_url' => 'https://example.com/very/long/path']);
    }

    public function test_rejects_invalid_url(): void
    {
        $response = $this->post('/shorten', ['url' => 'not-a-url']);

        $response->assertSessionHasErrors('url');
        $this->assertDatabaseCount('short_urls', 0);
    }

    public function test_redirects_to_original_url(): void
    {
        $shortUrl = ShortUrl::create([
            'original_url' => 'https://example.com/target',
            'code' => 'abc1234',
        ]);

        $this->get('/abc1234')
            ->assertRedirect('https://example.com/target');

        $this->assertSame(1, $shortUrl->fresh()->clicks);
    }

    public function test_returns_404_for_unknown_code(): void
    {
        $this->get('/naoexiste')->assertNotFound();
    }
}
