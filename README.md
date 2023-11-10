### Instaliation
1. clone project
2. check env.example settings and update settings if needed
   * DOCKER_NGINX_PORT - set free port for listening server
   * DOCKER_POSTGRES_PORT - set database external port
### Auto
3. open terminal and run: 
    ```bash
    make install
    ```
### Manual
3. If something went wrong on auto installation then
    * open terminal and run
        ```bash
        make down (or docker-compose down)
        ```
    * open terminal and run
        ```bash
        make prepare-env
        ```
    * open terminal and run
        ```bash
        make buld-clean
        ```
    * open terminal and run
        ```bash
        make up
        ```
    * open terminal and run
    *  ```bash
        docker-compose exec backend composer install
        ```
    *  ```bash
        docker-compose exec backend php artisan key:generate
        ```
    *  ```bash
        docker-compose exec backend composer php artisan migrate:fresh
        ```
    *  ```bash
        docker-compose exec backend composer php artisan db:seed
        ```
    *  ```bash
        docker-compose exec backend composer php artisan optimize
        ```
     
5. open http://note-app.local:81/ or http://localhost:DOCKER_NGINX_PORT
6. All created users and admin have password = password 
7. You can check API Documentation [here](http://note-app.local:81/swagger)

### Checklist
- [x] Язык: php ^8.1
- [x] Фреймворк: Laravel ^8
- [x] Для аутентификации пользователей использовать Laravel Passport
- [x] REST API для управления заметками пользователя. Таблицу заметок можно создать с произвольными полями.
- [x] Каждый пользователь имеет доступ только к своим заметкам. Администратор – ко всем.
- [x] Реализовать автозаполнение базы данных, для возможности быстрого развертывания проекта с тестовыми данными с помощью seeder’ов.
- [x] Должны быть предусмотрены методы аутентификации пользователя в системе и выдача токенов для frontend’а.
- [x] При создании заметки пользователем создается событие, которое асинхронно отправляет уведомление администратору по почте (заглушка).
- [x] Нужно сделать описание методов API с помощью Swagg
- [x] Код проекта должен быть выгружен в публичный GitHub / GitLab репозиторий. В Readme проекта описать сборку проекта и его запуск.
- [x] Настроить проект для сборки в docker-контейнере.
- [x] Реализовать frontend с использованием написанного API.
- [x] Пара простеньких Unit-тестов.
