<?php declare(strict_types=1);

namespace Circli\Extension\Auth\Events;

use Circli\Extension\Auth\Auth;
use Polus\Router\Route;
use Psr\Http\Message\ServerRequestInterface;

final class RouteAccessRequest extends AbstractAccessRequest
{
    private Route $route;
    private Auth $auth;
    private ServerRequestInterface $request;

    public function __construct(Route $route, Auth $auth, ServerRequestInterface $request)
    {
        $this->route = $route;
        $this->auth = $auth;
        $this->request = $request;
    }

    public function getRoute(): Route
    {
        return $this->route;
    }

    public function getAuth(): Auth
    {
        return $this->auth;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}
