<p align="center">
  <img src="public/assets/logo.png" alt="Andarilha" width="360">
</p>

# Andarilha

Site de uma agência de viagens com duas partes: uma landing page pública, onde o visitante conhece os destinos e pede um orçamento, e um painel administrativo restrito, onde a equipe responde os orçamentos e gerencia destinos e usuários.

A interface é traduzida em português, inglês e espanhol, com troca de idioma pela navbar.

## Stack

- PHP 8.3+, Laravel 13
- MySQL
- Blade, Tailwind CSS 4, Alpine.js 3
- Vite 8
- tippy.js (tooltips) e flatpickr (calendário)
- PHPUnit

## Requisitos

- PHP 8.3 ou superior
- Composer
- Node.js e npm
- MySQL

## Como rodar

1. Instale as dependências:

```sh
composer install
npm install
```

2. Crie o arquivo de ambiente e a chave da aplicação:

```sh
cp .env.example .env
php artisan key:generate
```

3. Crie o banco de dados e ajuste o `.env`:

```
APP_LOCALE=pt_BR

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mupy_jr
DB_USERNAME=root
DB_PASSWORD=
```

4. Rode as migrations e os seeders:

```sh
php artisan migrate --seed
```

5. Suba o front e o servidor:

```sh
npm run dev
php artisan serve
```

O site fica em `http://127.0.0.1:8000` e o painel em `http://127.0.0.1:8000/administrativo/entrar`.

## Acesso ao painel

O seeder cria um usuário padrão:

- E-mail: `test@example.com`
- Senha: `password`

Os dois valores podem ser trocados no `.env` por `DEFAULT_USER_EMAIL` e `DEFAULT_USER_PASSWORD` antes de rodar o seeder.

Novos usuários são criados pelo painel apenas com nome e e-mail. A pessoa recebe um e-mail com um link para criar a própria senha. Em desenvolvimento, use `MAIL_MAILER=log` para que os e-mails caiam em `storage/logs/laravel.log`.

## Testes

```sh
composer test
```

Os testes rodam em SQLite na memória e não tocam no banco de desenvolvimento.
