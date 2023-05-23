# Dev Challenge

## Summary

This project correspond to the backend coding challenge with the following characteristics:

The API has to fulfill the following conditions:

- Endpoints for authentication using JWT.
  Also an endpoint for refreshing the JWT access token.
- Endpoint for retrieving movies.
  It should be allowed to filter and sort by some field.
- Endpoint for retrieving the information (director included) of a specific episode of a TV Show
- Endpoint for adding a new object (it could be for any entity you like).

Entities to consider:

- Movie  
  Has many actors, but one director.
- TV Show  
  Has many actors, but one director. It also has seasons and episodes inside each of one.
- Actor  
  Can be on different movies and tv shows.
- Director  
  Can direct many movies and specific episodes of tv shows.

## Requirements

Functioning PHP 7+ installation, docker. 

## Installation

clone the repository

```
git clone git@github.com:juanfgs/dev-challenge.git
```

install dependencies

```
composer install 
```

run sail to execute the project

```
vendor/laravel/sail/bin/sail up -d
```

Generate JWT tokens

```
vendor/laravel/sail/bin/sail jwt:generate

vendor/laravel/sail/bin/sail jwt:secret
```



This will build the containers and execute the API on port 80

### Seeding the database

run the following command to create the database.

```
sail artisan db:seed 
```

### Endpoints

A [postman collection](https://raw.githubusercontent.com/juanfgs/dev-challenge/main/docs/Movies%20API.postman_collection.json) is provided for convenience testing the API.



POST /api/login

```
{
    "email": "test@test.com",
    "password": "default_password"
}
```

POST /api/register

```
{
    "name": "John Doe",
    "email": "test@cdsa.com",
    "password": "asdasd123"
}
```

GET /api/movies/

###### Response 200 OK

```
{
    "success": true,
    "message": {
        "current_page": 1,
        "data": [
            {
                "id": 9,
                "title": "Bud Sauer",
                "director_id": 18,
                "genre": "Dr. Dino Ortiz II",
                "pg_rating": "13",
                "synopsis": "Eius amet dolorum et minus aliquam autem. Minus iure nam excepturi enim qui. Iusto vitae fuga expedita error dolor eaque velit.",
                "created_at": "2023-05-23 17:50:46",
                "updated_at": "2023-05-23 17:50:46",
                "release_date": "1997-02-07"
            }
       ],
        "first_page_url": "http://localhost/api/movies?page=1",
        "from": 1,
        "last_page": 2,
        "last_page_url": "http://localhost/api/movies?page=2",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost/api/movies?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": "http://localhost/api/movies?page=2",
                "label": "2",
                "active": false
            },
            {
                "url": "http://localhost/api/movies?page=2",
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": "http://localhost/api/movies?page=2",
        "path": "http://localhost/api/movies",
        "per_page": 15,
        "prev_page_url": null,
        "to": 15,
        "total": 16
    }
      
}
```

###### Query parameters

- **title** : *filter by movie title*

- **release_date_from** : *filter movies from certain date*

- **release_date_to** : *filter movies until certain date*

- **director** : *filter by Director Name*

- **sort_by** : *it allows to sort by fields (title, release_date, director)*



POST /api/movies 

###### Response 200 OK

```
{
    "title": "fdsafdsafdsa",
    "synopsis": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque efficitur justo eget diam lacinia ultrices. Nulla egestas orci orci, in euismod risus mattis semper. Cras luctus sagittis condimentum. Pellentesque porta justo nec massa iaculis, sit amet pharetra nibh fringilla. Sed efficitur ut mauris congue tempus. Aenean sit amet blandit ipsum, quis aliquam elit.",
    "genre": "Sci-Fi",
    "pg_rating": "13",
    "release_date": "2021-09-03",
    "director_id": 11,
    "updated_at": "2023-05-23T18:34:34.000000Z",
    "created_at": "2023-05-23T18:34:34.000000Z",
    "id": 19,
    "director": {
        "id": 11,
        "name": "Janie Paucek",
        "date_of_birth": "2011-03-05",
        "created_at": "2023-05-23T17:50:45.000000Z",
        "updated_at": "2023-05-23T17:50:45.000000Z"
    }
}
```

###### Response 422 Unprocessable content

###### JSON SCHEMA

```
{
    "title": "Dune",
    "synopsis": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque efficitur justo eget diam lacinia ultrices. Nulla egestas orci orci, in euismod risus mattis semper. Cras luctus sagittis condimentum. Pellentesque porta justo nec massa iaculis, sit amet pharetra nibh fringilla. Sed efficitur ut mauris congue tempus. Aenean sit amet blandit ipsum, quis aliquam elit.",
    "genre": "Sci-Fi",
    "pg_rating": "13",
    "release_date" : "2021-09-03",
    "director_id": 11
}
```

PATCH /api/movies/{id}

###### Response 200 OK

```
{
    "title": "Dune",
    "synopsis": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque efficitur justo eget diam lacinia ultrices. Nulla egestas orci orci, in euismod risus mattis semper. Cras luctus sagittis condimentum. Pellentesque porta justo nec massa iaculis, sit amet pharetra nibh fringilla. Sed efficitur ut mauris congue tempus. Aenean sit amet blandit ipsum, quis aliquam elit.",
    "genre": "Sci-Fi",
    "pg_rating": "13",
    "release_date" : "2021-09-03",
    "director_id": 11
}
```

DELETE /api/movies/{id} 

###### Response 202 OK

GET /api/episodes/{id}

```
{
    "id": 11,
    "name": "Marilou Fritsch",
    "director_id": 26,
    "pg_rating": "13",
    "synopsis": "Esse nisi numquam ipsam ratione. Error facere est ipsum qui asperiores voluptas quia. Quam et voluptatum quibusdam laborum dicta.",
    "created_at": "2023-05-23T17:50:46.000000Z",
    "updated_at": "2023-05-23T17:50:46.000000Z",
    "series_id": 2,
    "director": {
        "id": 26,
        "name": "Garfield Homenick",
        "date_of_birth": "1992-09-02",
        "created_at": "2023-05-23T17:50:46.000000Z",
        "updated_at": "2023-05-23T17:50:46.000000Z"
    },
    "series": {
        "id": 2,
        "name": "Clemens Koss",
        "genre": "Prof. Carlotta Roberts",
        "description": "Maxime atque quo eos. Est iste voluptatem ut doloremque amet. Accusamus quas necessitatibus ab quae.",
        "created_at": "2023-05-23T17:50:46.000000Z",
        "updated_at": "2023-05-23T17:50:46.000000Z",
        "actors": [
            {
                "id": 84,
                "name": "Ona Zemlak",
                "height": "2",
                "date_of_birth": "2000-09-24",
                "created_at": "2023-05-23T17:50:46.000000Z",
                "updated_at": "2023-05-23T17:50:46.000000Z",
                "pivot": {
                    "series_id": 2,
                    "actor_id": 84
                }
            }
      }
}
```

###### Response 200 OK
