<?php

namespace Tests\Voter;

use Circli\Extension\Auth\Events\AclAccessRequest;
use Circli\Extension\Auth\Repositories\Objects\AuthObject;
use Circli\Extension\Auth\Repositories\Objects\NullAuthObject;
use Circli\Extension\Auth\Voter\AccessCheckers;
use Circli\Extension\Auth\Voter\AccessRequestEventInterface;
use Circli\Extension\Auth\Voter\VoterInterface;
use PHPUnit\Framework\TestCase;

class AccessCheckersTest extends TestCase
{
    public function testEmptyVoterList(): void
    {
        $checker = new AccessCheckers();

        $event = new AclAccessRequest('test');
        $voterCount = iterator_count($checker->getListenersForEvent($event));
        $this->assertSame(0, $voterCount);
    }

    public function testVoterSupport(): void
    {
        $checker = new AccessCheckers();
        $checker->addVoter(new class implements VoterInterface {
            public function setAuthObject(AuthObject $object): void
            {
                AccessCheckersTest::assertInstanceOf(NullAuthObject::class, $object);
            }

            public function supports(AccessRequestEventInterface $accessRequest): bool
            {
                return $accessRequest instanceof AclAccessRequest;
            }

            public function __invoke(AccessRequestEventInterface $accessRequestEvent): void
            {
                if ($accessRequestEvent instanceof AclAccessRequest) {
                    AccessCheckersTest::assertSame('test', $accessRequestEvent->getKey());
                }
                else {
                    AccessCheckersTest::fail('Wrong event data');
                }
            }
        });

        $event = new AclAccessRequest('test');
        $voters = iterator_to_array($checker->getListenersForEvent($event));
        $this->assertCount(1, $voters);
        $voters[0]($event);
    }

    public function testSetAuthObject(): void
    {
        $checker = new AccessCheckers();
        $checker->addVoter(new class implements VoterInterface {
            public function setAuthObject(AuthObject $object): void
            {
                AccessCheckersTest::assertInstanceOf(RealAuthObject::class, $object);
            }

            public function supports(AccessRequestEventInterface $accessRequest): bool
            {
                return $accessRequest instanceof AclAccessRequest;
            }

            public function __invoke(AccessRequestEventInterface $accessRequestEvent): void
            {
                if ($accessRequestEvent instanceof AclAccessRequest) {
                    AccessCheckersTest::assertSame('test', $accessRequestEvent->getKey());
                }
                else {
                    AccessCheckersTest::fail('Wrong event data');
                }
            }
        });

        $event = new AclAccessRequest('test');
        $checker->setAuthObject(new RealAuthObject());
        $voterCount = iterator_count($checker->getListenersForEvent($event));
        $this->assertSame(1, $voterCount);
    }
}

class RealAuthObject implements AuthObject {}
