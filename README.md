# Календарное приложение на PHP

Система управления задачами с веб-интерфейсом.

## Требования

- PHP 7.4+
- MySQL 5.7+
- Расширения: `pdo`, `pdo_mysql`, `mbstring`

## Быстрый старт

```bash
# 1. Настройка БД
mysql -u root -p < schema.sql
# или
mysql -u root -p
> source schema.sql

# 2. Конфигурация
cp config.php.example config.php

# 3. Запуск
php -S localhost:8000
```

## Структура БД

- `task_types` - типы задач
- `task_statuses` - статусы задач
- `tasks` - основная таблица задач

## API действий

| Action     | URL                      | Описание               |
| ---------- | ------------------------ | ---------------------- |
| `index`    | `/`                      | Список задач           |
| `add`      | `/?action=add`           | Добавить задачу (POST) |
| `complete` | `/?action=complete&id=N` | Отметить выполненной   |
| `delete`   | `/?action=delete&id=N`   | Удалить задачу         |
| `edit`     | `/?action=edit&id=N`     | Редактировать задачу   |

## Фильтры

- `?filter=all` - все задачи
- `?filter=current` - активные
- `?filter=overdue` - просроченные
- `?filter=completed` - выполненные
