# To-do
Simple to-do app built with vanilla php and SQLite

## Features
- [ ] Add and view tasks
- [ ] Delete a task
- [ ] Complete a task
- [ ] Set a priority for my tasks
- [ ] View the tasks sorted by priority and name
- [ ] View the number of total and completed tasks

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

### URL Rewriting

The project includes a `.htaccess` file in the `public` directory – make sure it has been uploaded correctly.

```apache
DocumentRoot "/path/to/your/to-do/public"

<Directory "/path/to/your/to-do/public">
    AllowOverride All
</Directory>
```
