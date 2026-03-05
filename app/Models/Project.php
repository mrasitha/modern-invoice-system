<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'client_name'
    ];

    public function documents()
    {
        // එක Project එකකට Documents (Invoices/Quotes) කිහිපයක් තිබිය හැක
        return $this->hasMany(Document::class);
    }
}
