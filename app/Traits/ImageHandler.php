<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageHandler
{
    public function storeImage($request, $folder)
    {
            return $request->file("image")->store('images/'. $folder, 'public');
        
    }

    public function updateImage($request, $model,$folder)
{
    // Check if the model has the old photo
        $this->deleteImage($model);
        return $this->storeImage($request, $folder);
}


    public function deleteImage($model)
    {
        if ($model->image) {
            Storage::disk('public')->delete($model->image);
        }
    }
}
