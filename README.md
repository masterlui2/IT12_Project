
# IT12_Project

## Setup Instructions

### Requirements

- PHP >= 8.2
- Composer
- Node.js and NPM
- MySQL or other supported DB
- Laravel 10.x

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/masterlui2/IT12_Project.git
   cd IT12_Project

2. composer install

3. npm install

4. npm run dev

5. cp .env.example .env

6. php artisan key:generate

7. DB_DATABASE=your_db
    DB_USERNAME=your_user
    DB_PASSWORD=your_password

8. php artisan migrate

9. php artisan serve

### Usage
Once the server is running, visit [http://127.0.0.1:8000] in your browser.

# Laravel + Livewire Starter Kit

## Introduction

Our Laravel + [Livewire](https://livewire.laravel.com) starter kit provides a robust, modern starting point for building Laravel applications with a Livewire frontend.

Livewire is a powerful way of building dynamic, reactive, frontend UIs using just PHP. It's a great fit for teams that primarily use Blade templates and are looking for a simpler alternative to JavaScript-driven SPA frameworks like React and Vue.

This Livewire starter kit utilizes Livewire 3, Laravel Volt (optionally), TypeScript, Tailwind, and the [Flux UI](https://fluxui.dev) component library.

If you are looking for the alternate configurations of this starter kit, they can be found in the following branches:

- [components](https://github.com/laravel/livewire-starter-kit/tree/components) - if Volt is not selected
- [workos](https://github.com/laravel/livewire-starter-kit/tree/workos) - if WorkOS is selected for authentication

## Official Documentation

Documentation for all Laravel starter kits can be found on the [Laravel website](https://laravel.com/docs/starter-kits).

## Contributing

Thank you for considering contributing to our starter kit! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## License

The Laravel + Livewire starter kit is open-sourced software licensed under the MIT license.
