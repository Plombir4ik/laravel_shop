<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spec extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = [
        'bonds'
    ];
    protected $appends = ['values'];

    public function bonds()
    {
        return $this->hasMany(ProductSpec::class);
    }

    public function getValuesAttribute()
    {
        $arr_values = [];
        foreach ($this->bonds as $bond) {
            $arr_values[] = $bond->value;
        }
        return array_unique($arr_values);
    }
}
