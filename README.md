## Get Started

This guide will walk you through the steps needed to get this project up and running on your local machine.

### Prerequisites

Before you begin, ensure you have the following installed:

- Docker
- Docker Compose

### Building the Docker Environment

Build and start the containers:

```
docker-compose up -d --build
```

### Installing Dependencies

```
docker-compose exec app sh
composer install
```

### Database Setup

Set up the database:

```
bin/cake migrations migrate
```

### Accessing the Application

The application should now be accessible at http://localhost:34251

## How to check


### Preparation
- 1/ add column "like_count" to articles migration
- 2/ add column "token" to users migration
- 3/ add seed for articles, users 
- 4/ run migrate command
```
bin/cake migrations migrate
```
- 5/ run seed command
```
bin/cake migrations seed --seed UsersSeed
bin/cake migrations seed --seed ArticlesSeed
```

### Authentication

TODO: pls summarize how to check "Authentication" bahavior

Use plugin api-token-authenticator to check authentication api
```
- 1/ install package #rrd108/api-token-authenticator": "^0.4"#
- 2/ add new field name token into users table
- 3/ add plugin ApiTokenAuthenticator into Application.php
- 4/ load component Authentication.Authentication into AppController.php
- 5/ use api Login to get token 
- 6/ add this token to header when call API. this token will be authenticated by plugin authentication
- 7/ you can set public for some api "view" "index" "login" by using method allowUnauthenticated
```

### Article Management

TODO: pls summarize how to check "Article Management" bahavior
```
- 1/ create model (entity,table) for articles by using command bin/cake bake model articles
- 2/ create controller for articles by using command bin/cake bake controller articles
- 3/ change viewClasses of AppController to JsonView::class
- 4/ add json extension and Article resource  to routes
- 5/ modify actions in ArticlesController to build serialize response
- 6/ set public for "view", "index" api by using method allowUnauthenticated
- 7/ add check author of article when call delete or edit api.
```
### Like Feature

TODO: pls summarize how to check "Like Feature" bahavior
```
- 1/ create new table likes by command
bin/cake bake migration CreateLikes article_id:integer user_id:integer created_at updated_at
- 2/ add new field like_count into articles table to view like count when get an article
- 3/ add behavior "CounterCache" to LikesTable refer to like_count
- 4/ add "cascadeCallbacks" to relation Likes in ArticlesTable to update like_count when like an article
- 5/ create action "like" in ArticlesController
- 6/ check article exist and like exist with condition authenticated user and article, if this article has not liked by this user, make it liked!
- 7/ because we set public only for "view", "index" api, so #like" action was valid only for authenticated user
```
LOGIN info:
```
email: "admin@admin.com"
password: "123456'
```

AUTHENTICATION 
header param
```
Token:"key-from-login-api"
```
============USERS Management API============

Login
```
POST: http://localhost:34251/api/users/login.json
    body {"email": "admin@admin.com", "password": "123456"}
```
Logout
```
GET: http://localhost:34251/api/users/logout.json
```
List
```
GET: http://localhost:34251/api/users.json
```
Add
```
POST: http://localhost:34251/api/users.json
    body {"email": "email@email.com", "password": "password"}
```
Edit
```
PUT: http://localhost:34251/api/users/{id}.json
    body {"email": "email@email.com", "password": "password"}
```
Delete
```
DELETE: http://localhost:34251/api/users/{id}.json
```

============ARTICLES Management API============

List
```
GET: http://localhost:34251/api/articles.json
```
Add
```
POST: http://localhost:34251/api/articles.json
    body {"title": "title", "body": "body"}
```
Edit
```
PUT: http://localhost:34251/api/articles/{id}.json
    ody {"title": "title", "body": "body"}
```
Delete
```
DELETE: http://localhost:34251/api/articles/{id}.json
```
like
```
GET: http://localhost:34251/api/articles/like/{id}.json
```