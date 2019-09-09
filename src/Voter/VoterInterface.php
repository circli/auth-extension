<?php declare(strict_types=1);

namespace Circli\Extension\Auth\Voter;

use Circli\Extension\Auth\Repositories\Objects\AuthObject;

interface VoterInterface
{
	public function setAuthObject(AuthObject $object): void;

    public function supports(AccessRequestEventInterface $accessRequest): bool;

    public function __invoke(AccessRequestEventInterface $accessRequestEvent): void;
}