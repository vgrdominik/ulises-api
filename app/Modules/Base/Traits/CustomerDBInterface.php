<?php

namespace App\Modules\Base\Traits;

use App\Modules\User\Domain\User;

interface CustomerDBInterface
{
    public function setToCustomerDB(User $user): void;
}
