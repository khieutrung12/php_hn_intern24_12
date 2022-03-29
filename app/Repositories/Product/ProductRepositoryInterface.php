<?php

namespace App\Repositories\Product;

use App\Repositories\BaseRepositoryInterface;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function getProduct();

    public function storeImageProduct($getFile, $name);

    public function deleteFileImage($destination);

    public function createProduct(array $attributes, array $categoryIds);

    public function updateProduct(int $productId, array $attributes, array $categoryIds);
}
