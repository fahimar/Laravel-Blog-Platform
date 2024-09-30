# Laravel Blog API

A RESTful API service built with Laravel to manage blog posts, comments, and user authentication. The API is designed to facilitate CRUD operations on posts and comments while ensuring secure user authentication and authorization through Laravel Sanctum.

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

## About

This project demonstrates the use of Laravel to build a robust RESTful API for managing blog posts and their associated comments. The primary goal is to provide a secure and efficient system that handles user registration, authentication, post creation, updates, deletion, and comment management.

Key features of the API include:

-   **User Authentication**: Registration and login with JWT tokens powered by Laravel Sanctum.
-   **CRUD Operations for Posts**: Create, retrieve, update, and delete blog posts.
-   **CRUD Operations for Comments**: Add, retrieve, and delete comments associated with blog posts.
-   **File Uploads**: Upload images associated with blog posts.

## Getting Started

### Step 1: Install Required Software

Before getting started, ensure you have the following software installed on your machine:

-   PHP >= 8.0
-   Composer
-   Git
-   MySQL (or any other supported database)

### Step 2: Clone the GitHub Repository

Clone this repository to your local machine:

```bash
git clone <repository-url>
```

### Step 3: Navigate to the Project Directory

```bash
cd <repository-directory>
```

### Step 4: Install Dependencies

Install all the dependencies required for the project:

```bash
composer install
```

### Step 5: Create a Copy of the Environment File

Duplicate the `.env.example` file and rename it to `.env`:

```bash
cp .env.example .env
```

### Step 6: Configure the Environment File

Open the `.env` file in a text editor and configure your database settings and other necessary environment variables.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog
DB_USERNAME=root
DB_PASSWORD=your_database_password

# Configure mail, cache, etc. as necessary
```

### Step 7: Generate Application Key

Generate the application key used by Laravel to encrypt sensitive data:

```bash
php artisan key:generate
```

### Step 8: Run Migrations

Run the database migrations to create the necessary tables for posts, comments, and users:

```bash
php artisan migrate
```

### Step 9: Serve the Application

Start the Laravel development server:

```bash
php artisan serve
```

Your application will be accessible at `http://127.0.0.1:8000`.

## API Usage

### Authentication

#### Registration and Login

-   **POST /register**: User registration.
-   **POST /login**: User login and receive JWT token.

### Authenticated Routes (Requires Sanctum token)

#### User Management

-   **GET /user**: Fetch authenticated user's information.
-   **POST /logout**: Log out the authenticated user.

#### Posts

-   **GET /posts**: Retrieve a paginated list of blog posts.
-   **POST /posts**: Create a new post (requires authentication).
-   **GET /posts/{id}**: Retrieve a specific blog post by ID.
-   **PUT /posts/{id}**: Update an existing post (only the post's creator can update).
-   **DELETE /posts/{id}**: Delete a specific post (only the post's creator can delete).

#### Comments

-   **GET /posts/{id}/comments**: Retrieve comments for a specific post.
-   **POST /posts/{id}/comments**: Add a comment to a post (requires authentication).
-   **DELETE /comments/{id}**: Delete a specific comment (only the comment's creator can delete).

#### File Uploads

-   **POST /upload**: Upload images for posts (requires authentication).

### Error Handling

-   All failed requests return error responses with appropriate status codes and messages.
-   **Validation Errors**: Validation error messages are returned with status code `403`.
-   **Unauthorized Access**: If a user attempts to access or modify a resource they do not own, they will receive a `403 Unauthorized` response.

## Routes Summary

Here’s a summary of the available routes and their corresponding HTTP methods:

| HTTP Method | Endpoint             | Description                              |
| ----------- | -------------------- | ---------------------------------------- |
| POST        | /register            | Register a new user                      |
| POST        | /login               | Login and generate a JWT token           |
| GET         | /user                | Get the authenticated user's information |
| POST        | /logout              | Log out the authenticated user           |
| GET         | /posts               | Retrieve a paginated list of all posts   |
| POST        | /posts               | Create a new post                        |
| GET         | /posts/{id}          | Get a specific post by ID                |
| PUT         | /posts/{id}          | Update a specific post (creator only)    |
| DELETE      | /posts/{id}          | Delete a specific post (creator only)    |
| GET         | /posts/{id}/comments | List all comments for a specific post    |
| POST        | /posts/{id}/comments | Add a comment to a specific post         |
| DELETE      | /comments/{id}       | Delete a specific comment (creator only) |
| POST        | /upload              | Upload files (authentication required)   |

## Middleware

The following middleware is used in the application:

-   **auth:sanctum**: Ensures that routes are accessible only to authenticated users using Laravel Sanctum tokens.

## Controllers

-   **LoginRegisterController**: Handles registration, login, fetching user details, and logout.
-   **PostController**: Manages CRUD operations for blog posts.
-   **CommentController**: Manages CRUD operations for comments associated with blog posts.
-   **UploadController**: Handles file uploads for images associated with posts.

## License

The Laravel framework and this project are open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
