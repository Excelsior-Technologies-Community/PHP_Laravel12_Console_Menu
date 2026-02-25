# PHP_Laravel12_Console_Menu

## Project Introduction

PHP_Laravel12_Console_Menu is a Laravel 12 project that demonstrates how to build interactive console-based menus using Laravel Artisan commands.

This project focuses on creating a structured and maintainable CLI (Command Line Interface) application inside Laravel without using any external packages.

It helps developers understand how Laravel's built-in console features can be used to create dynamic and user-friendly terminal applications.

------------------------------------------------------------------------

## Project Overview 

This project implements a custom Artisan command called:

```bash
php artisan menu:main
```

The command provides an interactive menu with the following features:

- Display current date and time

- Show Laravel framework version

- Accept user input via CLI

- Display formatted table output

- Continuous menu loop until user exits


The project demonstrates:

- Creating custom Artisan commands

- Using Laravel console helper methods

- Organizing command logic using private methods

- Building scalable CLI-based workflows

- Clean command structure in Laravel 12

------------------------------------------------------------------------

## Requirements

- PHP >= 8.2

- Composer

- Laravel 12

- XAMPP / WAMP / Laragon (optional, not required for CLI)

- Terminal / Command Prompt

------------------------------------------------------------------------

## Step 1: Create Laravel 12 Project

Open your terminal and run:

``` bash
composer create-project laravel/laravel PHP_Laravel12_Console_Menu "12.*"
```

Move into the project directory:

``` bash
cd PHP_Laravel12_Console_Menu
```

Check Laravel version:

``` bash
php artisan --version
```

------------------------------------------------------------------------

## Step 2: Create Console Command

Run:

``` bash
php artisan make:command MainMenuCommand
```

This will create:

app/Console/Commands/MainMenuCommand.php

------------------------------------------------------------------------

## Step 3: Configure the Command

Open:

app/Console/Commands/MainMenuCommand.php

Replace content with:

``` php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MainMenuCommand extends Command
{
    protected $signature = 'menu:main';
    protected $description = 'Interactive Laravel Console Menu';

public function handle()
{
    $this->info('====================================');
    $this->info('      Laravel 12 Console Menu       ');
    $this->info('====================================');

    while (true) {

        $choice = $this->choice(
            'Select an option',
            [
                'Show Date & Time',
                'Show Laravel Version',
                'Ask User Name',
                'Show Table Example',
                'Exit'
            ],
            0 // default selected index
        );

        switch ($choice) {
            case 'Show Date & Time':
                $this->showDateTime();
                break;

            case 'Show Laravel Version':
                $this->showLaravelVersion();
                break;

            case 'Ask User Name':
                $this->askUserName();
                break;

            case 'Show Table Example':
                $this->showTableExample();
                break;

            case 'Exit':
                $this->info('Goodbye! Have a great day!');
                return;
        }
    }
}

    private function showDateTime()
    {
        $this->line('Current Date & Time: ' . now());
    }

    private function showLaravelVersion()
    {
        $this->line('Laravel Version: ' . app()->version());
    }

    private function askUserName()
    {
        $name = $this->ask('What is your name?');
        $this->info("Hello, $name! Welcome to Laravel Console Menu.");
    }

    private function showTableExample()
    {
        $this->table(
            ['ID', 'Name'],
            [
                [1, 'Laravel'],
                [2, 'Console Menu'],
                [3, 'Artisan Command']
            ]
        );
    }
}
```

------------------------------------------------------------------------

## Step 4: Register Command (If Needed)

In Laravel 12, commands inside:

app/Console/Commands

are auto-discovered.

No manual registration is required.

------------------------------------------------------------------------

## Step 5: Run the Console Menu

Execute:

``` bash
php artisan menu:main
```

You will see an interactive menu in the terminal.

------------------------------------------------------------------------

## Output

<img width="1919" height="1096" alt="Screenshot 2026-02-25 164525" src="https://github.com/user-attachments/assets/f48db139-990f-4fc2-acf4-6057ec6037b1" />

<img width="1919" height="1099" alt="Screenshot 2026-02-25 164553" src="https://github.com/user-attachments/assets/ac7346ed-2b44-454a-9cef-615f7f2c1afb" />

------------------------------------------------------------------------

## Project Structure

```
PHP_Laravel12_Console_Menu/
│
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── MainMenuCommand.php
│   │
│   ├── Models/
│   │
│   └── Providers/
│
├── bootstrap/
│
├── config/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── routes/
│   ├── web.php
│   └── console.php
│
├── storage/
│
├── tests/
│
├── artisan
├── composer.json
├── composer.lock
└── README.md
```

------------------------------------------------------------------------

Your PHP_Laravel12_Console_Menu Project is now ready!
