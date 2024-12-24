<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TicketOrderItemRepository;
use App\Models\TicketOrderItem;
use App\Validators\TicketOrderItemValidator;

/**
 * Class TicketOrderItemRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class  TicketOrderItemRepositoryEloquent extends BaseRepository implements  TicketOrderItemRepository{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TicketOrderItem::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
