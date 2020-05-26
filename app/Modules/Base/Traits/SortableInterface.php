<?php

namespace App\Modules\Base\Traits;

interface SortableInterface
{
    public function getOrderAttribute(): string;
}
