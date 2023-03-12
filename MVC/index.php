<?php // UserController.php
require_once '../vendor/autoload.php';

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$routes = new RouteCollection();

// ...

// Initialize the routing context
$request = Request::createFromGlobals();
$context = new RequestContext();
$context->fromRequest($request);

// Match the current request to a route
$matcher = new UrlMatcher($routes, $context);
try {
    $parameters = $matcher->match($request->getPathInfo());

    // Call the appropriate controller method with the matched parameters
    $controller = new $parameters['_controller'];
    $response = call_user_func_array(array($controller, $parameters['_action']), $parameters);
} catch (Exception $e) {
    // Handle any exceptions thrown by the controller methods
    $response = new Response('An error occurred: ' . $e->getMessage(), 500);
}

// Send the response to the browser
$response->send();

// Error handling middleware
function handleError($exception, $request, $debug) {
    $response = new Response('An error occurred: ' . $exception->getMessage(), 500);
    return $response;
}

$dispatcher = new FastRoute\Dispatcher\GroupCountBased();
$dispatcher->register('GET', '/error', 'handleError');

$request = Request::createFromGlobals();
$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // Handle 404 errors
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        // Handle 405 errors
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // Call the error handling middleware with the caught exception
        $response = call_user_func_array($handler, array($e, $request, $debug));
        // Send the response to the browser
        $response->send();
        break;
}
