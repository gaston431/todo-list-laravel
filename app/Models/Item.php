<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'todo_items';

    protected $fillable = [
        'name',
        'completed',
    ];

    public $timestamps = false;
}
