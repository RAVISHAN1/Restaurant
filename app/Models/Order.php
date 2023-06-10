<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'reference_number',
    ];

    public function OrderFoods(): HasMany
    {
        return $this->hasMany(OrderFood::class, 'order_id', 'id');
    }
}
