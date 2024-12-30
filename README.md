# Intermediano

## System Information

- **OS**: Debian GNU/Linux 12 (bookworm)
- **Language**: PHP 8.3
- **Framework**: Laravel 11
- **Database**: PostgreSQL 17

## Preinstallation

git config user.name "Dev Silva"
git config user.email "dev.silva@youtan.com.br"

## Installation

1. Clone the repository: `git clone...`;
2. Duplicate the `.env.example` file and rename it to `.env`;
3. set chmod +x docker-run.sh
4. Run `./docker-run.sh up -d`;
5. Run `./docker-run.sh shell`;
6. Inside the web (shell) container, run `php artisan key:generate`;
7. Inside the web (shell) container, run `composer install`;
8. Inside the web (shell) container, run `php artisan migrate`;

## Running

1. Run `./docker-run.sh up -d`;

## Compiling assets

1. Run `./docker-run.sh shell`;
2. Inside the shell container, run `npm install`;
3. Inside the shell container, run `npm run dev` o `npm run build`;
