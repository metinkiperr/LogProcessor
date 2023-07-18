# loganalytics project
This project includes aggregated log file command and saves it into the database.
Also it includes an endpoint that returns the count of logs.

## Setup:
- Docker compose is required for setup.
- After docker-compose set up run:
```
  docker-compose up -d --build
  ```

- for entering the container please run
 ```
  docker-compose exec php bin/bash
  ```
- at the container please run 
```
  composer install 
  ```
- for running the test run in the container

```
  php/phpunit
  ```

Written in PHP8 Symfony 6