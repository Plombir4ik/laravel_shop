<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $appends = ['products'];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function specs()
    {
        return $this->hasMany(Spec::class);
    }

    public function getProductsAttribute()
    {
        return $this->products()->get();
    }
}
