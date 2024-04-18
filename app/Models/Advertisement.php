<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $appends = ['product'];
    protected $hidden = ['product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getProductAttribute()
    {
        return $this->product()->first();
    }
}
