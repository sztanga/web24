# Firemka API

Zadanie rekrutacujne, Kamil Stangelj.

## Opis zadanka

REST API Utwórz REST API przy użyciu frameworka Laravel / Symfony. 

Celem aplikacji jest umożliwienie przesłania przez użytkownika informacji 
odnośnie firmy (nazwa, NIP, adres, miasto, kod pocztowy) 
oraz jej pracowników (imię, nazwisko, email, numer telefonu(opcjonalne)) - 
wszystkie pola są obowiązkowe poza tym które jest oznaczone jako opcjonalne. 

Uzupełnij endpointy do pełnego CRUDa dla powyższych dwóch. 

Zapisz dane w bazie danych. 

PS. Stosuj znane Ci dobre praktyki wytwarzania oprogramowania oraz korzystaj z repozytorium kodu.

## Requirements

- PHP >= 8.0
- Composer

## Installation (MacOs)

- ```composer install``` - install composer dependencies
- ```cp .env.example .env``` - create .env file
- ```php artisan key:generate``` - create the app key
- ```touch database/database.sqlite``` - create sqlite database file
- ```php artisan migrate``` - run database migrations
- ```php artisan db:seed``` - seed the database with fake data
- ```php artisan serve``` - start the local server




When making calls with PostMan make sure to have following Pre-Request Script:
```
pm.request.headers.add({ key: 'X-Requested-With', value: 'XMLHttpRequest' });
```
