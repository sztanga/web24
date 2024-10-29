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
- ```php artisan l5-swagger:generate``` - regenerate swagger api docs
- ```php artisan serve``` - start the local server

## API

### Remember

When making calls with PostMan make sure to have following Pre-Request Script:
```
pm.request.headers.add({ key: 'X-Requested-With', value: 'XMLHttpRequest' });
```

## Authentication
This API uses **Laravel Sanctum** for authentication.

After successful login you will receive an access token, which must be included in the headers of all authenticated requests.

```
login: test@web24.com.pl
password: password
```

Include the following header in authenticated requests:
```
Authorization: Bearer {token}
```

## Endpoints

Visit ```{url}/api/documentation/ ``` for detailed API documentation
