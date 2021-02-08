<?php

namespace App\Models;

use App\Models\ShortLink\ShortLink;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Visit
 *
 * @property int $id
 * @property int $short_link_id
 * @property string $referer
 * @property string $ip
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read ShortLink $link
 */
class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_link_id',
        'referer',
        'ip',
    ];

    /**
     * @return BelongsTo
     */
    public function link(): BelongsTo
    {
        return $this->belongsTo(ShortLink::class);
    }
}
