# Movie Catalog API

Movie Catalog API — это CRUD-приложение на основе Laravel, позволяющее управлять каталогом фильмов. Реализовано с использованием Docker, поддерживает PostgreSQL и предоставляет API для работы с фильмами.

## Оглавление

- [Технологии](#технологии)
- [Установка](#установка)
- [Использование](#использование)
- [API Маршруты](#api-маршруты)
- [Тестирование](#тестирование)
- [Переменные окружения](#переменные-окружения)

## Технологии

- **PHP 8.2**
- **Laravel 11**
- **PostgreSQL**
- **Docker**
- **Swagger/OpenAPI**

## Установка

### 1. Клонирование репозитория

```bash
git clone https://github.com/vAlfred88/just_hr_test.git
cd just_hr_test
```

### 2. Настройка переменных окружения
Создайте файл .env в корне проекта, скопировав содержимое из .env.example, и настройте следующие переменные окружения:

```dotenv
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=movies_db
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 3. Запуск Docker контейнеров
Используйте docker-compose для сборки и запуска контейнеров:

```bash
docker-compose up -d --build
```

### 4. Выполнение миграций
После запуска контейнеров выполните миграции для создания таблицы movies:

```bash
docker-compose exec app php artisan migrate
```

## Использование
После запуска контейнеров и выполнения миграций API будет доступен по адресу http://localhost.

## API Маршруты
### Ниже приведены основные маршруты API для управления фильмами:

* GET /api/movies — Получить список всех фильмов
* POST /api/movies — Создать новый фильм
* GET /api/movies/{id} — Получить фильм по ID
* PATCH /api/movies/{id} — Обновить информацию о фильме
* DELETE /api/movies/{id} — Удалить фильм

### Примеры API-запросов
#### Получить список всех фильмов

```http request
GET /api/movies
```

#### Создать новый фильм

```http request
POST /api/movies

Content-Type: application/json
{
    "title": "Inception",
    "duration": 148,
    "release_year": 2010,
    "genre": "Sci-Fi",
    "director": "Christopher Nolan"
}
```

#### Обновить фильм

```http request
PATCH /api/movies/{id}

Content-Type: application/json
{
    "title": "Inception Updated",
    "duration": 150
}
```

#### Удалить фильм

```http request
DELETE /api/movies/{id}
```

## Тестирование
Для запуска тестов выполните следующую команду:

```bash
docker-compose exec app php artisan test
```

## Переменные окружения

* ```DB_CONNECTION```: Тип подключения к базе данных (например, pgsql)
* ```DB_HOST```: Хост базы данных (обычно db в Docker-среде)
* ```DB_PORT```: Порт для подключения к базе данных (по умолчанию 5432 для PostgreSQL)
* ```DB_DATABASE```: Название базы данных
* ```DB_USERNAME```: Имя пользователя базы данных
* ```DB_PASSWORD```: Пароль пользователя базы данных

## Дополнительно

### Тестирование документации с помощью Swagger UI
Откройте http://localhost:8080.
Выберите нужный маршрут, например, POST /movies для создания нового фильма.
Введите тестовые данные и отправьте запрос.
Ознакомьтесь с ответом API, включая коды статуса и возвращаемые данные.
Swagger UI упростит тестирование и предоставит удобный интерфейс для работы с Movie Catalog API.
