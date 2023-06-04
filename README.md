## Jorge's Front-end Developer Testing Project

The goal of this project is to create a "Task Manager" web application with Vue.js and Laravel as the backend API.

### Features

- User can view a list of tasks in a table (display task name, description, and status).
- User can click on a task to view more information about it (additional info such as task deadline, priority, etc.) on a modal in the same page.
- User can "take on" a task by clicking an action button in the table row. This updates the task's status to "In Progress".
- User can update a task's information and status ("In Progress", "Completed", etc.).
- User can mark a task as "Complete" with an action button on the task view.

### Specifics

- Implement the front-end using Vue.js. You can use other libraries or frameworks (like - Bootstrap or Tailwind CSS) for styling, but the interactive elements should primarily be implemented with Vue.js.
- Implement the back-end API using Laravel. The API should support operations to create, read, update, and delete (CRUD) tasks.
- For the purpose of this project, you can use a local SQLite database, or another database of your choice. You should use Laravel's Eloquent ORM for database operations.
- You can use dummy data for the task list.
- The project should include error handling. For example, it should handle the case where a request to the Laravel API fails.
- Include instructions on how to set up and run your project.

### Using this project

If you'd like to use this as the starting point, you can remove the boilerplate and install what you need. The focus should remain on the front-end task. You can also check Laravel Documentation on [how to get starte with Laravel](https://laravel.com/docs/10.x/installation)

To use this project you can clone this repo and start the application setup, make sure you have `PHP/composer` and `Docker` installed:
-  Save the file `.env.example` as `.env`
-  Run `composer install` To install dependencies
-  Bring the laravel sail containers up with `./vendor/bin/sail up -d`
-  Run `./vendor/bin/sail npm install` To use the npm from the default docker provided by Laravel Sail 
-  Run `./vendor/bin/sail artisan migrate` To initialize the sqlite database (it should create database/database.sqlite file)
-  Run `./vendor/bin/sail npm run build` To build and to watch for changes replace `build` with `dev`
-  Go to http://localhost:8080 and register an account, on the dashboard page you can work on the task

![Preview](./preview.jpg?raw=true "Dashboard Preview")

### Submission

Please submit a link to a GitHub repository containing your project. The repository should include all code for the project, as well as a README with setup and run instructions.
