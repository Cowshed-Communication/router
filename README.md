# WordPress Router

This package allows you to register hard-coded WordPress pages. 

Under the hood, it creates CMS-based pages which are stored in the database.

This package is very useful for plugins or themes which have pre-determined content, such as dashboards with 
their own templates on a specific route. 

## Usage
To prevent any unintended behaviour, use this package's functionality inside the `init` hook.

Register Routes:

```php

add_action( 'init', function () {
    $router = new Router();
    $router->route( [
        'name'     => 'home', // slug my-custom-route
        'template' => 'views/template-home.blade.php', // template path
        'ref'      => 'home', // reference for URL fetching
    ] )->route( [
        'name'     => 'about us',
        'template' => 'views/template-about.blade.php',
        'ref'      => 'about',
    ] )->bind();
} );

```

Get a route URL:

```php 

\Cowshed\Router\Router::url('test')

```

Most methods in the Router class are chainable.

## Methods

### route

Add a route to the list.

Params:

- route - Array - containing `name`, `template` & `ref` keys.

Return:

- Router instance

### bind

Create pages for the routes.

Return:

- Router instance

### url - static

Fetch the URL for a specified route.

Params:

- ref - String - The route reference as specified in the `route` call.

Return:

- mixed string|False-  url if found, false if not.

### errors


Return an array of errors and notices.

Return:

- Array - list of errors & notices. 
