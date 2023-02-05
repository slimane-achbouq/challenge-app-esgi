<?php

namespace App\Helper;

class UserHelper
{
    public static array $ROLES = [
        'individual' => ['ROLE_INDIVIDUAL'],
        'self-employed/independent' => ['ROLE_SELF_EMPLOYED'],
        'company'   => ['ROLE_COMPANY'],
        'association'   => ['ROLE_ASSOCIATION']
    ];
}
