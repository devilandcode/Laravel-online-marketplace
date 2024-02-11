<?php

declare(strict_types=1);

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        // TODO  beauty unique slug
        static::creating(function (Model $item) {
            $item->slug = $item->slug
                ?? str($item->{self::slugFrom()})
                    ->append(time())
                    ->slug();
        });
    }

    public static function slugFrom()
    {
        return 'title';
    }

}