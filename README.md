# Basic config
This projects needs a BD url on its .env as 'DATABASE_URL' and update its schema:
run this command:
$ bin/console doctrine:migration:exec 20211016171028

# Setup project:
npm i
composer install

# Start server:
symfony server:start

# Routes
- Home:
https://127.0.0.1:8000/
- Api docs:
https://127.0.0.1:8000/api

# Problemas que me he encontrado:
- Al no estar familiarizado con vue no sabia si la mejor opción era usar vuejs como paquete npm o importando por cnd. Al final lo he implementado en symfony con encore.

