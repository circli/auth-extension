<?php declare(strict_types=1);

namespace Circli\Extension\Auth\Events;

final class AclAccessRequest extends AbstractAccessRequest
{
    private string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
