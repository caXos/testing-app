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
- Update `.env` as needed, for example for DB connection. Suggestion:
```
(...)
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=DEV_nwta
DB_USERNAME=newswiretestinguser
DB_PASSWORD=newswiretestingpswd
(...)
```
-  Run `composer install` To install dependencies
-  Bring the laravel sail containers up with `./vendor/bin/sail up -d`
-  Run `./vendor/bin/sail npm install` To use the npm from the default docker provided by Laravel Sail 
-  Run `./vendor/bin/sail artisan migrate` To initialize the PostgreSQL database
-  Run `./vendor/bin/sail artisan migrate:fresh --seed` To initialize the PostgreSQL database and create dummy data, or just `./vendor/bin/sail artisan db:seed` after running the migrate command
-  Run `./vendor/bin/sail npm run build` To build and to watch for changes replace `build` with `dev`
-  Run `./vendor/bin/sail php artisan serve` to deploy 
-  Go to http://localhost:8080 and register an account, on the dashboard page you can work on the task
-  At the top right of the landing page, user can click on Login to go to the login page, or click Register to go to the register page
-  At the Register page, user must fill the form with First Name, Last Name, email and password, then click Register
-  At the Login page, user must fill email and password then click Login button
-  After login, user will be taken to the main Dashboard page, which shows a card with the ammount of active tasks (not considering the done tasks)
-  Clicking in the Task card on the main dashboard or the Task option in the navigation bar, at the top, will take the user to the Tasks Dashboard
-  At the tasks dashboard, user can see how many tasks there are, with few columns as information: Number, Name, description, deadline and some actions
-  Here user can type something in the Search text field at the top to filter entries, considering all columns
-  User can use the Advanced search button, at the top left of the dashboard, to build more complex searches
-  User can also sort entries, clicking in the icons on the first row.
-  To create a new task, user can click on the + floating action button, at the bottom right of the screen. This will take the user to the task form page.

####  Actions:
-  User can click the (i) icon to open a modal with some more details on the task
-  User can click the pencil icon to open the form to edit the task
-  If a user is not in the taskforce for a task, he/she can click on the hand icon to join the taskforce of a team. This will also change the status of the task to "In progress". A modal for confirmation will be show before changes are applied.
-  If a user is already in the taskforce for a task, he/she the hand icon will not be shown, and an arrow-to-the-left icon will be in its place. Clicking in it will make the user leave the taskforce, but will not change the task's status. A modal for confirmation will be show before changes are applied.
-  If a task status is not "Done", a check icon will be shown. Clicking it will let the user mark the task as completed. A modal for confirmation will be show before changes are applied.

####  Task Form:
-  In this page, user must fill some required information (name, status and priority) as well as some optional information (description, deadline and taskforce worker)
-  Choosing a user name from the Worker select menu will add this user to the taskforce, and a new section and an icon will be shown.
-  To remove one user from the taskforce, just click on his/her icon.
-  To remove all users from the taskforce, click on the x button at the right
-  To create a new task, click the Add button
-  When editting a task, the Add button will be replaced by the Update button
-  When editting a task, a Delete button will also appear. Clicking on it shows a modal with a prompt, asking user to confirm the deletion of the task.
-  To go back to the dashboard, there is the Cancel button

####  Update user information
-  At the top right, click the user's name to open a small select with two options: the first, profile, takes the user to his/her profile update page, where he/she can update personal information, such as the password, and even delte his/her account.
-  The other option logs the user out of the system, and back to the login page.