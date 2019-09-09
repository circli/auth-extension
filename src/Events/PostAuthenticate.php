<?php declare(strict_types=1);

namespace Circli\Extension\Auth\Events;

use Circli\Extension\Auth\Auth;

final class PostAuthenticate
{
	/** @var Auth */
	private $auth;

	public function __construct(Auth $auth)
	{
		$this->auth = $auth;
	}

	public function getAuth(): Auth
	{
		return $this->auth;
	}
}
