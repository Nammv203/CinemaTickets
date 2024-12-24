<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TicketOrderRepository;
use App\Models\TicketOrder;
use App\Validators\TicketOrderValidator;

/**
 * Class TicketOrderRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TicketOrderRepositoryEloquent extends BaseRepository implements TicketOrderItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TicketOrder::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
