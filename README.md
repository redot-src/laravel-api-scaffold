# Laravel API Scaffold

Welcome to the Laravel API Scaffold, a streamlined solution for establishing a consistent API structure within your Laravel application.

## Installation

Begin by installing the package via Composer:

```bash
composer create-project --prefer-dist redot/laravel-api-scaffold
```

And voila! You're all set to proceed.

## What's Included

Our package provides essential components to kickstart your API development:

- [Laravel Sanctum](https://laravel.com/docs/sanctum): Enables API authentication.
- [Spatie Laravel Query Builder](https://github.com/spatie/laravel-query-builder): Facilitates filtering, sorting, and relationship inclusion.

## Features

Experience the following features tailored for your convenience:

- Robust authentication system supporting multiple guards for admins and users.
- Integration of a settings model for seamless application settings management.
- Handpicked utilities to expedite your development journey.

## Directory Structure

We strive to maintain Laravel's default directory structure with some enhancements.

### Routes

As an API scaffold, we've made adjustments to the routes structure:

- `dashboard.php`: Houses dashboard routes, prefixed with `/dashboard`.
- `website.php`: Contains public website routes without any prefix.

### Controllers

Controllers are organized into two distinct directories:

- `Dashboard`: Dedicated to dashboard-related controllers.
- `Website`: Hosts controllers pertinent to the public website.

Each directory features a `Controller` class extending Laravel's default `Controller`, with additional functionalities.

#### `respond` Method

Easily handle action success responses with the `respond` method, supporting named parameters in PHP 8.

```php
public function index()
{
    return $this->respond(
        payload: ['foo' => 'bar'],
        message: 'This is a message',
        status: 200
    );
}
```

#### `fail` Method

Effortlessly manage action failure responses using the `fail` method.

```php
public function index()
{
    return $this->fail(
        message: 'This is a message',
        status: 400,
        payload: ['foo' => 'bar']
    );
}
```

### Requests

Similarly, requests are categorized into `Dashboard` and `Website` directories for clarity.

## Utilities

Benefit from our bundled utilities designed to simplify your workflow.

### `CanUploadFile` Trait

This trait facilitates file uploading within your application, offering methods like `uploadFile` and `deleteFile`.

### `FirebaseNotify` Trait

Streamline user notifications via Firebase Cloud Messaging with the `notify` method.

### `Setting` Model

The `Setting` model is your go-to solution for storing application settings, accessible via the `get` method or `setting` helper function.

```php
// Access settings using the model
Setting::get('foo');

// Or via the helper function
setting('foo');
```

Enjoy seamless performance with automated settings caching.

---

Embrace Laravel API development with ease, thanks to our intuitive scaffold. Happy coding!
