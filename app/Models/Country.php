<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'countries';

    public $translatable = [
        'title',
    ];

    protected $fillable = [
        'title',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'country_id');
    }
}
