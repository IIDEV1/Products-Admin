# OrbitalStore

Премиальный PHP интернет-магазин с админ-панелью.

## Стек технологий

- **Backend**: PHP 8+ (vanilla, без фреймворков)
- **Database**: PostgreSQL (Supabase)
- **Frontend**: TailwindCSS CDN + Vanilla JS
- **Hosting**: Vercel (vercel-php runtime)

## Структура проекта

```
catalog/
├── api/
│   └── index.php          # Главный роутер (единая точка входа)
├── actions/
│   ├── admin.php          # Логин, CRUD товаров, статус заказов
│   ├── cart.php            # Добавление/удаление из корзины (AJAX)
│   ├── checkout.php        # Оформление заказа
│   └── lang.php            # Переключение языка
├── views/
│   ├── header.php          # Шапка, навигация
│   ├── footer.php          # Подвал
│   ├── landing.php         # Главная страница
│   ├── catalog.php         # Каталог товаров
│   ├── product.php         # Страница товара
│   ├── cart.php             # Корзина
│   ├── order_success.php   # Успешное оформление
│   ├── admin_login.php     # Вход в админку
│   ├── admin_dashboard.php # Панель управления
│   ├── admin_products.php  # Управление товарами
│   ├── admin_orders.php    # Управление заказами
│   └── 404.php             # Страница ошибки
├── languages/
│   ├── ru.php              # Русский
│   └── en.php              # English
├── public/
│   ├── app.js              # Клиентский JS (AJAX, toast)
│   └── style.css           # Кастомные стили
├── scripts/
│   └── migrate.php         # Миграции БД
├── config.php              # Конфигурация + хелперы
├── database.sql            # Схема БД (PostgreSQL)
├── vercel.json             # Конфигурация Vercel
└── .env                    # Переменные окружения (не в git)
```

## Установка

### Локально (XAMPP)

1. Клонируйте репозиторий в `htdocs/catalog`
2. Создайте `.env` файл (см. `.env.example`)
3. Импортируйте `database.sql` в вашу PostgreSQL базу
4. Откройте `http://localhost/catalog/api/`

### Vercel

1. Подключите репозиторий к Vercel
2. Добавьте переменные окружения в настройках проекта (DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS, ADMIN_USER, ADMIN_PASS_HASH)
3. Деплой произойдёт автоматически

## Переменные окружения

| Переменная | Описание |
|-----------|---------|
| DB_HOST | Хост PostgreSQL |
| DB_PORT | Порт (6543 для Supabase) |
| DB_NAME | Имя базы данных |
| DB_USER | Пользователь БД |
| DB_PASS | Пароль БД |
| ADMIN_USER | Логин администратора |
| ADMIN_PASS_HASH | Хеш пароля (bcrypt) |

Для генерации хеша пароля:
```bash
php -r "echo password_hash('your_password', PASSWORD_DEFAULT);"
```

## Возможности

- 🛍️ Каталог товаров с поиском и фильтром по цене
- 🛒 Корзина с AJAX-добавлением и toast-уведомлениями
- 📦 Оформление заказов с валидацией
- 👤 Админ-панель с дашбордом
- ✏️ CRUD товаров (добавление, редактирование, удаление)
- 📋 Управление заказами (смена статуса)
- 🌐 Мультиязычность (RU / EN)
- 🔒 CSRF-защита всех форм
- 📱 Адаптивный дизайн
