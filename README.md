# Open Classrooms Study Project
the dependencies are not up to date and may be subject to security problems

# snowtricks
A community site for snow tricks lovers and learners

## Installation

- Clone the repository
- Install with composer (configure for Mysql, and SwiftMailer, within composer install or .env )
`composer install`
- Create the database
`php bin/console doctrine:database:create`
- Create the schema
`php bin/console doctrine:schema:create`
- Install initial data set with 10 marvelous snow tricks
`php bin/console app:generate-tricks`

Your are all set !
