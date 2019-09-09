<?php declare(strict_types=1);

namespace Circli\Extension\Auth\Repositories\Objects;

interface AclInterface
{
    public function isAllowed(string $key): bool;

    public function isOwner(object $obj): bool;
}
