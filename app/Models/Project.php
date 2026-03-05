<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function documents()
    {
        // එක Project එකකට Documents (Invoices/Quotes) කිහිපයක් තිබිය හැක
        return $this->hasMany(Document::class);
    }
}
