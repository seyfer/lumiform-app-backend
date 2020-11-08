# About

This project was done as an interview project for Lumiformapp.

The project is composed of the frontend project, and the backend project.

You can check out the frontend project here: https://github.com/CharlieBrownCharacter/lumiform-app-frontend

# Pre requisites to run this project

- Have docker installed (https://docs.docker.com/get-docker/)
- Have docker compose installed (https://docs.docker.com/compose/install/)

# How to run this project

To run the backend project you will need to clone the repository:

```
git clone git@github.com:CharlieBrownCharacter/lumiform-app-backend.git && cd lumiform-app-backend && git checkout create-app
```

After that you will need to up all the containers with the following command:

```
docker-compose up -d
```

This command should copy your `.env.example` file to `.env` (as well as `.env.testing`). If this doesn't happen you
can copy the `.env.example` and re-name it to `.env` (the same for `.env.testing`)

For simplicity the variables are set for you but in case the OMDB variable doesn't work you can change the variable 
`OMDB_API_KEY` in `.env` file.

Visit `locahost` on your web browser, and you should see Laravel welcome page.

# Testing
First I would like to say that for testing we should be using a different database, 
but for the purposes of this being an interview project I didn't implement it.
If we would like to implement such a feature we could create either a different mysql container
or create a different database with a suffix of `_testing` in the same container

To run the tests you will need to run:

```
docker-compose exec app php artisan test
```

# Running into problems

If you run into problems fell free to email me at `bruno11.francisco@gmail.com`
