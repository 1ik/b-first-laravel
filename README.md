# REST API with Laravel 10.x
## Getting Started
Then follow the process--
1. Install the dependencies

    ```shell
    composer install
    ```

2. Copy `.env.example` to `.env`

    ```shell
    cp .env.example .env
    ```

3. Generate application key

    ```shell
    php artisan key:generate
    ```

4. Start the webserver

    ```shell
    php artisan serve
    ```

That's mostly it! You have a fully running laravel installation with Sanctum, all configured.

## Database Migration and Seeding

Open your `.env` file and change the DATABASE options.

1. Create a new Database
     ```
      Now set it to you .env file
     ```

2. You can run both migrations and seeders together by simply running the following command

    ```shell
    php artisan migrate:fresh --seed
    ```

## Routes Documentation

Before experimenting with the following API endpoints, run your This project using `php artisan serve` command. For the next part of this documentation, we assumed that is listening at http://localhost:8000    


### User Authentication/Login (Admin)

Remember this project comes with the default admin user? You can log in as an admin by making an HTTP POST call to the following route.

```shell
http://localhost:8000/api/login
```

**API Payload & Response**

You can send a Form Multipart or a JSON payload like this.

```json
{
    "email":"admin@gmail.com",
    "password":"123456"
}
```
You will get a JSON response with user token. You need this admin token for making any call to other routes protected by admin ability.

```json
{
    "success": true,
    "token": "5|dInZazSqImdveTyuAX6y7CRHljAqTgOhqgKp7mbz6c6d94f3",
    "email": "admin@gmail.com",
    "name": "Admin",
    "expire": "2024-01-30T10:58:57.927747Z"
}
```

For any unsuccessful attempt, you will receive a 401 error response.

```json
{
    "error": 1,
    "message": "invalid credentials"
}

```