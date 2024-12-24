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
class Film extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use TraitsHasAudit;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "films";
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'trailer_youtube_link',
        'picture',
        'time_duration',
        'publish_at',
        'derector',
        'actor',
        'amount',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function schedules()
    {
        return $this->hasMany(SchedulePublishFilm::class,'film_id');
    }

    public function reviews()
    {
        return $this->hasMany(FilmReview::class, 'film_id', 'id');
    }
}