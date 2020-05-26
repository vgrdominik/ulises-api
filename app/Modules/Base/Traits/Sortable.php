<?php

namespace App\Modules\Base\Traits;

trait Sortable
{
    public function getOrderAttribute(): string
    {
        return $this->order;
    }
}
