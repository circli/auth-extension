<?php declare(strict_types=1);

namespace Circli\Extension\Auth\Web\Middleware;

use Circli\Extension\Auth\Auth;
use Circli\Extension\Auth\Events\RouteAccessRequest;
use Circli\Extension\Auth\Web\AccessDeniedActionInterface;
use Circli\Extension\Auth\Web\RequestAttributeKeys;
use Polus\Adr\Interfaces\Action;
use Polus\Router\Route;
use Polus\Router\RouterDispatcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthAwareRouterMiddleware implements MiddlewareInterface
{
    private AccessDeniedActionInterface $accessDeniedAction;

    public function __construct(AccessDeniedActionInterface $accessDeniedAction)
    {
        $this->accessDeniedAction = $accessDeniedAction;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $route = $request->getAttribute('route');
        if ($route && $route->getStatus() === RouterDispatcher::FOUND) {
            /** @var Auth $auth */
            $auth = $request->getAttribute(RequestAttributeKeys::AUTH);
            if (!$auth->haveAccess(new RouteAccessRequest($route, $auth, $request))) {
                $request = $request->withAttribute('denied_route', $route);
                $newRoute = new class($this->accessDeniedAction, $route) implements Route {
                    private Action $action;
                    private Route $route;

                    public function __construct(Action $action, Route $route)
                    {
                        $this->action = $action;
                        $this->route = $route;
                    }

                    public function getStatus(): int
                    {
                        return RouterDispatcher::FOUND;
                    }

                    /**
                     * @return string[]
                     */
                    public function getAllows(): array
                    {
                        return ['GET', 'POST'];
                    }

                    public function getHandler(): Action
                    {
                        return $this->action;
                    }

                    public function getMethod(): string
                    {
                        return $this->route->getMethod();
                    }

                    /**
                     * @return array<string, mixed>
                     */
                    public function getAttributes(): array
                    {
                        return $this->route->getAttributes();
                    }
                };
                $request = $request->withAttribute('route', $newRoute);
            }
        }

        return $handler->handle($request);
    }
}
