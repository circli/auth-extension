<?php declare(strict_types=1);

namespace Circli\Extension\Auth\Events;

use Circli\Extension\Auth\Voter\AccessRequestEventInterface;

class AbstractAccessRequest implements AccessRequestEventInterface
{
    protected ?bool $allow;

    public function allow(): void
    {
        $this->allow = true;
    }

    public function deny(): void
    {
        $this->allow = false;
    }

    public function isPropagationStopped(): bool
    {
        return $this->allow === false;
    }

    public function allowed(): bool
    {
        return $this->allow === true;
    }
}
