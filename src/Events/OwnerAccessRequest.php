<?php declare(strict_types=1);

namespace Circli\Extension\Auth\Events;

final class OwnerAccessRequest extends AbstractAccessRequest
{
    private object $document;

    public function __construct(object $document)
    {
        $this->document = $document;
    }

    public function getDocument(): object
    {
        return $this->document;
    }
}
