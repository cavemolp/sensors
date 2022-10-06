# Multipass homework

Notice: please use PHP to complete this homework. You can use any framework, or just vanilla PHP - choice is yours. Don’t spend more than 2 hours on this, we expect to get skeleton of an app, to have a subject to discuss it on interview.

Task: we need application to read and manage data from temperature sensors.
Application is purely internal, so no authorisation needed.

App needs to provide following data on request:
1) Middle temperature from all sensors, in submitted days range
2) Middle temperature for a particular sensor readings, in one-hour range

Sensors specification:

Type 1: Can report to API, reports with POST method, json with following structure:
```
{
    "reading": {
        "sensor_uuid": "unique uuid of sensor",
        "temperature": "decimal format, xxx.xxx, in fahrenheit"
    }
}
```

Type 2: expects data to be read from it’s API, new sensors will be added manually via some basic form
Sensor expects request
```
GET %sensor_ip%/data
```

Return is a csv-string:
```
reading_id,temperature in celsius in format xxx.x decimal
```
reading_id is a sequence number, which increases each time when sensor reads temperature.

# Comments
1. I've spent a bit more time on this homework (~3h)
2. Tests are not added
3. Requests are not validated
4. Sensor temperature is randomized
5. `ReadSensorCommand` could be refactored, but I've used it only for test purposes - not sure if it is required for this assignment
6. All temperature is stored in celsius because there were no requirement regarding that
7. There is no setup script. To test the application - one must go to `docker` directory, execute
```
docker-compose up -d
docker exec -it sensors-php-fpm bin/console doctrine:database:create
docker exec -it sensors-php-fpm bin/console doctrine:migrations:migrate -n
```
