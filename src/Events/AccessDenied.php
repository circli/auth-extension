<?php declare(strict_types=1);

namespace Circli\Extension\Auth\Events;

use Circli\Extension\Auth\Repositories\Objects\AuthObject;

final class AccessDenied
{
	public const OWNER = 'owner';
	public const PERMISSION = 'permission';

	/** @var AuthObject */
	private $object;
	/** @var string */
	private $type;
	/** @var string */
	private $value;

	public function __construct(AuthObject $object, string $type, string $value)
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

	public function getValue(): string
	{
		return $this->value;
	}
}
