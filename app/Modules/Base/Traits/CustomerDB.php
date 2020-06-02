<?php

namespace App\Modules\Base\Traits;

use App\Modules\User\Domain\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

trait CustomerDB
{

    public function setToCustomerDB(User $user): void
    {
        Config::set('database.connections.tenant.host', $user->db_host);
        Config::set('database.connections.tenant.username', $user->db_user);
        Config::set('database.connections.tenant.password', $user->db_password);
        Config::set('database.connections.tenant.database', $user->db_name);

        //If you want to use query builder without having to specify the connection
        Config::set('database.default', 'tenant');
        DB::reconnect('tenant');
    }
}
