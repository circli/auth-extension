<?php declare(strict_types=1);

namespace Circli\Extension\Auth\Voter;

use Circli\Extension\Auth\Events\RouteAccessRequest;
use Circli\Extension\Auth\Repositories\Objects\AuthObject;

final class AuthRequiredActionVoter implements VoterInterface
{
    /**
     * List of required interfaces
     *
     * @var string[]
     */
    private array $actions = [];

    public function setAuthObject(AuthObject $object): void
    {
    }

    public function addAction(string $action): void
    {
        $this->actions[] = $action;
    }

    public function supports(AccessRequestEventInterface $accessRequest): bool
    {
        return $accessRequest instanceof RouteAccessRequest;
    }

    public function __invoke(AccessRequestEventInterface $accessRequestEvent): void
    {
        if ($accessRequestEvent instanceof RouteAccessRequest) {
            $action = $accessRequestEvent->getRoute()->getHandler();
            if (is_object($action)) {
                foreach ($this->actions as $testAction) {
                    if ($action instanceof $testAction) {
                        if (!$accessRequestEvent->getAuth()->isAuthenticated()) {
                            $accessRequestEvent->deny();
                        }
                        else {
                            $accessRequestEvent->allow();
                        }
                        return;
                    }
                }
            }
        }
    }
}
