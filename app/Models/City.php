<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'cities';

    public $translatable = [
        'title',
    ];

    protected $fillable = [
        'title',
        'country_id',

    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
