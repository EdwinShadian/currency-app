# Тестовое задание для компании FireBird Tours

Используемые технологии:

1. PHP 8.1
2. Laravel 10
3. Laravel Sail
4. Laravel Livewire
5. Postgres 15
6. Docker

## Развертывание в локальной среде

1. Скопировать настройки окружения из .env.example в .env (он полностью заполнен):

    ```shell
    cp .env.example .env
    ```

2. Поднять контейнеры с помощью Docker Compose:

    ```shell
    docker compose up -d --build
    ```

3. Инициализировать проект. Будут загружены фронтовые и бэковые пакеты, произведены миграции, собран фронт и загружены актуальные курсы валют с <https://fixer.io/>:

    ```shell
    docker exec -it currency-app-app-1 make
    ```

4. Готово! Можно пробовать методы API:
    - GET /api/currency - получить пагинированный список валют
    - GET /api/rate - получить курс одной валюты относительно другой
        - from и to - коды валют, которые сравниваем
    - POST /api/convert - конвертировать одну валюту в другую
        - from и to - аналогично предыдущему
        - amount - количество валюты для конвертации

5. Также можно посмотреть все курсы к доллару на /currency/index пагинированной таблицей.

6. Для обновления курсов используется планировщик, который автоматически обновляет все курсы валют в 01:00. Вручную можно обновить, используя консольную команду:

    ```shell
    docker exec -it currency-app-app-1 php artisan app:update-rates
    ```

### Для запуска тестов

Запускаем в контейнере PHPUnit:

```shell
docker exec -it currency-app-app-1 vendor/bin/phpunit tests
```
