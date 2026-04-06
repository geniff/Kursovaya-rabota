# -
Курсовая работа
https://github.com/geniff/Kursovaya-rabota

Соловьёв Глеб https://github.com/geniff/Kursovaya-rabota/blob/main/backend_stack.md


Королева Дарья https://github.com/geniff/Kursovaya-rabota/blob/main/frontend_stack.md

План развертывания:
Ниже приведена техническая инструкция по развёртыванию приложения с backend на C# (ASP.NET Core) и frontend на Laravel (Blade).

1. Требования к окружению
Для корректной работы проекта необходимо установить:
.NET SDK (версия 6.0 или выше)
PHP (версия 8.1 или выше)
Composer
Веб-сервер (встроенный Laravel server используется по умолчанию)
Проверка установки:
dotnet --version
php -v
composer -V

2. Структура проекта
После распаковки архива структура имеет вид:
project/
 ├── backend_cs/
 │    └── Program.cs
 └── frontend_laravel/
      └── resources/views/students.blade.php

3. Развёртывание backend (C#)
3.1 Создание проекта
Создать новый ASP.NET Core проект:
dotnet new web -n backend
Перейти в директорию:
cd backend

3.2 Интеграция исходного кода
Заменить файл:
Program.cs
на файл из директории:
backend_cs/Program.cs

3.3 Запуск backend
Выполнить команду:
dotnet run
После запуска приложение будет доступно по адресу:
http://localhost:5000

3.4 Проверка API
Доступные endpoints:
GET /students
POST /students
DELETE /students/{id}
Пример запроса:
http://localhost:5000/students
Ответ:
[]

4. Развёртывание frontend (Laravel)
4.1 Создание Laravel проекта
Выполнить:
composer create-project laravel/laravel frontend
Перейти в директорию:
cd frontend

4.2 Интеграция шаблона
Скопировать файл:
frontend_laravel/resources/views/students.blade.php
в директорию:
frontend/resources/views/

4.3 Настройка маршрутов
Открыть файл:
routes/web.php
Добавить маршрут:
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    $students = Http::get('http://localhost:5000/students')->json();
    return view('students', ['students' => $students]);
});

4.4 Запуск frontend
Выполнить:
php artisan serve
Приложение будет доступно по адресу:
http://127.0.0.1:8000

5. Взаимодействие компонентов
Архитектура приложения:
backend реализован на ASP.NET Core и предоставляет REST API
frontend реализован на Laravel Blade
взаимодействие осуществляется через HTTP-запросы
Laravel использует встроенный HTTP-клиент для обращения к backend:
Http::get('http://localhost:5000/students')

6. Проверка работоспособности
Запустить backend (dotnet run)
Запустить frontend (php artisan serve)
Открыть в браузере:
http://127.0.0.1:8000
Проверить:
отображение списка студентов
добавление новых записей
корректность работы API

7. Возможные проблемы
7.1 Backend недоступен
Проверить:
запущен ли процесс dotnet run
корректность URL (http://localhost:5000)

7.2 Ошибка HTTP-запросов в Laravel
Проверить:
подключён ли фасад Http
доступность backend

7.3 Пустой список данных
Причина:
используется временное хранилище (in-memory) в backend
данные сбрасываются при перезапуске сервера

8. Итог
В результате развёртывания:
backend (C#) обрабатывает HTTP-запросы и управляет данными
frontend (Laravel) отвечает за отображение и взаимодействие с пользователем
связь между компонентами осуществляется через REST API
Данная архитектура соответствует принципу разделения клиентской и серверной частей и демонстрирует использование различных технологий в рамках одного приложения.
