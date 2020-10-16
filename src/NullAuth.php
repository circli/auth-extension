<?php declare(strict_types=1);

namespace Circli\Extension\Auth;

use Circli\Extension\Auth\Repositories\Objects\AuthObject;
use Circli\Extension\Auth\Repositories\Objects\NullAuthObject;
use Circli\Extension\Auth\Voter\AccessRequestEventInterface;

final class NullAuth implements Auth
{
    public function isAllowed(string $key): bool
    {
        return false;
    }

    public function isOwner(object $obj): bool
    {
        return false;
    }

    public function isAuthenticated(): bool
    {
        return false;
    }

    public function haveAccess(AccessRequestEventInterface $key): bool
    {
        return false;
    }

    public function getObject(): AuthObject
    {
        return new NullAuthObject();
    }
}
