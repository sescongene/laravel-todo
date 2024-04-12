# Todo App

## Laravel and Nuxt3

### Core Libraries and Tech used

#### Backend

1. Laravel 11 (backend framework)
2. Lighthouse Laravel (graphql implementation)
3. Docker (development environment)
4. MySql (databawse)
5. Sanctum (for authentication)

### Frontend

1. Nuxt3 (frontend framework)
2. Nuxt Apollo Client (graphql client)
3. Nuxt UI (ui kit)
4. Pinia (store management)

### Repositories

https://github.com/sescongene/laravel-todo
https://github.com/sescongene/vue-todo

### Local environment setup

Backend

```
git clone https://github.com/sescongene/laravel-todo
cd larave-todo
```

Create .env and fill the mysql requirements

```
DB_CONNECTION=mysql
DB_HOST=todo_mysql
DB_PORT=3306
DB_DATABASE=todoapp
DB_USERNAME=todoapp
DB_PASSWORD=todoapp
```

Execute

```
docker compose up
```

ssh to container

```
docker exec -it todo_php /bin/sh
composer install
php artisan migrate
```

Frontend
Create .env and supply this parameter

```
GRAPHQL_URL=https://graphql.laradev.win/graphql
```

```
git clone https://github.com/sescongene/vue-todo
cd vue-todo
npm install
npm run dev
```

### Demo site

This is my personal hosting environment
https://graphql.laradev.win/graphql (graphql endpoint)
https://graphql.laradev.win/graphiql (graphql ui client)
https://todo.laradev.win/ (frontend ssr nuxt)

#### Test Account

user: admin@admin.com
pass: adminadmin

## Apporach

### Backend

I separated the frontend and backend project for cleaner implementation and avoid confusions. I created two separate projects Laravel 11 and Nuxt3 both on their latest versions.

I had to explore new changes in laravel 11 since the version is very new and alot of changes had been applied.

On the backend side I explored and used laravel lighthouse https://lighthouse-php.com/ to make the development faster since the documentation and the implementation is promising so I gave it a go. Its my first time working with GraphQL in laravel, but I have experience developing GraphQL on Python Django so I just have to learn how to use the library in Laravel.

I haven't used GraphQL for a whice since my recent projects used REST for their API's. My last implementation of graphQL was 3 years ago and on a pyhton django framework.

Sicne have a bit of time, I implemented sanctum for authentication on my app, registration and login/logout feature in the app.

I created Todo model which belongs to the User.

For queries and mutation I followed the guidelines in lighthouse documentation on how they implement the structure of the codebase.

Lastly I created a unit testing for most of my queries and mutation to ensure that the app is working as intended.

### Frontend

For front end, I spinup a fresh nuxt project installed nuxt ui and explored pinia for state management, since pinia's is also recommended in the nuxt3 documentation. But I am also experienced in working with vuex since it is widely used in vue/nuxt apps.

For communicating to the GraphQL server, I used nuxt-apollo module and used its composables it was quite good at the start but during the implementation of the authentication the library was really buggy and need to a bit of work around.

I tried to add the vue-draggable for draging of todos for ordering but the time to work on it is very hassle so I decided not to continue.
