<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public function items()
    {
        // එක Document එකකට අයිතම (Items) කිහිපයක් තිබිය හැක
        return $this->hasMany(DocumentItem::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
