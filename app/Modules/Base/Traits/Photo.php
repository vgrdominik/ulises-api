<?php

namespace App\Modules\Base\Traits;

trait Photo
{
    public function getPhotoAttribute(): string
    {
        return $this->photo;
    }
}
