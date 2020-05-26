<?php


namespace App\Modules\Ulises\Channel\Infrastructure\Controller;

use App\Modules\Base\Infrastructure\Controller\ResourceController;

class Api extends ResourceController
{
    protected function getModelName(): string
    {
        return 'Ulises\\Channel';
    }
}
