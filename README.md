# WEB3 - Project - API

## Configuration
- PHP: supérieur ou égale à 8.0
- Composer: 2.0.12
- MYSQL: 5.7.31

## Installation

- Modifier la DATABASE_URL dans le .env

- ```composer install```

- ```php bin/console doctrine:migrations:migrate```

- ```php bin/console doctrine:fixtures:load```

## Installation du bundle pour la gestion des JWT

- Générer une clé publique et privée avec une passphrase à reporter dans le .env

```
$ mkdir -p config/jwt
$ openssl genrsa -out config/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```