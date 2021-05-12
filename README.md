##Bigfish Próbafeladat

The application will be available at <b>http://localhost:8080/graphql</b> 

####Install and build docker container:
```
git clone https://github.com/pingserv/Bigfish.git
cd Bigfish
docker-compose build
docker-compose up -d
docker-compose exec app composer install
docker-compose exec app chown -R www-data:www-data ./
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan migrate --seed
```

####Get Users:
Arguments is optional
```
{
    users(limit:10, page: 1, order: "id", dir: "asc") {
        data {
            id
            name
            email
            dateOfBirth
            phoneNumber {
                phoneNumber
            }
            isActive
        },
        total,
        per_page
    }
}
```

####Get user:
```
{
  user(id:1) {
    id,
    name,
    email,
    dateOfBirth,
    phoneNumber {
        phoneNumber
    }
    isActive
  }
}
```

####Create user:
```
mutation createUser {
  createUser(name: "John Doef", email: "johndoef@gmail.com", dateOfBirth: "2000-01-10", isActive: true, password: "pass", password_confirmation: "pass") {
    id
    name
    email
  }
}
```

####Update user:
Arguments is optional
```
mutation updateUser {
  updateUser(id: 104, name: "Kiss Ervin", email: "pingserv@gmail.com", dateOfBirth: "2000-01-10", isActive: false) {
    id
    name
    email
  }
}
```

####Delete user:
```
mutation deleteUser {
  deleteUser(id: 1)
}
```

####Unit test
To run the unit test execute the following command
```
docker-compose exec app php artisan test --testsuite=Unit
```