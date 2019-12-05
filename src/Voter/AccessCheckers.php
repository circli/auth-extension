<?php declare(strict_types=1);

namespace Circli\Extension\Auth\Voter;

use Circli\Extension\Auth\Repositories\Objects\AuthObject;
use Circli\Extension\Auth\Repositories\Objects\NullAuthObject;
use Psr\EventDispatcher\ListenerProviderInterface;

final class AccessCheckers implements ListenerProviderInterface
{
    /** @var VoterInterface[] */
    private $voters = [];
    /** @var AuthObject|null */
    private $authObject;

    public function addVoter(VoterInterface $voter): void
    {
        $this->voters[] = $voter;
    }
    
    /**
     * @param object $event
     *   An event for which to return the relevant listeners.
     * @return iterable[callable]
     *   An iterable (array, iterator, or generator) of callables.  Each
     *   callable MUST be type-compatible with $event.
     */
    public function getListenersForEvent(object $event): iterable
    {
        if ($event instanceof AccessRequestEventInterface) {
            $authObject = $this->authObject ?? new NullAuthObject();
            foreach ($this->voters as $voter) {
                $voter->setAuthObject($authObject);
                if ($voter->supports($event)) {
                    yield $voter;
                }
            }
        }
    }

    public function setAuthObject(AuthObject $authObject): void
    {
        $this->authObject = $authObject;
    }
}
