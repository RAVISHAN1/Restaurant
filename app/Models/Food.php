<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'name',
        'price',
    ];

    public function OrderFoods(): HasMany
    {
        return $this->hasMany(OrderFood::class, 'food_id', 'id');
    }
}
