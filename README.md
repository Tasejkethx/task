
 `git clone`
- configure your db connection in the .env file

 `composer install`
 `php artisan key:generate`
 
docker:

`docker-compose build`
  `docker-compose up -d`
   `docker-compose exec app php artisan migrate`
   
   
 or 
 
 `php artisan migrate`
  `php artisan serve`
  
- profit

Что было сделано:
Подключен docker, prettier, eslint
Разработано SPA приложение, переход по страницам через vue-router;
Отношение между отделами и сотрудниками - Many to many;
Вывод сообщений пользователю с использованием sweetalerts;
Валидация запросов через request классы;
Обработка исключительных ситуаций;
Spinner при загрузке данных;
Пагинация;
Требования из тз;
Затраченное время: ~10ч;
Выгружен проект на хостинг http://nipplees8.parkingby.icu


Предложения по улучшению:
Добавить фильтрацию/поиск/сортировку;
Возможность оставлять комментарии (делать пометки) для каждого сотрудника: вывод информации о изменении з/п, о смене отделов и прочие пометки;
Использовать транзакции
