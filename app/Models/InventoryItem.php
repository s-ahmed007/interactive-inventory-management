<?php

namespace App\Models;

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
}
