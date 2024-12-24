<?php

namespace App\Models;

use App\Traits\TraitsHasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Cinema.
 *
 * @package namespace App\Models;
 */
class Cinema extends Model implements Transformable
{
    use TransformableTrait;
    use TraitsHasAudit;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'cinemas';
    protected $fillable = [
        'location_id',
        'name',
        'picture',
        'email',
        'phone',
        'address',
        'cinema_code'
    ];

    public function location_district()
    {
        return $this->hasOne(LocationDistrict::class, 'id', 'location_id');
    }

    public function location_province()
    {

        return $this->hasManyThrough(
            LocationProvince::class,
            LocationDistrict::class,
            'province_id',
            'id',
            'location_id',
            'province_id'
        );

    }
}
