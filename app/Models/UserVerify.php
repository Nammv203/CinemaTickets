<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class UserVerify.
 *
 * @package namespace App\Models;
 */
class UserVerify extends Model implements Transformable
{
    use TransformableTrait;
    use Notifiable;

    protected $table = 'users_verify';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'otp',
        'token',
        'token_expires'
    ];

}
