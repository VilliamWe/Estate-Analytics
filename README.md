# Estate Analytics

![Tests](https://github.com/VilliamWe/Estate-Analytics/actions/workflows/tests.yml/badge.svg)

Внутренний веб-сервис для учёта и аналитики объектов коммерческой недвижимости, экспозиций и эффективности рекламных каналов.

Проект разработан как выпускная квалификационная работа и затем доработан как портфолио-проект Junior PHP/Laravel Developer.

## Возможности

- авторизация сотрудников;
- роли `admin` и `employee`;
- управление объектами недвижимости;
- управление экспозициями;
- фильтрация и поиск;
- карточки объектов и экспозиций;
- dashboard с ключевыми показателями;
- сравнение объектов;
- аналитика цен и эффективности экспозиций;
- импорт объектов из CSV;
- административный раздел пользователей;
- печатные представления;
- feature-тесты ключевых сценариев.

## Архитектура

Проект построен на стандартной архитектуре Laravel с разделением ответственности между слоями:

- `Controllers` — обработка HTTP-запросов и формирование ответа;
- `Form Requests` — валидация входных данных;
- `Models` — Eloquent-модели и связи;
- `Services` — бизнес-логика аналитики;
- `Middleware` — разграничение административного доступа;
- `Feature Tests` — проверка основных пользовательских сценариев.

Ключевые сервисы:

- `PropertyAnalyticsService` — поиск похожих объектов и оценка рыночного положения;
- `ExposureAnalyticsService` — сравнение эффективности экспозиции с аналогичными размещениями.

## Технологии

- PHP 8.2+
- Laravel 11
- MySQL
- Eloquent ORM
- Blade
- Tailwind CSS
- JavaScript
- Chart.js
- Vite
- PHPUnit
- GitHub Actions

## Установка

```bash
git clone https://github.com/VilliamWe/Estate-Analytics.git
cd Estate-Analytics
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Настройте подключение к базе данных в `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=estate_analytics
DB_USERNAME=root
DB_PASSWORD=
```

После этого выполните:

```bash
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

## Демо-учётные записи

После запуска seeders доступны тестовые пользователи.

### Администратор

```text
email: admin@estate.local
password: password
```

### Сотрудник

```text
email: employee@estate.local
password: password
```

## Роли

### Admin

Администратор может управлять пользователями, импортировать объекты, работать с объектами и экспозициями и просматривать аналитику.

### Employee

Сотрудник может работать с объектами и экспозициями, использовать аналитику и сравнение объектов. Административные разделы недоступны.

## CSV-импорт

Импорт объектов выполняется из CSV со следующими обязательными колонками:

```text
title,type,address,district,area,price,status
```

Перед импортом приложение проверяет структуру заголовков и валидность строк.

## Тестирование

Локальный запуск:

```bash
php artisan test
```

Для тестов используется SQLite `:memory:`, поэтому отдельная тестовая база данных не требуется.

Также в проекте настроен GitHub Actions: тесты автоматически запускаются при push и pull request в ветку `main`.

## Среда разработки

Проект разрабатывался на Windows. Frontend собирается через Vite.

## Автор

Сапарбек Сарыбаев

Junior PHP / Laravel Developer
