<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    public function generateSlug($model, $title, $id = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while ($model::where('slug', $slug)->when($id, function ($q) use ($id) {
            $q->where('id', '!=', $id);
        })->exists()) {
            $slug = $originalSlug.'-'.$count;
            $count++;
        }

        return $slug;
    }
}
