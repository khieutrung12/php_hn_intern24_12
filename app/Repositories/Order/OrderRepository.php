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
        return $this->model->select('voucher_id')
            ->where('user_id', $user_id)
            ->whereNotNull('voucher_id')->get();
    }
}
