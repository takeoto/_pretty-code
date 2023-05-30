# _pretty-code
Manual run 
```shell
docker run --rm --workdir /app -v $PWD:/app php:8.1-alpine php app.php input.txt
```
Run tests
```shell
docker run --rm --workdir /app -v $PWD:/app php:8.1-alpine ./vendor/bin/phpunit
```