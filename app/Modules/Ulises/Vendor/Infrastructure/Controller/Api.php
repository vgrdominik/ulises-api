<?php


namespace App\Modules\Ulises\Vendor\Infrastructure\Controller;

use App\Modules\Base\Infrastructure\Controller\ResourceController;

class Api extends ResourceController
{
    protected function getModelName(): string
    {
        return 'Ulises\\Vendor';
    }
}
