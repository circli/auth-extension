<?php declare(strict_types=1);

namespace Circli\Extension\Auth\Voter;

use Circli\Extension\Auth\Events\RouteAccessRequest;
use Circli\Extension\Auth\Repositories\Objects\AuthObject;

final class DefaultAllowRouteVoter implements VoterInterface
{
    public function supports(AccessRequestEventInterface $accessRequest): bool
    {
        return $accessRequest instanceof RouteAccessRequest;
    }

    public function __invoke(AccessRequestEventInterface $accessRequestEvent): void
    {
        if ($accessRequestEvent instanceof RouteAccessRequest) {
            $accessRequestEvent->allow();
        }
    }

    public function setAuthObject(AuthObject $object): void
    {
    }
}
