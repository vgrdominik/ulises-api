<?php

namespace App\Modules\Base\Traits;

trait Availability
{
    public function isAvailable(): bool
    {
        return $this->is_available;
    }
}
