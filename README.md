# Laravel Code Challenge

This challenge is to assess a small range of your Laravel knowledge. We would like you to spend no more than 2 hours on this task. It's not a problem if you don't finish everything in the task. The goal is to get a clear view of how you think and work.

## The Challenge
The challenge will contain a few core features most applications have. That includes connecting to an API, basic MVC, exposing an API, and finally tests.

The API we want you to connect to is https://official-joke-api.appspot.com/jokes/programming/ten/

The application should have the following features

### Must haves
- A web page that shows 3 random jokes
- A button to refresh the jokes on the page
- An API route should be available to fetch the 3 jokes for the page
- Create tests for the application
- Provide a README on anything we need to set up and test the application

### Nice to haves
- Authentication for the page should be done with a password 
- The API route is secured with a token

### Notes
HTML/CSS/JS styling is not required at all. It doesn't matter how this application looks, only how it functions.

## Implementation
This implementation contains two main components: an API endpoint for fetching jokes and a dashboard that displays those jokes. 
For authentication Laravel Breeze and Sanctum are used.

### Prerequisites
Please make sure you have he following installed:

- PHP 8.2
- Composer 
- Git 

### Installation and Setup
- Clone the repository.

- Install dependencies via composer install
```
  composer install
```
- Run database migrations and seeders.
```
  php artisan migrate 
  php artisan db:seed
```

### User Login
Users must first log in via the /login route. Use the following credentials for login:

**Email:** test@example.com

**Password:** Test@123

### Implementation Details
- User can see 3 random jokes on the dashboard after logging in. These jokes are updated when the Refresh button is clicked.
- There is an APIController that sends request to Jokes API endpoint. 
- The DashboardController gets the current user token and send it with the request to API controller that returns 3 random jokes.
- The User token is stored in the session upon login. It is stored and retrieved via the SessionTokenStorage facade.

### Testing
Tests contain Feature and Unit tests which are as follows:

#### Feature Tests
- **APIControllerTest:** Validates the /api/jokes endpoint to ensure that it provides random programming jokes.
- **DashboardControllerTest:** Verifies token handling, joke fetching, error messages, and logging on the dashboard.
- **AuthenticationTest:** Tests user login, logout, and the creation/removal of authentication tokens.

#### Unit Tests
- **SessionTokenStorageTest:** Tests storing and retrieving an access token from the session.
- **DatabaseSeederTest:** Tests database seeder and verifies that user is stored into the database.
