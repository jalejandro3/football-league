# SANTEX League Exercise

##Requirements
- "php": "^7.3|^8.0"
- "guzzlehttp/guzzle": "^7.0.1"

## Introduction

It was develop two APIs, the first one is use to get all the league information: competition, teams and players from https://www.football-data.org to save it into a database with the next structure:

1. **Competition**: name, code, areaName.
2. **League**: code, status. Status will be a field where the application verify is the league is already imported or not.
3. **Player**: team_id, name, position, dateOfBirth, countryOfBirth, nationality.
4. **Team**: name, tla, shortName, areaName, email.
5. **CompetitionTeam**: competition_id, team_id. A middle table, many to many to save the relation a competition has many teams and many teams can participate in many competitions.

**API endpoint**: `/import-league/{leagueCode}`

The second one is about to get the total amount of players belonging to all teams that participate in the given league.

**API endpoint**: `/total-players/{leagueCode}`

###Disclaimer
*The project was developed using Laravel Framework, so, all the artisan command must be execute inside the project root folde.*

## How to install
You will need to unzip the .rar file, inside you will find the project. In the root folder you will find the santex_league.sql file, you can use it to import the database structure, or, at the moment that the composer finish the installation this will run the commands to migrate all the tables structure and seed the league table with all the league codes availables in the TIER1 free account. I encourage to use the second one through the composer installation.

Go inside the project
`$ cd santex-league`

Run composer install
`$ composer install`

And that is all!.

## Configuration
The .env file must be created, inside it you can configure:

**FOOTBALL LEAGUE VARIABLES**
- FOOTBALL_LEAGUE_BASE_URL: The api base url (http://api.football-data.org/v2/).
- FOOTBALL_LEAGUE_TOKEN: Your API Football Data user token.

## How to use it
When the project is already installed, you can serve it running:

`$ php artisan serve`

This command serve our application into the localhost.

`Starting Laravel development server: http://127.0.0.1:8000`

## About the development
The application was thinking to use:

1. Client:
    - FootballClient: A custom client with a exec method that receive the endpoint and the request type.
2. Services:
    - LeagueService: A service with the logic to import and calculate the total amount of players.
3. Repositories: A layer with all the logic to manipulate the data into the database.
    - CompetitionRepository
    - LeagueRepository
    - PlayerRepository
    - TeamRepository
4. Helpers:
    - LeagueHelper: A helper that contains a global method to get the ids from the **competition_team** middle table.
5. Providers: The providers to configure all the custom services, repositories and helpers used into the app:
    - ClientServiceProvider
    - HelperServiceProvider
    - RepositoryServiceProvider
    - ServiceServiceProvider
6. Custom Exceptions: You can find a custom exceptions into the Exception folder:
    - ApplicationException: Used to throws all the 409 code.
        - Application Exception Messages:
            - 409: League already imported
    - InputValidationException: Used to throws invalid inputs.
        - Input Validation Exception Messages:
            - League Code must be uppercase.
            - Request Type is required.
    - ResourceNotFound: Used to throws 404 error
        - Resource Not Found Exception Messages:
            - Not found: League not found in league table, competition not found with a league code associated.
