<?php declare(strict_types=1);

namespace Circli\Extension\Auth\Events;

use Circli\Extension\Auth\Auth;
use Polus\Router\RouteInterface;

final class RouteAccessRequest extends AbstractAccessRequest
{
    /** @var RouteInterface */
    private $route;
    /** @var Auth */
    private $auth;

    public function __construct(RouteInterface $route, Auth $auth)
    {
        $this->route = $route;
        $this->auth = $auth;
    }

    public function getRoute(): RouteInterface
    {
        return $this->route;
    }

    public function getAuth(): Auth
    {
        return $this->auth;
    }
}
