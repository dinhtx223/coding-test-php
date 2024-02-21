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

Set up the sample-data for User and Article:

```
bin/cake migrations seed --seed UsersSeed
```
```
bin/cake migrations seed --seed ArticlesSeed
```

### Accessing the Application

The homepage should now be accessible at http://localhost:34251
The API should now be accessible at http://localhost:34251/api/*

## How to check

- Please use Postman on PC to check application

### Authentication

Sample User info created by Seeding:

```
email: "admin@admin.com"
password: "123456"
```

```
email: "user@user.com"
password: "123456"
```

Login to get token for Authentication

```
method POST: http://localhost:34251/api/users/login.json
    body {"email": "admin@admin.com", "password": "123456"}
```
#### Get the token from user data response to setup Authorization in Postman
1. Select tab Authorization in Postman
2. Chose Type "API key"
3. On the right side, config following:
- Add value "Token" for "Key" input
- Add token from login user data response above for "Value" input
- Chose "Header" for "Add to" Selection

### Article Management

1. #### Getting list articles

- Permission: All user.

```
method GET: http://localhost:34251/api/articles.json
```

2. ####  Get detail article by id

- Permission: All user.

```
method GET: http://localhost:34251/api/articles/1.json
```


3. ####  Create an article

- Permission: Authenticated users.

- Case 1: authenticated user ( require login )

```
method POST: http://localhost:34251/api/articles.json
    body {"title": "authenticated user title", "body": "authenticated user body"}
```

Response: 200. an article object created successfully.

- Case 2: Not authenticated user ( logout first by Logout API = GET: http://localhost:34251/api/users/logout.json)

```
method POST: http://localhost:34251/api/articles.json
    body {"title": "Not authenticated user Title", "body": "Not authenticated user Body"}
```

Response: 401 "Authentication is required to continue",

- Case 3: no body param

```
method POST: http://localhost:34251/api/articles.json
```

Response: 200: "Error when create article."


4. ####  Edit an article

- Permission: Authenticated users & article writer users.

- Case 1: authenticated user and the writer (require login by user 'admin@admin.com') 

```
method PUT: http://localhost:34251/api/articles/1.json
    {"title": "updated my post title", "body": "updated my post body"}
```

Response: 200. "Updated article successfully"

- Case 2: authenticated user and NOT the writer (require login by user 'user@user.com').

```
method PUT: http://localhost:34251/api/articles/1.json
    {"title": "updated other writer title", "body": "updated other writer body"}
```

Response: 401. "Unauthorized. You have no - Permission",

- Case 3: Not authenticated user ( require logout = GET: http://localhost:34251/api/users/logout.json)

```
method PUT: http://localhost:34251/api/articles/1.json
    {"title": "Not authenticated user title", "body": "Not authenticated user body"}
```

Response: 401. "Authentication is required to continue",

5. ####  Delete an article

- Permission: Authenticated users & article writer users.

- Case 1: authenticated user and the writer (require login by user 'user@user.com') 

```
method DELETE: http://localhost:34251/api/articles/2.json
```

Response: 200. "Deleted article successfully"

- Case 2: authenticated user and NOT the writer (require login by user 'admin@admin.com').

```
method DELETE: http://localhost:34251/api/articles/2.json
```

Response: 401. "Unauthorized. You have no - Permission",

- Case 3: Not authenticated user ( require logout )

```
method DELETE: http://localhost:34251/api/articles/1.json
```

Response: 401. "Authentication is required to continue",


### Like Feature

1. ####  Like an article

- Permission: Authenticated users     

- Case 1: authenticated user (require login) 

```
method GET: http://localhost:34251/api/articles/like/1.json
```

Response: 200. "You have liked this article successfully"

- Case 2: authenticated user & liked article (require login) 

```
method GET: http://localhost:34251/api/articles/like/1.json
```

Response: 200. "You liked this article before"

- Case 3: Not authenticated user

```
method GET: http://localhost:34251/api/articles/like/1.json
```

Response: 401. "Authentication is required to continue"

2. ####  View like count 

- Permission: All user 

- Case 1: detail article

```
method GET: http://localhost:34251/api/articles/1.json
```

Response: an article object with "like_count" field

- Case 2: list article

```
method GET: http://localhost:34251/api/articles.json
```

Response: an array of articles object with "like_count" field

### Common

- Not found article

```
method GET: http://localhost:34251/api/articles/99.json
method PUT: http://localhost:34251/api/articles/99.json
method DELETE: http://localhost:34251/api/articles/99.json
method GET: http://localhost:34251/api/articles/like/99.json

```

Response: "Record not found in table \"articles\"",