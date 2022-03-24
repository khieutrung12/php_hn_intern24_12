<?php

namespace App\Repositories\Order;

use App\Repositories\BaseRepositoryInterface;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function findByVoucherId($voucher_id);
    public function getVoucherIdByUserId($user_id);
}
