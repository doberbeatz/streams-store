# Streams Store
App for collecting streams data from twitch service.

## Requirements

To use the app the following tools should be installed on your local machine:

- docker
- php7
- composer

## Install

First of all clone the repository:
`git clone git@github.com:doberbeatz/streams-store.git`

Then install composer's dependencies:
```
composer install
```

Create .env file from example
```
cp .env.example .env
```

Then register new app in your dev.twitch.tv account and add your Twitch ClientId and Secret into .env file located in root of project:
```
TWITCH_CLIENT_ID=2b1k7jdxmt4z46ay4s3lmdi0h74p37
TWITCH_CLIENT_SECRET=52zibkla38p4gsn348qtyprax43p0t
```

Start the containers using docker-compose:
```
docker-compose up -d
```

After the all containers will be started out run next commands:
```
docker exec -ti streams_web bash -c 'php artisan migrate --seed'
docker exec -ti streams_web bash -c 'php artisan key:generate'
```

Then you need to generate Client Id and Secret using Passport Package:
```
docker exec -ti streams_web bash -c 'php artisan passport:install'
```

As an output you'll see something like this:
```
Personal access client created successfully.
Client ID: 1
Client Secret: h93ydGs4G8xkqoWu0ADS6TshHeX3v8fPI2ZV6lXA
Password grant client created successfully.
Client ID: 2
Client Secret: bmZibiahtSutLoEcwImBD3DV9E0jiqEOZMbMz4N8
```
Use **Password grant's** Client ID and Secret as parameters which Passport has given you.
It will be needed for obtaining a token.

Go to app page `http://localhost:8080/` and register a new user account.
For using the API you have to get a token.

In order to get a token you need use your Username, Password, ClientId and Client Secret.

```
POST /oauth/token
```
```json
{
  "client_id": 2,
  "client_secret": "ygPvwScdmnJBh4JFfo5T6kbUiSuez5FggizM0zEV",
  "grant_type": "password",
  "username": "user@example.com",
  "password": "123456"
}
```

You'll get a response like this:
```json
{
    "token_type": "Bearer",
    "expires_in": 31536000,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjRkNzIxNTJjMmRhY2I5MGYzOWQzYTRhYmE5ZmZjNDFiMGM3YjE3M2EyOGEyYzc2OTk3ZTM3Y2MwZGVlOGZhYmVlZmM1NzY4OTNmMDgxOTlkIn0.eyJhdWQiOiIyIiwianRpIjoiNGQ3MjE1MmMyZGFjYjkwZjM5ZDNhNGFiYTlmZmM0MWIwYzdiMTczYTI4YTJjNzY5OTdlMzdjYzBkZWU4ZmFiZWVmYzU3Njg5M2YwODE5OWQiLCJpYXQiOjE1MTA2MDgwMjcsIm5iZiI6MTUxMDYwODAyNywiZXhwIjoxNTQyMTQ0MDI3LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.QyF3ziCipiaQo2O-caPdf8HGp7Qm_jj9ehXY5UQbVmuTkHqvF1HFv74l3KGxhlBz28pebqYx1ZDLqwvUDpX8dPqneqTQw8_-drAvm8KkurJu2MGq6QdWrfJKM4Lp3We50-m2EL84bk724mY8-yfzE6DEI1aeWPJ44k1sIuMK5eQWPHL6uD6wcLHgc7kcQOhBtMrSRAuu0PbBZzOtkoqvFfHmcH1qj_hK-DquYg-R68-z2x6skSI-qrE1Ahn0LE_J0KDd97NR4weT7cWXb1iGfI92hn9IoFFM6ixKzbk7Phd0Vmy2mSFJCtQAaYXJXAdKuCzXdu9wH-xz2C8ZV0CWb3Zilpe5PMRo22xfFadF--83-NqttU95vRN0M0dHwT7BVeudBFUwojOvEscfNB1DTmHBbK23xjmFBhkn5gCiIBgUCSVWqA1fFp1N0px9o3uMt2Qw_Em6BE8pSIqrncPDu5ig0TY114Mb4acRVsU4shkF_YSZs8mFAgAT4Irl-e9dMVNpkd-eCywqkTSe14VziKTvrNxrMJL9Fx4rEVykoneMpzVVOI7pEajgehL0nwI8f4jxMfPbqRgGivK6N91old_IE0HK-mLSg4tiryks8mjP-rhf-KZ4ZN5JKpZyU7gzbA6SG9QNRLuUJAftzaJkgXqDt-AzvlHWB34DG3b8oNQ",
    "refresh_token": "def50200ca6407b3814b1d5bb938c88651226cb54f42f7a05a69b62605d8c03c69a116b3df68443e96b09bc5921b1fe0571df3b42967efff823eb8a0a8f2cb7c04752fd632b5cefb47f7499b80f0c39e231745bf9d5741e01ab3f35ee24de3cbf1eb531d9a94e111c2c93372569c23651e3724c8ba094d4308dd3ef3755e6923eb9fa2db288773a1228e22e34fe3ae1b587f41af8a99ae0ad6286ebbe7d3c154ab22a5ea1a3e317a8af255dd69a22454e6ba87c0a63d363b286e8209953fabc98c7e83e02e2d2da7e576d4e8bf9d40632354ea690e569739ed6f2fa2df50d049c15be6babfe2edf9fda9d15cef0750cf833097c4a67405654e4e68219408e6e8fc55785f27a1f7549e5fe9a19bf8c7571fc193aeea98fc7289dfe0d0a1af4b80ff0d2523fbecfdb84e9fc4834bf90a2bf6a77cb4e1a55a166ec676a1c278430501ebbea7f56d71a4396195c4adde3358d48b5d3350addd729b0a0f95b98d5c391b"
}
```

