<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentItem extends Model
{
    protected $fillable = [
        'document_id', 
        'description', 
        'qty', 
        'unit_price'
    ];
}
