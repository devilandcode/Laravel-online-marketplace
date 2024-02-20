<?php

declare(strict_types=1);

namespace Support\Testing;

use Illuminate\Support\Facades\Storage;

class FakerImageProvider extends \Faker\Provider\Base
{
    public function fixturesImage(string $fixturesDir, string $storageDir): string
    {
        $storage = Storage::disk('images');

        if (!$storage->exists($storageDir)) {
            $storage->makeDirectory($storageDir);
        }

        $file = $this->generator->file(
            base_path("tests/Fixtures/images/$fixturesDir"),
            $storage->path($storageDir),
            false
        );
        return '/storage/images/' . trim($storageDir, '/') . '/' . $file;
    }
}
