# Umubyeyi Elevate API

## Getting Started

These instructions will help to install project and run it on your local machine for development and testing purposes.
See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them
To work on this project you must have installed locally:

```
Php version 7.1.3
Apache server
MySQL
install Composer
```

### Installing

Once all required package are installed follow the following step:

#### Clone

```
Open your terminal

run git clone https://github.com/Creators-Agency/umubyeyiElevate.git

and navigate to umubyeyiElevate Directory
```

## run Composer

```
run composer install
```

## Generate .env file

```
cp .env.example .env
```

## Generate key

```
php artisan key:generate
```

## Migration

```
in .env file
replace DB connection info with yours

php artisan migrate
```

## Running the project

```
php artisan serve
```

-   remember to start your apache server

## Commit Drill

```
1. Create a new branch,
2. Name it according to the ticket card,
3. Push on the branch,
4. Create a pull request on staging,
5. Wait patiently for the final judgement.
```

## Built With

-   [Laravel](https://laravel.com/docs)

## Contributing

## Versioning

<!-- We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags).  -->

## Authors

-   **Creators** - _Initial work_ - [Creators](https://github.com/Creators-Agency)

See also the list of [contributors](https://github.com/orgs/Creators-Agency/teams/bravo-team) who participated in this project.

-   [Kevin Kayisire](https://github.com/kayisire)
-   [Valentin Niyonshuti](https://github.com/tinoxn)

## License

## Acknowledgments

-   Hat tip to anyone whose code was used
-   Inspiration
-   etc
