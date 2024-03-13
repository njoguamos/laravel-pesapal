<?php

namespace ArtisanElevated\Pesapal\Models;

use ArtisanElevated\Pesapal\Enums\IpnStatus;
use ArtisanElevated\Pesapal\Enums\IpnType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PesapalToken
 *
 * @property string $url
 * @property IpnType $type
 * @property string $ipn_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class PesapalIpn extends Model
{
    protected $fillable = [
        'url',
        'type',
        'status',
        'ipn_id',
        'created_at'
    ];

    protected $casts = [
        'type'   => IpnType::class,
        'status' => IpnStatus::class,
    ];

    protected $attributes = [
        'type' => IpnType::GET
    ];
}
