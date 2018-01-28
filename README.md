# Project Title

Login and password checker

## Getting Started

These instructions will get you a copy of the Symfony 3 project up and running on your local machine for development and testing purposes.

### Prerequisites

For the correct execution of the application a Redis server is needed:


```
https://www.digitalocean.com/community/tutorials/how-to-install-and-use-redis
```

### Installing


1. From application root execute composer install and enter parameter.yml data when the installer required them. (Redis host and port).

2. To load initial data into Redis server, the execution of this command is needed from the project root:

```
php bin/console app:load-initial-data
```
Users loaded in Redis and its corresponding passwords are:

| Username | Password |
| --- | --- |
| demogorgon | demogorgonpass |
| freddy | freddypass |
| whitewalker | whitewalkerpass |
| hannibal | hannibalpass |
| michaelmeyers | michaelmeyerspass |
| jason | jasonpass |
| leatherface | leatherfacepass |
| pennywise | pennywisepass |


3. From application root, run server:

```
php bin/console server:run
```

4. Test main exercise with this route and change the parameters in order to see all cases:

```
http://127.0.0.1:8000/check-login?username=demogorgon&pass=demogorgonpass
```

## Running the tests

From application root, execute tests with this command: ./vendor/bin/simple-phpunit 4 tests are in red because of the bonus exercice.


