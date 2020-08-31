<?php

namespace App\Modules\Web;

use Illuminate\Routing\Controller as BaseController;

class SoyTonto extends BaseController
{
    public function metode()
    {
        return view('carpeta/archivo');
    }
}
