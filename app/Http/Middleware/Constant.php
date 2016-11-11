<?php

namespace App\Http\Middleware;

class Constant
{
	/**
     * declaring constant signifying to compare to the role_id
     *
    */
    const REGULAR_USER       = 3;
    const ADMIN_USER         = 2;
    const SUPER_ADMIN_USER   = 1;
}