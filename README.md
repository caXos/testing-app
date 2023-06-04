## Jorge's Front-end Developer Testing Project

The goal of this project is to create a "Task Manager" web application with Vue.js and Laravel as the backend API.

### Features

- User can view a list of tasks in a table (display task name, description, and status).
- User can click on a task to view more information about it (additional info such as task deadline, priority, etc.) on a modal in the same page.
- User can "take on" a task by clicking an action button in the table row. This updates the task's status to "In Progress".
- User can update a task's information and status ("In Progress", "Completed", etc.).
- User can mark a task as "Complete" with an action button on the task view.

### Specifics

- Implemented the front-end using Vue.js. Used Tailwind CSS for styling. Interactive elements are implemented with Vue.js
- Implemented the back-end API using Laravel. The API supports operations to create, read, update, and delete (CRUD) tasks.
- Used PostgreSQL. Used Laravel's Eloquent ORM for database operations.
- Dummy data can be used running `php artisan migrate:fresh --seed` or just `php artisan db:seed`
- The project includes error handling.
- Included these instructions on how to set up and run this project.

### Using this project

To use this project you can clone this repo and start the application setup, make sure you have `PHP/composer` and `Docker` installed:
-  Save the file `.env.example` as `.env`
-  Run `composer install` To install dependencies
-  Bring the laravel sail containers up with `./vendor/bin/sail up -d`
-  Run `./vendor/bin/sail npm install` To use the npm from the default docker provided by Laravel Sail 
-  Run `./vendor/bin/sail artisan migrate` To initialize the PostgreSQL database
-  Run `./vendor/bin/sail artisan migrate:fresh --seed` To initialize the PostgreSQL database and create dummy data, or just `./vendor/bin/sail artisan db:seed` after running the migrate command
-  Run `./vendor/bin/sail npm run build` To build and to watch for changes replace `build` with `dev`
-  Run `./vendor/bin/sail php artisan serve` to deploy 
-  Go to http://localhost:8080 and register an account, on the dashboard page you can work on the task

### Submission

Please submit a link to a GitHub repository containing your project. The repository should include all code for the project, as well as a README with setup and run instructions.
