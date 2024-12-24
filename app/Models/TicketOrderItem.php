<?php
namespace App\Models;
use App\Traits\TraitsHasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
/**
 * Class TicketOrderItem.
 *
 * @package namespace App\Models;
 */
class TicketOrderItem extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
//    use TraitsHasAudit;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_order_id',
        'cinema_room_chair_id',
        'chair_type',
        'chair_code',
        'chair_type_price',
        'ticket_item_price',
    ];
    public function cinemaRoomChair()
    {
        return $this->belongsTo(CinemaRoomChair::class, 'cinema_room_chair_id');
    }
    public function ticketOrder()
    {
        return $this->belongsTo(TicketOrder::class, 'ticket_order_id');
    }
}