<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\TrackViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasTranslations;
    use TrackViews;
    use HasFactory;
    use SoftDeletes;


    protected $table = 'products';

    public $translatable = [
        'title',
        'description',
    ];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'created_by',
        'category_id',
    ];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id');
    }
}
