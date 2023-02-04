<?php
declare(strict_types=1);

namespace App\Components\Fakers;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class FakerImageProvider extends Base
{
    /**
     * @param string $storagePath
     * @param int $width
     * @param int $height
     * @return string|null
     */
    public static function picsum(string $path, int $width = 600, int $height = 600): string|null
    {
        try {
            if (!Storage::exists($path)) {
                Storage::createDirectory($path);
            }
            $filePath = $path . '/' . Str::random(12) . '.jpg';

            $file = Http::withHeaders(
                [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36 Edg/91.0.864.59'
                ]
            )
                ->get('https://picsum.photos/' . $width . '/' . $height)
                ->throw()
                ->body();

            Storage::put($filePath, $file);

            return $filePath;
        } catch (Throwable $e) {
            report($e);
        }
        return null;
    }
}
