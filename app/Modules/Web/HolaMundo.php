<?php

namespace App\Modules\Web;

use Illuminate\Routing\Controller as BaseController;

class HolaMundo extends BaseController
{
    public function index()
    {
        return view('HolaMundo/index');
    }

    public function test()
    {
        return view('HolaMundo/test');
    }
}