Use the *access_token* in order to use the API in a header of the request.
```
Accept: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjRkNzIxNTJjMmRhY2I5MGYzOWQzYTRhYmE5ZmZjNDFiMGM3YjE3M2EyOGEyYzc2OTk3ZTM3Y2MwZGVlOGZhYmVlZmM1NzY4OTNmMDgxOTlkIn0.eyJhdWQiOiIyIiwianRpIjoiNGQ3MjE1MmMyZGFjYjkwZjM5ZDNhNGFiYTlmZmM0MWIwYzdiMTczYTI4YTJjNzY5OTdlMzdjYzBkZWU4ZmFiZWVmYzU3Njg5M2YwODE5OWQiLCJpYXQiOjE1MTA2MDgwMjcsIm5iZiI6MTUxMDYwODAyNywiZXhwIjoxNTQyMTQ0MDI3LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.QyF3ziCipiaQo2O-caPdf8HGp7Qm_jj9ehXY5UQbVmuTkHqvF1HFv74l3KGxhlBz28pebqYx1ZDLqwvUDpX8dPqneqTQw8_-drAvm8KkurJu2MGq6QdWrfJKM4Lp3We50-m2EL84bk724mY8-yfzE6DEI1aeWPJ44k1sIuMK5eQWPHL6uD6wcLHgc7kcQOhBtMrSRAuu0PbBZzOtkoqvFfHmcH1qj_hK-DquYg-R68-z2x6skSI-qrE1Ahn0LE_J0KDd97NR4weT7cWXb1iGfI92hn9IoFFM6ixKzbk7Phd0Vmy2mSFJCtQAaYXJXAdKuCzXdu9wH-xz2C8ZV0CWb3Zilpe5PMRo22xfFadF--83-NqttU95vRN0M0dHwT7BVeudBFUwojOvEscfNB1DTmHBbK23xjmFBhkn5gCiIBgUCSVWqA1fFp1N0px9o3uMt2Qw_Em6BE8pSIqrncPDu5ig0TY114Mb4acRVsU4shkF_YSZs8mFAgAT4Irl-e9dMVNpkd-eCywqkTSe14VziKTvrNxrMJL9Fx4rEVykoneMpzVVOI7pEajgehL0nwI8f4jxMfPbqRgGivK6N91old_IE0HK-mLSg4tiryks8mjP-rhf-KZ4ZN5JKpZyU7gzbA6SG9QNRLuUJAftzaJkgXqDt-AzvlHWB34DG3b8oNQ
```

## Endponts

### Stream List
**Request**
```
GET /api/streams/list
```
| Field | Value | Type | Required | Description |
| ----- | ----- | ---- | -------- | ----------- |
| game_id | 29595 | Integer | - | - |
| period | 2017-11-12 21:00 | Date | - | If not specified then current date time will be used.
| period_end | 2017-11-13 | Date | - | If only *period* will be specified but *period_end* not, then exact *period* time will be used.

**Response**
```json
{
    "data": {
        "29595": {
            "game_name": "Dota 2",
            "stream_list": [
                "26729623136",
                "26729465392",
                "26729701648",
                "26729654416",
            ]
        }
    }
}
```

### Viewer Count List
**Request**
```
GET /api/streams/viewer-count
```
| Field | Value | Type | Required | Description |
| ----- | ----- | ---- | -------- | ----------- |
| game_id | 1 | Integer | - | - |
| period | 2017-11-12 21:00 | Date | - | If not specified then current date time will be used.
| period_end | 2017-11-13 | Date | - | If only *period* will be specified but *period_end* not, then exact *period* time will be used.

**Response**
```json
{
    "data": {
        "29595": {
            "game_name": "Dota 2",
            "viewer_count_list": [
                {
                    "time": "2017-11-14T19:32:00+00:00",
                    "viewer_count": 226830
                },
                {
                    "time": "2017-11-14T21:59:00+00:00",
                    "viewer_count": 81038
                }
            ]
        },
        "32399": {
            "game_name": "Counter-Strike: Global Offensive",
            "viewer_count_list": [
                {
                    "time": "2017-11-14T19:32:00+00:00",
                    "viewer_count": 128233
                },
                {
                    "time": "2017-11-14T21:59:00+00:00",
                    "viewer_count": 107672
                }
            ]
        },
    }
}
```

### Games List
**Request**
```
GET /api/streams/viewer-count
```
**Response**
```json
[
    {
        "id": 29595,
        "name": "Dota 2",
        "is_active": 1
    },
    {
        "id": 32399,
        "name": "Counter-Strike: Global Offensive",
        "is_active": 1
    },
    {
        "id": 493057,
        "name": "PLAYERUNKNOWN'S BATTLEGROUNDS",
        "is_active": 1
    },
    {
        "id": 496712,
        "name": "Call of Duty: WWII",
        "is_active": 1
    }
]
```

*is_active* field is needed for whether to pull the data from twitch about the game or not.

## Cron

In order to stop pulling data from Twitch you can use the following command:
```
docker-compose stop streams_cron
```
And vice versa:
```
docker-compose start -d streams_cron
```

## Ip Based Access
If you need to restrict app by IP addresses you can uncomment the following line in `routes/api.php` file:
```php
Route::prefix('streams')
//    ->middleware('ip:127.0.0.1,192.168.*')
    ->group(function () {

    Route::get('list', 'StreamsController@getStreamList');
    Route::get('viewer-count', 'StreamsController@getViewerCount');
});
```

## Enjoy
