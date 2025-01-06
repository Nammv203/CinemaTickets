<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Repositories\OrderRepository;
use App\Validators\OrderValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class OrdersController.
 *
 * @package namespace App\Http\Controllers;
 */
class OrdersController extends Controller
{
    /**
     * @var TicketOrderRepository
     */
    protected $repository;

    /**
     * OrdersController constructor.
     *
     * @param TicketOrderRepository $repository
     */
    public function __construct(TicketOrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $orders = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $orders,
            ]);
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(OrderCreateRequest $request)
    {
        try {

//            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $order = $this->repository->create($request->all());

            $response = [
                'message' => 'Order created.',
                'data' => $order->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            toastr()->success(trans('Tạo thành công!'));
            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            toastr()->error(trans('Tạo thành thất bại!'));
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $order,
            ]);
        }

        return view('backend.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = $this->repository->find($id);

        return view('backend.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderUpdateRequest $request
     * @param string $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(OrderUpdateRequest $request, $id)
    {
        try {

//            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $order = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Order updated.',
                'data'    => $order->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            toastr()->success('Cập nhật thành công!');
            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            toastr()->error('Cập nhật thất bại!');
            if ($request->wantsJson()) {

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Order deleted.',
                'deleted' => $deleted,
            ]);
        }

        toastr()->success('Xóa thành công!');
        return redirect()->back()->with('message', 'Order deleted.');
    }
}