<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\BaseRepository;
use App\Repositories\Order\OrderRepositoryInterface;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }

    public function findByVoucherId($voucher_id)
    {
        $this->model->where('voucher_id', $voucher_id)->first();
    }

    public function getVoucherIdByUserId($user_id)
    {
        return $this->model
            ->where('user_id', $user_id)
            ->whereNotNull('voucher_id')->get();
    }

    public function getOrderWithUserId($user_id)
    {
        return $this->model
            ->where('user_id', $user_id)->with('products', 'orderStatus')
            ->orderby('created_at', 'DESC')
            ->paginate(config('app.limit'));
    }

    public function getOrderWithUserIdAndStatusOrder($user_id, $order_status_id)
    {
        return $this->model->where([
            ['user_id', $user_id],
            ['order_status_id', $order_status_id],
        ])->with('products', 'orderStatus')
            ->orderby('created_at', 'DESC')
            ->paginate(config('app.limit'));
    }

    public function findOrderByUserId($user_id)
    {
        return $this->model
            ->where('user_id', $user_id)->get();
    }

    public function getOrderNotInStatusCancel()
    {
        return $this->model->whereNotIn('order_status_id', [config('app.canceled')])
            ->with('orderStatus')->orderby('created_at', 'DESC')->get();
    }

    public function getOrderInStatusCancel()
    {
        return $this->model->whereIn('order_status_id', [config('app.canceled')])
            ->orderby('created_at', 'DESC')->paginate(config('app.limit'));
    }
}
