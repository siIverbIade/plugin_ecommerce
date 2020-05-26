<?php

declare(strict_types=1);

namespace Spreng\security;

use Spreng\model\Page;

class SecurityLogin extends Page
{
    public string $username;
    public string $auth_url;
}
