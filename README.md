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
* Kernel: couples Router and Dispatcher together. It is better able to deal with 404 errors and returns Symfony Response objects.
* Router: takes a URL and determines which action method should be executed.
* Dispatcher: executes the Controller code.

### Controllers

All controllers should extend `\Sid\Framework\Controller` or implement `\Sid\Framework\ControllerInterface`. Specify what services you require in the method signature.

Every public method is classed as an action and, although they do not require a suffix (you're free to call it however you want), they must have a `\Sid\Framework\Router\Route\Uri` annotation.

```php
use Auth;
use Doctrine\ORM\EntityManager;
use Sid\Framework\Router\Route\Uri;

/**
 * @Uri("/this/is/your/url")
 */
public function index(Auth $auth, EntityManager $doctrine)
{
    //TODO
}
```

You can also create URLs with dynamic values by enclosing their identifier in curly brackets (eg. `{id}`). These values are available from the `Sid\Framework\Parameters` object:

```php
use Sid\Framework\Parameters;
use Sid\Framework\Router\Route\Uri;

/**
 * @Uri("/post/{id}")
 */
public function viewSingle(Parameters $parameters)
{
    $id = $parameters->get("id");

    //TODO Do something with $id.
}

/**
 * @Uri("/something-crazy/{a}/{b}/{c}")
 */
public function something(Parameters $parameters)
{
    $a = $parameters->get("a");
    $b = $parameters->get("b");
    $c = $parameters->get("c");

    //TODO Do something with $a, $b and $c.
}
```

The `$parameters` property can be anywhere in the method signature.

You can also require that the parameters adhere to a certain regular expression. This example will match `/post/1`, `/post/2`, `/post/3` and so on but will not match something like `/post/abc`:

```php
use Sid\Framework\Parameters;
use Sid\Framework\Router\Route\Uri;
use Sid\Framework\Router\Route\Requirements;

/**
 * @Uri("/post/{id}")
 *
 * @Requirements(
 *     id="\d+"
 * )
 */
public function viewSingle(Parameters $parameters)
{
    $id = $parameters->get("id");

    //TODO Do something with $id.
}
```

You can also specify which HTTP method to match (eg. `GET`, `POST`, `HEAD`, `PUT`, `DELETE`, `TRACE`, `OPTIONS`, `CONNECT`, `PATCH`):

```php
use Sid\Framework\Router\Route\Uri;
use Sid\Framework\Router\Route\Method;

/**
 * @Uri("/url")
 *
 * @Method("GET")
 */
public function get()
{
    //TODO
}

/**
 * @Uri("/url")
 *
 * @Method("POST")
 */
public function post()
{
    //TODO
}
```

By default, routes will only match `GET`.

### Converters

Converters are particularly useful at pre-processing URL parameters - for example, converting an ID number into an actual object. Any Converters you create must implement `\Sid\Framework\ConverterInterface` and you can inject any services you require via the constructor.

```php
namespace Converter;

use Doctrine\ORM\EntityManager;
use Post;
use Sid\Framework\ConverterInterface;
use Sid\Framework\Router\Exception\RouteNotFoundException;

class PostConverter implements ConverterInterface
{
    /**
     * @var EntityManager
     */
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

By throwing `\Sid\Framework\Router\Exception\RouteNotFoundException`, you can trigger a 404 error. In the above example, if the Post object cannot be found in the database, this exception is thrown to avoid having to deal with it in the action method.

```php
use Post;
use Sid\Framework\Parameters;
use Sid\Framework\Router\Route\Uri;
use Sid\Framework\Router\Route\Requirements;
use Sid\Framework\Router\Route\Converters;

/**
 * @Uri("/post/{post}")
 *
 * @Requirements(
 *     post="\d+"
 * )
 *
 * @Converters(
 *     post="Converter\PostConverter"
 * )
 */
public function viewSingle(Parameters $parameters)
{
    /**
     * @var Post
     */
    $post = $parameters->get("post");

    //TODO Do something with the $post object.
}
```

### Middleware

Middlewares are run by the Router when it is trying to find a matching Route. If the Route matches the URL pattern, the Router will run the Middlewares which are able to perform additional checks to determine whether the Route should match or not. By returning `false` in a Middleware, the Router will ignore the action and assume that it is not suitable for the particular URL.

Any Middlewares you create must implement `\Sid\Framework\MiddlewareInterface` and, like with Converters, you can inject any services you require via the constructor.

```php
namespace Middleware;

use Sid\Framework\MiddlewareInterface;
use Sid\Framework\Router\Route;

class IsLoggedInMiddleware implements MiddlewareInterface
{
    /**
     * @var Auth
     */
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
use Sid\Framework\Router\Route\Uri;
use Sid\Framework\Router\Route\Middlewares;

class UserController extends Controller
{
    /**
     * @Uri("/something")
     *
     * @Middlewares({
     *     "Middleware\IsLoggedOutMiddleware"
     * })
     */
    public function guest()
    {
        //TODO
    }

    /**
     * @Uri("/something")
     *
     * @Middlewares({
     *     "Middleware\IsLoggedInMiddleware"
     * })
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
use Sid\Framework\Router\Route\Uri;
use Sid\Framework\Router\Route\Middlewares;

/**
 * @Uri("/something")
 *
 * @Middlewares({
 *     "Middleware\OneMiddleware",
 *     "Middleware\AnotherMiddleware",
 *     "Middleware\AndAnotherMiddleware"
 * })
 */
public function something()
{
    //TODO
}
```
