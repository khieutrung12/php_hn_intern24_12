<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }

    public function getProduct()
    {
        return $this->model->select('*')->with('brand', 'category')->orderby('created_at', 'DESC')->get();
    }

    public function createProduct(array $attributes, array $categoryIds)
    {
        $product = $this->create($attributes);
        $product->category()->sync($categoryIds);
        $product->save();

        return $product;
    }

    public function updateProduct(int $productId, array $attributes, array $categoryIds)
    {
        $product = $this->update($productId, $attributes);
        $product->category()->sync($categoryIds);
        $product->save();

        return $product;
    }
}
