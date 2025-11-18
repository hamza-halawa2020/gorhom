<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait FileUploadTrait
{
    /**
     * Upload a file to public folder
     *
     * @param  string  $folder  => eg: 'posts', 'users'
     * @return string => file path
     */
    public function uploadFile(UploadedFile $file, string $folder = 'uploads'): string
    {
        $destinationPath = public_path($folder);
        if (! file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

        $file->move($destinationPath, $filename);

        return $folder.'/'.$filename;
    }
}
