<?php

declare(strict_types=1);

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        static::creating(function (Model $item) {
            $item->makeSlug();
        });
    }

    protected function makeSlug(): void
    {
        if (!$this->{$this->slugColumn()}) {
            $slug = $this->slugUnique(
                str($this->{$this->slugFrom()})
                    ->slug()
                    ->value()
            );

            $this->{$this->slugColumn()} = $slug;
        }
    }

    protected function slugColumn(): string
    {
        return 'slug';
    }

    public function slugFrom()
    {
        return 'title';
    }

    private function slugUnique(string $slug): string
    {
        $originSlug = $slug;
        $i = 0;

        while ($this->isSlugExist($slug)) {
            $i++;

            $slug = $originSlug . '-' . $i;
        }

        return $slug;
    }

    private function isSlugExist(string $slug): bool
    {
        $query = $this->newQuery()
            ->where(self::slugColumn(), $slug)
            ->where($this->getKeyName(), '!==', $this->getKey())
            ->withoutGlobalScopes();

        return $query->exists();
    }
}
