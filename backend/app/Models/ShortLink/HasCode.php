<?php

namespace App\Models\ShortLink;

use Illuminate\Support\Str;

/**
 * Trait HasCode
 */
trait HasCode
{
    protected static function bootHasCode(): void
    {
        static::creating(function ($model) {
            if (!$model->code) {
                do {
                    $model->code = Str::random(8);
                } while ($model::where('code', $model->code)->exists());
            }
        });

        static::saving(function ($model) {
            $originalCode = $model->getOriginal('code');
            if ($originalCode !== $model->code) {
                $model->code = $originalCode;
            }
        });
    }
}
