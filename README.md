# PHP Todo App
Simple to-do app built with vanilla php and SQLite.

## Features
- [x] Add and view tasks
- [x] Delete a task
- [x] Complete a task
- [x] Set a priority for my tasks
- [x] View the tasks sorted by priority and name
- [x] View the number of total and completed tasks

## Installation
This will guide you through the basic installation of the app. If you find any issues or want to request a feature, contact me at [@lodev09](https://github.com/lodev09).

### Server Requirements
* **Apache** (with mod_rewrite enabled)
* **PHP 7.3+** with the following extensions: `pdo`

### Installing

This project uses [Composer](https://getcomposer.org) to manage its dependencies and extensions. Before installing, you will need to [install Composer](https://getcomposer.org) on your machine. Afterwards, run this command within the root folder where `composer.json` is located:

```bash
composer install
```

### Configuration (.env)

This project uses the package [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) to store sensitive and private information like database credentials. The package includes an `.env` file that you can modify as needed. Save `sample.env` as `.env` in the root folder.

If you wish not to use `.env`, feel free to comment in `config.php` and modify the constants as needed.

```php
// load configuration
// $dotenv = Dotenv\Dotenv::create(ROOT_PATH, '.env');
// $dotenv->load();

// set the constant DB_PATH for example.
define('DB_PATH', 'path/to/todo.db');
```

### URL Rewriting

The project includes a `.htaccess` file in the `public` directory – make sure it has been uploaded correctly.

```apache
DocumentRoot "/path/to/your/to-do/public"

<Directory "/path/to/your/to-do/public">
    AllowOverride All
</Directory>
```
