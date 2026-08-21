<?php

namespace Tests\Unit;

use App\Models\VideoPembelajaran;
use PHPUnit\Framework\TestCase;

class VideoPembelajaranTest extends TestCase
{
    public function test_ekstrak_id_youtube_dari_berbagai_format_url(): void
    {
        $kasus = [
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ' => 'dQw4w9WgXcQ',
            'https://youtu.be/dQw4w9WgXcQ' => 'dQw4w9WgXcQ',
            'https://www.youtube.com/embed/dQw4w9WgXcQ' => 'dQw4w9WgXcQ',
            'https://www.youtube.com/shorts/dQw4w9WgXcQ' => 'dQw4w9WgXcQ',
            'https://contoh.com/bukan-youtube' => null,
        ];

        foreach ($kasus as $url => $harapan) {
            $this->assertSame($harapan, VideoPembelajaran::ekstrakIdYoutube($url));
        }
    }
}
