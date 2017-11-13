# Streams Store
App for collecting streams data from twitch service.

## Install

First of all clone the repository
`git clone git@github.com:doberbeatz/streamers-store.git`

Then add your Twitch ClientId and Secret into .env file located in root of project
```
TWITCH_CLIENT_ID=2b1k7jdxmt4z46ay4s3lmdi0h74p37
TWITCH_CLIENT_SECRET=52zibkla38p4gsn348qtyprax43p0t
```

Then build up the containers using docker-compose
```
docker-compose up -d
```

After all containers will be started run next command
```
docker exec -ti streams_web bash -c 'php artisan migrate --seed'
```

Then you need to create Client Id and Secret using Passport Package
```
docker exec -ti streams_web bash -c 'php artisan passport:install'
```

As the output you'll see something like this:
```
Personal access client created successfully.
Client ID: 1
Client Secret: h93ydGs4G8xkqoWu0ADS6TshHeX3v8fPI2ZV6lXA
Password grant client created successfully.
Client ID: 2
Client Secret: bmZibiahtSutLoEcwImBD3DV9E0jiqEOZMbMz4N8
```

Go to url: `http://localhost:8080/` and register a user account.

For use the API you need to get a token.

For this you need use your Username, Password, ClientId and Client Secret 

Use **Password grant's** Client ID and Secret as parameters.

```json
{
  "client_id": 2,
  "client_secret": "ygPvwScdmnJBh4JFfo5T6kbUiSuez5FggizM0zEV",
  "grant_type": "password",
  "username": "user@example.com",
  "password": "123456"
}
```