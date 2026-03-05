<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'project_id', 
        'doc_number', 
        'type', 
        'billing_mode', 
        'total_amount', 
        'status'
    ];

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
