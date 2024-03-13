<?php

namespace ArtisanElevated\Pesapal\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\MassPrunable;

/**
 * Class PesapalToken
 *
 * @property string $access_token
 * @property Carbon $expires_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class PesapalToken extends Model
{
    use MassPrunable;
    use HasFactory;

    protected $fillable = [
        'access_token',
        'expires_at'
    ];

    protected $casts = [
        'expires_at'   => 'datetime',
        'access_token' => 'encrypted'
    ];

    public function prunable(): Builder
    {
        return static::where('expires_at', '<=', now());
    }
}
