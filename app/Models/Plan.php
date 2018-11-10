<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name', 'description', 'level', 'traffic', 'price', 'stock'
    ];

    public function nodes()
    {
        return $this->belongsToMany(Node::class, 'plan_nodes', 'plan_id', 'node_id');
    }
}
