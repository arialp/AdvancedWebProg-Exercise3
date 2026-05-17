# Advanced Web Programming - Exercise 3 (Project Management & Localization)

This is my submission for Exercise 3, which involves building an authentication system, a project management platform with role-based permissions, and full localization support for English and Polish within the Laravel framework.

## File Overview

To help navigate the project, here are the key components for this assignment divided by feature:

**Authentication**
* Handled entirely by **Laravel Breeze** (scaffolded into `app/Http/Controllers/Auth/`, `resources/views/auth/`, and `routes/auth.php`). Provides user registration, login, logout, and profile management out of the box.

**Project Management**
* **The Model:** `app/Models/Project.php` (Defines fillable attributes, date casting, and relationships to the manager and team members)
* **The Controller:** `app/Http/Controllers/ProjectController.php` (Full resource controller handling project CRUD. The `update` method checks the user's role: managers can modify all fields, while team members can only update the `done_jobs` attribute)
* **The Policy:** `app/Policies/ProjectPolicy.php` (Enforces authorization: only the manager or assigned team members can view/edit a project, and only the manager can delete it)
* **The Views:** `resources/views/projects/` (Contains `index.blade.php`, `create.blade.php`, `edit.blade.php`, and `show.blade.php`. The edit view conditionally renders either the full form for managers or a restricted `done_jobs`-only form for team members)

**Database Migrations**
* **Projects Table:** `database/migrations/2026_05_17_150340_create_projects_table.php` (Columns: `manager_id`, `name`, `description`, `price`, `done_jobs`, `start_date`, `end_date`)
* **Pivot Table:** `database/migrations/2026_05_17_150341_create_project_user_table.php` (Links users to projects as team members via a many-to-many relationship)

**Model Relationships**
* `app/Models/User.php` has two relationships: `managedProjects()` (`hasMany`) for projects the user created, and `joinedProjects()` (`belongsToMany`) for projects the user was added to as a team member.
* `app/Models/Project.php` has `manager()` (`belongsTo`) and `teamMembers()` (`belongsToMany`).

**Localization**
* **Translations:** `lang/en.json` and `lang/pl.json` (Contains all UI strings for the entire application including authentication pages, profile settings, dashboard, and project management views)
* **Middleware:** `app/Http/Middleware/SetLocale.php` (Reads the user's language preference from the session and applies it to each request)
* **Language Switcher:** A dropdown menu in the navigation bar (`resources/views/layouts/navigation.blade.php`) that allows switching between English and Polish via the `/locale/{lang}` route

---

## Installation and Setup

Here are the steps to get the project working locally for grading.

**1. Clone the repository:**
```bash
git clone https://github.com/arialp/AdvancedWebProg-Exercise3.git
cd laravel-exercise3
```

**2. Install dependencies:**
```bash
composer install
npm install
```

**3. Set up the environment:**
Copy the `.env.example` file and rename it to `.env`. Ensure you have an empty local MySQL database created called `projects`. Then, update the `.env` file with your credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=projects
DB_USERNAME=root
DB_PASSWORD=
```

**4. Generate the app key:**
```bash
php artisan key:generate
```

**5. Run the migrations:**
This will create the `users`, `projects`, and `project_user` tables along with the standard Laravel session and cache tables.
```bash
php artisan migrate
```

**6. Build the front-end assets:**
```bash
npm run build
```

---

## Running and Testing

Start the local development server:
```bash
php artisan serve
```

**Registration & Login:**
Navigate to `http://127.0.0.1:8000/register` and create two or more user accounts. These accounts will be used to test the manager and team member roles. After registering, you will be automatically logged in and redirected to the dashboard.

**Creating a Project:**
Click on "Projects" in the navigation bar, then click "Create New Project". Fill in the project details and use the checkboxes to assign other registered users as team members. The currently logged-in user is automatically set as the project manager.

**Testing Manager Permissions:**
As the project manager, navigate to a project's edit page. You will see the full form where you can modify all fields: name, description, price, done jobs, dates, and team members.

**Testing Team Member Permissions:**
Log out and log back in as a user who was added as a team member. Navigate to the same project's edit page. You will only see the `done_jobs` field, with a note explaining that as a team member, that is the only attribute you can modify.

**Testing Localization:**
In the navigation bar, click the language dropdown (displayed as "EN" or "PL") and switch between English and Polish. All UI elements—including the dashboard, profile settings, project pages, and authentication views—will translate accordingly.
