<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'identifier', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateIdentifier($tries = 0)
    {
        if ($tries > 10) {
            throw new \Exception('Can not generate unique link');
        }

        $identifier = \Str::random(\random_int(6, 8));

        if (static::where('identifier', $identifier)->count() > 0) {
            return static::generateIdentifier($tries + 1);
        }

        return $identifier;
    }

    public function accessMetrics()
    {
        return $this->hasMany(AccessMetric::class);
    }
}
