<?php

namespace App\Models\ShortLink;

use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class ShortLink
 *
 * @property int $id
 * @property int $user_id
 * @property string $link
 * @property string $code
 * @property int $state
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User $user
 * @property-read Visit[]|Collection $visits
 */
class ShortLink extends Model
{
    use HasFactory, HasCode;

    const STATE_INACTIVE = 0;
    const STATE_ACTIVE = 1;

    protected $fillable = [
        'user_id',
        'link',
        'code',
        'state',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }
}
