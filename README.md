# Estate Analytics

[![Tests](https://github.com/VilliamWe/Estate-Analytics/actions/workflows/tests.yml/badge.svg)](https://github.com/VilliamWe/Estate-Analytics/actions/workflows/tests.yml)

Внутренний веб-сервис для учёта и аналитики объектов коммерческой недвижимости, экспозиций и эффективности рекламных каналов.

Проект разработан как выпускная квалификационная работа и затем доработан как основной портфолио-проект **Junior PHP / Laravel Developer**.

## Что демонстрирует проект

- разработку приложения на Laravel с разграничением ответственности между слоями;
- работу с Eloquent ORM, связями, миграциями и seeders;
- серверную валидацию через Form Requests;
- вынос аналитической бизнес-логики в сервисный слой;
- авторизацию и разграничение доступа по ролям;
- импорт и проверку CSV-данных;
- feature-тестирование ключевых пользовательских сценариев;
- автоматический запуск тестов в GitHub Actions.

## Возможности

- авторизация сотрудников;
- роли `admin` и `employee`;
- CRUD объектов коммерческой недвижимости;
- CRUD экспозиций;
- справочники типов объектов, районов и каналов экспозиции;
- фильтрация и поиск;
- карточка объекта;
- dashboard с ключевыми показателями;
- аналитика и графики;
- сравнение объектов;
- оценка эффективности экспозиций;
- CSV-импорт объектов;
- управление пользователями для администратора;
- печатные представления;
- feature-тесты основных сценариев.

## Архитектура

Проект использует стандартную архитектуру Laravel с дополнительным сервисным слоем для аналитики:

- `Controllers` — обработка HTTP-запросов и формирование ответа;
- `Form Requests` — валидация входных данных;
- `Models` — Eloquent-модели, связи и доменные константы;
- `Services` — аналитическая бизнес-логика;
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

## Быстрый запуск

```bash
git clone https://github.com/VilliamWe/Estate-Analytics.git
cd Estate-Analytics
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Настройте подключение к MySQL в `.env`, затем выполните:

```bash
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

## Демо-учётные записи

После запуска seeders доступны тестовые пользователи.

**Администратор**

```text
email: admin@estate.local
password: password
```

**Сотрудник**

```text
email: employee@estate.local
password: password
```

## CSV-импорт

Импорт объектов выполняется из CSV со следующими обязательными колонками:

```text
title,type,address,district,area,price,status
```

Перед импортом приложение проверяет структуру заголовков и валидность строк. Ошибочные данные не должны приводить к частично выполненному импорту.

## Тестирование и CI

Локальный запуск тестов:

```bash
php artisan test
```

Для тестов используется SQLite `:memory:`. Отдельная тестовая база данных не требуется.

GitHub Actions автоматически устанавливает зависимости, собирает frontend и запускает тесты при `push` и `pull request` в ветку `main`.

## Автор

**Сапарбек Сарыбаев**  
Junior PHP / Laravel Developer
