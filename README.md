# WordPress Router

This package allows you to register hard-coded WordPress pages. 

Under the hood, it creates CMS-based pages which are stored in the database.

This package is very useful for plugins or themes which have pre-determined content, such as dashboards with 
their own templates on a specific route. 

## Usage
To prevent any unintended behaviour, use this package's functionality inside the `init` hook.

```php
add_action( 'init', function () {
    $router = new Router();

    $router->route( [
        'name' => 'my custom route', // slug my-custom-route
        'template' => 'views/template-custom.blade.php' // template path
    ] )->bind();
} );
```
Most methods in the Router class are chainable.

## Methods

### route

Add a route to the list.

Params:

- route - Array - containing `name` & `template` keys.


Return:

- Router instance

### bind

Create pages for the routes.

Return:

- Router instance

### errors

Return an array of errors and notices.

Return:

- Array - list of errors & notices. 
