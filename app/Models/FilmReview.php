<?php

namespace App\Models;

use App\Traits\TraitsHasAudit;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Film.
 *
 * @package namespace App\Models;
 */
class FilmReview extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use TraitsHasAudit;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "film_reviews";
    protected $fillable = [
        'film_id',
        'user_id',
        'user_name_fake',
        'stars',
        'comment',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}