# Framework

A simple and easy to use MVC framework.

[![Build Status](https://travis-ci.org/SidRoberts/framework.svg?branch=master)](https://travis-ci.org/SidRoberts/framework)
[![GitHub tag](https://img.shields.io/github/tag/sidroberts/framework.svg?maxAge=2592000)]()



## Installation

```bash
composer require sidroberts/framework
```



## Usage

**A working example is coming soon.**

This library can be divided into three components:
* Kernel: couples Router and Dispatcher together. It is better able to deal with 404 errors and also adds Return Handlers.
* Router: takes a URL and determines which action method should be executed.
* Dispatcher: executes the Controller code.

A key detail with this implementation is that, although it uses Symfony's HTTP Request object, it doesn't require that Symfony HTTP Response objects should be returned. Instead, it allows the controllers to return whatever they want and, optionally, you can package that returned value by using Return Handlers to enforce a particular output (eg. Symfony Response, CLI exit codes).

### Controllers

All controllers should extend `\Sid\Framework\Controller` or implement `\Sid\Framework\ControllerInterface`. Specify what services you require in the constructor.

Action methods do not require a suffix - you're free to call it however you want - but they must have a `\Sid\Framework\Router\Annotations\Route` annotation.

The first unnamed parameter of the annotation is the URL you want to match:

```php
use Sid\Framework\Router\Annotations\Route;

/**
 * @Route(
 *     "/this/is/your/url"
 * )
 */
public function index()
{
    //TODO
}
```

You can also create URLs with dynamic values by enclosing their identifier in curly brackets (eg. `{id}`). These values will become the parameters of the action method:

```php
use Sid\Framework\Router\Annotations\Route;

/**
 * @Route(
 *     "/post/{id}"
 * )
 */
public function viewSingle($id)
{
    //TODO Do something with $id.
}

/**
 * @Route(
 *     "/something-crazy/{a}/{b}/{c}"
 * )
 */
public function something($a, $b, $c)
{
    //TODO Do something with $a, $b and $c.
}
```

You can also require that the parameters adhere to a certain regular expression. This example will match `/post/1`, `/post/2`, `/post/3` and so on but will not match something like `/post/abc`:

```php
use Sid\Framework\Router\Annotations\Route;

/**
 * @Route(
 *     "/post/{id}",
 *     requirements={
 *         "id"="\d+"
 *     }
 * )
 */
public function viewSingle($id)
{
    //TODO Do something with $id.
}
```

You can also specify which HTTP method to match (eg. `GET`, `POST`, `HEAD`, `PUT`, `DELETE`, `TRACE`, `OPTIONS`, `CONNECT`, `PATCH`):

```php
use Sid\Framework\Router\Annotations\Route;

/**
 * @Route(
 *     "/url",
 *     method="GET"
 * )
 */
public function get()
{
    //TODO
}

/**
 * @Route(
 *     "/url",
 *     method="POST"
 * )
 */
public function post()
{
    //TODO
}
```

By default, routes will only match `GET`.

### Converters

Converters are particularly useful at pre-processing URL parameters - for example, converting an ID number into an actual object. Any Converters you create must implement `\Sid\Framework\ConverterInterface` and, like with Controllers, you can inject any services you require via the constructor.

```php
namespace Converter;

use Doctrine\ORM\EntityManager;
use Post;
use Sid\Framework\ConverterInterface;
use Sid\Framework\Router\Exception\RouteNotFoundException;

class PostConverter implements ConverterInterface
{
    protected $doctrine;

    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }



    public function convert(string $id) : Post
    {
        $postRepository = $this->doctrine->getRepository(
            Post::class
        );

        $post = $postRepository->find($id);

        if (!$post) {
            throw new RouteNotFoundException();
        }

        return $post;
    }
}
```

By throwing `\Sid\Framework\Router\Exception\RouteNotFoundException`, you can trigger a 404 error. In the above example, if the Post object cannot be found in the database, this exception is thrown to avoid having to deal with in the action method.

When using Converters, you can also typehint the action method to enforce the object type which is especially useful in testing and debugging:

```php
use Post;
use Sid\Framework\Router\Annotations\Route;

/**
 * @Route(
 *     "/post/{post}",
 *     requirements={
 *         "post"="\d+"
 *     },
 *     converters={
 *         "post"="Converter\PostConverter"
 *     }
 * )
 */
public function viewSingle(Post $post)
{
    //TODO Do something with the $post object.
}
```

### Middleware

Middlewares are run by the Router when it is trying to find a matching Route. If the Route matches the URL pattern, the Router will run the Middlewares which are able to perform additional checks to determine whether the Route should match or not. By returning `false` in a Middleware, the Router will ignore the action and assume that it is not suitable for the particular URL.

Any Middlewares you create must implement `\Sid\Framework\MiddlewareInterface` and, like with Controllers and Converters, you can inject any services you require via the constructor.

```php
namespace Middleware;

use Sid\Framework\MiddlewareInterface;
use Sid\Framework\Router\Route;

class IsLoggedInMiddleware implements MiddlewareInterface
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }



    public function middleware(string $uri, Route $route) : bool
    {
        return $this->auth->isLoggedIn();
    }
}
```

(The `Auth` class is not shown and is just used as an example)

This is useful for when you want to separate the controller logic into two or more distinct use cases. For example, you may want to separate guests and logged in users:

```php
use Sid\Framework\Controller;
use Sid\Framework\Router\Annotations\Route;

class UserController extends Controller
{
    /**
     * @Route(
     *     "/something",
     *     middlewares={
     *         "Middleware\IsLoggedOutMiddleware"
     *     }
     * )
     */
    public function guest()
    {
        //TODO
    }

    /**
     * @Route(
     *     "/something",
     *     middlewares={
     *         "Middleware\IsLoggedInMiddleware"
     *     }
     * )
     */
    public function user()
    {
        //TODO
    }
}
```

(`Middleware\IsLoggedOutMiddleware` is not shown but performs as you'd expect)

You can even create action methods with multiple Middlewares. If any of them of fail, the action will fail to match:

```php
use Sid\Framework\Router\Annotations\Route;

/**
 * @Route(
 *     "/something",
 *     middlewares={
 *         "Middleware\OneMiddleware",
 *         "Middleware\AnotherMiddleware",
 *         "Middleware\AndAnotherMiddleware"
 *     }
 * )
 */
public function something()
{
    //TODO
}
```

### Return Handlers

Return Handlers are used as a way to standardise the Kernel output. Prepackaged are:
- `\Sid\Framework\Kernel\ReturnHandler\Response` (Symfony HTTP Responses)
- `\Sid\Framework\Kernel\ReturnHandler\ExitCode` (useful for CLI apps)

They are not required and you can chain them together by adding multiple Return Handlers to the Kernel:

```php
$kernel->addReturnHandler(
    new \Sid\Framework\Kernel\ReturnHandler\Response()
);
```

To create your own, implement `\Sid\Framework\Kernel\ReturnHandlerInterface`.
