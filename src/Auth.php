<?php declare(strict_types=1);

namespace Circli\Extension\Auth;

use Circli\Extension\Auth\Repositories\Objects\AclInterface;
use Circli\Extension\Auth\Repositories\Objects\AuthObject;
use Circli\Extension\Auth\Voter\AccessRequestEventInterface;

interface Auth extends AclInterface
{
	public function getObject(): AuthObject;

    public function isAuthenticated(): bool;
    public function haveAccess(AccessRequestEventInterface $key): bool;
}
