<?php declare(strict_types=1);

namespace Circli\Extension\Auth\Events;

use Circli\Extension\Auth\Repositories\Objects\AuthObject;

final class AccessDenied
{
    public const OWNER = 'owner';
    public const PERMISSION = 'permission';

    private AuthObject $object;
    private string $type;
    /** @var mixed */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct(AuthObject $object, string $type, $value)
    {
        $this->object = $object;
        $this->type = $type;
        $this->value = $value;
    }

    public function getObject(): AuthObject
    {
        return $this->object;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
