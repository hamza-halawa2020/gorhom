<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $table = 'views';

    protected $fillable = [
        'ip_address',
        'user_agent',
        'viewable_type',
        'viewable_id',
        'count',
        'country',
        'city',
    ];

    public function viewable()
    {
        return $this->morphTo();
    }
}
