<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'category_id', 'hidden_for_groups'];

    protected $casts = [
        'hidden_for_groups' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
