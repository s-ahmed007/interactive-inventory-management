<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'image',
        'description',
        'inventory_id'
    ];

    public function inventory() {
        return $this->belongsTo(Inventory::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => $image ?  asset('storage/'.  $image)  : 'https://fastly.picsum.photos/id/8/5000/3333.jpg?hmac=OeG5ufhPYQBd6Rx1TAldAuF92lhCzAhKQKttGfawWuA',
        );
    }
}
