# Информация о проекте

Это демо проект для курсов по PHP выполненный на базе фреймверка Symfony 2.3

## Требования

  * PHP 5.4+
  * MySql
  * Phing
  * Composer

## Установка

  * Выкачать проект из репозитория
    * `git clone git@github.com:plutakhin/simbirsoft_twitty.git /var/www/twitty/`
  * Установить Phing
    * http://www.phing.info/trac/wiki/Users/Installation
  * Выкачать composer в папку bin/
    * `curl -sS https://getcomposer.org/installer | php -- --install-dir=bin`
  *   Запустить сборку проекта, на вопросы композера указать верные настройки для соединения с БД, установить язык: **locale = ru**
    * `phing -f bin/build.xml install`
  * Настроить виртуальных хост: `/etc/apache2/sites-available/twitty.conf`
```apache
<VirtualHost 127.0.0.1:80>
  ServerName twitty.com
  ServerAlias twitty.com

  DocumentRoot /var/www/twitty/web
  DirectoryIndex app_dev.php

  <Directory /var/www/twitty/web>
    # enable the .htaccess rewrites
    AllowOverride All
    Order allow,deny
    Allow from All
  </Directory>

  ErrorLog /var/www/twitty/app/logs/project_error.log
  CustomLog /var/www/twitty/app/logs/project_access.log combined
</VirtualHost>
```
  * Включить указанный конфиг
    * `sudo a2ensite twitty.conf`
    * `sudo service apache2 reload`

  * Прописать локальный ip на хост в файл /etc/hosts
    * `127.0.0.1	twitty.com`

  * Открыть в браузере адрес http://twitty.com/
