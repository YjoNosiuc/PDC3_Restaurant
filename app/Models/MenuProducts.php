<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuProducts extends Model
{
    protected $fillable = [
        'menu_id',
        'product_id',
    ];

    
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
