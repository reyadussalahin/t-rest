[![Build Status](https://img.shields.io/circleci/build/gh/reyadussalahin/t-rest/master?style=flat-square)](https://circleci.com/gh/reyadussalahin/t-rest/tree/master)
[![License](https://img.shields.io/github/license/reyadussalahin/t-rest?color=teal&style=flat-square)](https://github.com/reyadussalahin/t-rest/blob/master/LICENSE)


# t-rest
t-rest stands for template for rest. It is a template for rapid prototyping rest applications in php. It is build having clean architecture in mind.


## Getting Started

### Clone from github
Get t-rest from github using the following command:
```bash
$ git clone https://github.com/reyadussalahin/t-rest.git
$ cd t-rest
```

### Install dependencies
Install all dependencies using the following command:
```bash
$ composer install
```

### Setting up database server
This application uses postgresql server by default. But you can also use any other relational database server. Copy `database/config.example.php` to `database/config.php` and edit the `config` section as necessary.  
  
Then, run the following command:
```bash
$ php database/migrate.php
```
Also, note, you can add new tables in `database/migrate.php` file.

### Run tests
```bash
$ ./vendor/bin/phpunit
```

### Run developent server
If all tests run fine, then you can watch the api in action by just running the local server as follows:
```
$ php -c <path-to-php-ini> -t public -S 127.0.0.1:8000
```
Now, go to your browser and write the following in url bar:
```
http://127.0.0.1:8000/api/users
```
You'll see `[]`.  
  
You're seeing an empty array cause not user has been registered yet. To know how to register a user, read the `Api endpoints` section, which is given below.


## How to use
A "user" example is build into t-rest to showcase the usage of the api. You can check how to add urls, controllers, repositories and models and how to use the api endpoints.

### Api routes
Go to `routes/api.php` to add new urls. The files written as follows(a simple example):
```php
<?php
use App\Api\Controllers\UserController;

return [
    "GET" => [
        "/user/{id}" => [
            "name" => "user.show",
            "target" => [UserController::class, "show"],
            "filter" => [
                "id" => "[0-9]+"
            ]
        ]
    ]
]
```
Here `GET` is request format, `name` represents url's name, `target` represents controller class and method to target and `filter` is for filtering url parameters, and it uses regex to do that, you can see that `{id}` only takes one or more digits as input. The order of url parameters is followed while passing as parameters into method of controller class.

### Controllers
Check the example of below controller class:
```php
namespace App\Api\Controllers;

use HelloWorld\App\Controllers\Controller;
use App\Database\Repositories\UserRepository;

class UserController extends Controller {
    public function __construct($app) {
        parent::__construct($app);
    }
    
    // add other methods here
}
```
One rule you must follow, you've to extend the `HelloWorld\App\Controllers\Controller` class and pass `$app` into the parent constructor.

### Models
Models are for representing a single row of table data. Models only contain data. It does not perform any database operation. An exmaple of model could be:
```php
<?php
namespace App\Database\Models;

use App\Database\Models\Model;

class User extends Model {
    public function __construct() {
        $this->id()
            ->string("username")
            ->string("email")
            ->string("password");
    }
}
```
Added model must extend `App\Database\Models\Model` and inside constructor it must provide all fields name, which must be identical to column name of table.

### Repositories
Repositories are the ones that perform database operations. Repositories must extends `App\Database\Repositories\Repository` and connect proper tables with proper models. This is done by overriding two methods. An example is given below:

```php
<?php
namespace App\Database\Repositories;

use App\Database\Repositories\Repository;
use App\Database\Models\User;

class UserRepository extends Repository {
    public function __construct($app) {
        parent::__construct($app);
    }
    public function model() {
        return User::class;
    }
    public function table() {
        return "users";
    }
}
```

## Api endpoints
I am using `curl` to demonstrate the usage of api endpoints.

### Create a user
readable command:
```
POST - http://127.0.0.1:8000/api/user
{
    "username": "xyz",
    "email": "xyz@gmail.com",
    "password": "12345678"
}
```

curl command:
```bash
$ curl --header "Content-Type: application/json" \
    --request POST \
    --data '{ "username": "xyz", "email": "xyz@gmail.com", "password": "12345678" }' \
    http://127.0.0.1:8000/api/user
```

output:
```
{
    "status": "success"
}
```

### Read a user
readable command:
```
GET - http://127.0.0.1:8000/api/user/1
```

curl command:
```bash
$ curl --request GET \
    http://127.0.0.1:8000/api/user/1
```
output:
```
{
    "id": 1,
    "username": "xyz",
    "email": "xyz@gmail.com",
    "password": "12345678"
}
```

### Remove a user
readable command:
```
DELETE - http://127.0.0.1:8000/api/user/1
```

curl command:
```bash
$ curl --request DELETE \
    http://127.0.0.1:8000/api/user/1
```

output:
```
{
    "status": "success"
}
```

### Update a user
readable command:
```
PATCH - http://127.0.0.1:8000/api/user/1
{
    "password": "87654321"
}
```

curl command:
```bash
$ curl --header "Content-Type: application/json" \
    --request PATCH \
    --data '{ "password": "87654321" }' \
    http://127.0.0.1:8000/api/user/1
```

output:
```
{
    "status": "success"
}
```

### List of all users
readable command:
```
GET - http://127.0.0.1:8000/api/users
```

curl command:
```bash
$ curl --request GET \
    http://127.0.0.1:8000/api/users
```
output:
```
[
    {
        "id": 1,
        "username": "xyz",
        "email": "xyz@gmail.com",
        "password": "87654321"
    },
    {
        "id": 2,
        "username": "abc",
        "email": "abc@gmail.com",
        "password": "12345678"
    },
    {
        "id": 3,
        "username": "uvw",
        "email": "uvw@gmail.com",
        "password": "12345678"
    }
]
```

## LICENSE
To learn about the project license, visit [here](https://github.com/reyadussalahin/t-rest/blob/master/LICENSE).

## Contributing
For details on contribution please read the following this [guide](https://github.com/reyadussalahin/t-rest/blob/master/CONTRIBUTING.md).  
  
The project is ongoing and it has a lot of potential to grow. So, if you've any ideas or improvements, send a pull request. I'll have a look.
