<?php

namespace App\Modules\Base\Traits;

trait Descriptive
{
    public function getReadableAttribute(): string
    {
        return $this->description ? $this->description : 'Sin descripción';
    }

    public function getShortReadableAttribute(): string
    {
        return $this->short_description ? $this->short_description : 'Sin descripción corta';
    }

    public function getLongReadableAttribute(): string
    {
        return $this->getReadableAttribute() . ' - ' . $this->getShortReadableAttribute();
    }
}
