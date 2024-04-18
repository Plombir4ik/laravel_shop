<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function createProduct($data, $subcategory)
    {
        try {
            DB::beginTransaction();

            $product = Product::create([
                'subcategory_id' => $subcategory,
                'name' => $data['name'],
                'brand' => $data['brand'],
                'description' => $data['description'],
                'img' => $data['image'],
                'price' => $data['price'],
                'count' => $data['count'],
            ]);

            $specs = $this->extractSpecs($data);
            $product->setSpecs($specs);

            DB::commit();

            return $product;

        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }

    public function updateProduct($product, $data)
    {
        try {
            DB::beginTransaction();

            $product->update([
                'name' => $data['name'],
                'brand' => $data['brand'],
                'description' => $data['description'],
                'img' => $data['image'],
                'price' => $data['price'],
                'count' => $data['count'],
            ]);

            $specs = $this->extractSpecs($data);
            $product->updateSpecs($specs);

            DB::commit();

            return $product;

        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }

    public function extractSpecs($data)
    {
        return array_reduce($data['specs'], function ($carry, $item) {
            $carry[$item['id']] = $item['value'];
            return $carry;
        }, []);
    }
}
