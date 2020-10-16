<?php declare(strict_types=1);

namespace Circli\Extension\Auth\Events;

use Circli\Extension\Auth\Auth;
use Polus\Router\Route;

final class RouteAccessRequest extends AbstractAccessRequest
{
    private Route $route;
    private Auth $auth;

    public function __construct(Route $route, Auth $auth)
    {
        $this->route = $route;
        $this->auth = $auth;
    }

    public function getRoute(): Route
    {
        return $this->route;
    }

    public function getAuth(): Auth
    {
        return $this->auth;
    }
}
