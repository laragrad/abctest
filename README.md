# abctest

## Требования

- Установленный Docker 

## Установка

Создайте папку (например abctest) и перейдите в неё.

Клонируйте проект.

	git clone git@github.com:laragrad/abctest.git .

Запустите sail для сборки и запуска docker.
	
	./vendor/bin/sail up -d

Создаваемые контейнеры и проброска портов.

- **abctest_app** - 50080 << 80
- **abctest_pgsql** - 55432 << 5432
- **abctest_mailhog** - 51025 << 1025, 58025 << 8025

Выполните сборку проекта.

	./vendor/bin/sail composer install
	./vendor/bin/sail php artisan migrate

## Postman

Импортируйте в Postman файлы коллекции и переменных окружения из папки `/postman` проекта.

Выберите Environement **ABC Mobile Test Environement**.

Откройте коллекцию **ABC Mobile Test API**.

## MailHog

Для просмотра формируемых email откройте в браузере [MailHog Dashboard](http://localhost:58025)

