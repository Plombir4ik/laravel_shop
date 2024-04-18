<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $hidden = [
        'bonds'
    ];
    protected $appends = ['specs'];

    public function bonds()
    {
        return $this->hasMany(ProductSpec::class);
    }

    public function getSpecsAttribute()
    {
        $arr_values = [];
        foreach ($this->bonds as $bond) {
            $arr_values[] = ['name' => $bond->spec->name, 'value' => $bond->value];
        }
        return $arr_values;
    }

    public function setSpecs($specs)
    {
        foreach ($specs as $id => $value) {
            if($value != null){
                ProductSpec::firstOrCreate([
                    'product_id' => $this->id,
                    'spec_id' => $id,
                    'value'=> $value
                ]);
            }
        }
    }

    public function updateSpecs($specs)
    {
        foreach ($specs as $id => $value) {
            $bond = ProductSpec::where('product_id', $this->id)->where('spec_id', $id)->first();

            if(!$bond) {
                if($value){
                    ProductSpec::Create([
                        'product_id' => $this->id,
                        'spec_id' => $id,
                        'value' => $value
                    ]);
                }
                continue;
            }
            $value ? $bond->update(['value' => $value]) : $bond->delete();
        }
    }
}
