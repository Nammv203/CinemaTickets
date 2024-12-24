<?php
namespace App\Models;
use App\Traits\TraitsHasAudit;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
/**
 * Class TicketOrder.
 *
 * @package namespace App\Models;
 */
class TicketOrder extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use TraitsHasAudit;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_number',
        'user_id',
        'schedule_id',
        'status',
        'products',
        'grand_total',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
    public function ticketOrderItems()
    {
        return $this->hasMany(TicketOrderItem::class,'ticket_order_id');
    }
}