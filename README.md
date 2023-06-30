# This meme exists - генератор мемов

# О репозитории

This Meme Exists - генератор мемов на Laravel+Intervention/Image, то есть сайт, где можно выбрать шаблон мема и текст, и сайт фотошопит текст на картинку.
В проекте присутствует CRUD и аутентификация.
(На верстку не обращайте внимание, это проект больше про бэк)

## Демоверсия
Демоверсия - http://thismemeexists.ru/
( на данный момент она не ворк, хостинг закончился)

## Установка

Клонируем репозиторий на локальный диск:
```bash
git clone https://github.com/cuteycuteboy/thismemeexists.git
```

Заходим в папку:
```bash
cd thismemeexists
```

Устанавливаем зависимости composer`а:
```bash
composer install
```

Устанавливаем JS зависимости:
```bash
npm i
```

Копируем .env.example в .env (пример unix):
```bash
cp .env.example .env
```

Генерируем ключ приложения:
```bash
php artisan key:generate
```

Мигрируем базу данных:
```bash
php artisan migrate
```

Связываем хранилище:
```bash
php artisan storage:link
```

Создаем папки для хранения мемов (пример на unix):
```bash
mkdir -p storage/app/public/memes
mkdir -p storage/app/public/memes_thubmnail
```

На всякий случай изменияем права доступа (приме для unix)
```bash
chmod -R 777 .
```

Собираем js (для прод):
```bash
npm run build
```
для дев:
```
npm run dev
```
