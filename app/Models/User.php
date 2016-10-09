<?php

namespace App\Models;

use Eloquent;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Eloquent
{
    use EntrustUserTrait;
    //
}
