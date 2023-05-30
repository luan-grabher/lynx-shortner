<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessMetric extends Model
{
    use HasFactory;

    protected $fillable = ['link_id', 'ip', 'user_agent'];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
