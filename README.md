This is the book management system as the laravel developer application test.
after setting the application in your local computer and having created and connected the database, run the below comands to create tables and generate sample data
php artisan migrate
 php artisan db:seed --class=UsersTableSeeder 
php artisan db:seed --class=AuthorSeeder    
php artisan db:seed --class=BookSeeder 

make sure you run them in the sequence
after that you can go to this pathe \Sample Laravel projects\books_manager_test\tests\Feature and run the test in  BookControllerTest.php and AuthorControllerTest.php
If you wish to use Postman or other thirdparty software for api testing, here is the list of apis you can put to test and thier expected outcomes

Authentication

Login
Endpoint: POST /api/login
Description: Authenticate a user and generate a token.
Status Codes:
200 (OK) - Successful login
401 (Unauthorized) - Invalid credentials

Authenticated Routes that you'll to use the login tokens are: 
User Profile

Endpoint: GET /api/profile
Description: Retrieve the user's profile information.
Status Code:
200 (OK) - Successful retrieval
Logout

Endpoint: POST /api/logout
Description: Invalidate the user's token and log them out.
Status Code:
200 (OK) - Successful logout
Books

Get List of Books

Endpoint: GET /api/books
Description: Retrieve a list of all books in the database.
Status Code:
200 (OK) - Successful retrieval
Get Book Details

Endpoint: GET /api/book/{id}
Description: Retrieve details of the specified book by ID. Nest author details.
Status Codes:
200 (OK) - Successful retrieval
404 (Not Found) - Book not found
Create Book

Endpoint: POST /api/book
Description: Create a new book.
Status Code:
200 (OK) - Successful book creation
422 (Unprocessable Entity) - Validation error
Update Book

Endpoint: PUT /api/book/{id}
Description: Update details of the specified book by ID.
Status Codes:
200 (OK) - Successful update
404 (Not Found) - Book not found
422 (Unprocessable Entity) - Validation error
Authors

Get List of Authors

Endpoint: GET /api/authors
Description: Retrieve a list of all authors in the database.
Status Code:
200 (OK) - Successful retrieval
Get Author Details

Endpoint: GET /api/author/{id}
Description: Retrieve details of the specified author by ID.
Status Codes:
200 (OK) - Successful retrieval
404 (Not Found) - Author not found
Create Author

Endpoint: POST /api/author
Description: Create a new author.
Status Code:
200 (OK) - Successful author creation
422 (Unprocessable Entity) - Validation error

 
