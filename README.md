# Mobile

## Made with BALL
- Bootstrap
- Alpine.js
- Laravel
- Livewire

## Running locally

### Requirements
- Docker with compose plugin
- Composer

### Installing using Laravel Sail
```sh
cp .env.example .env

composer install --ignore-platform-reqs

# Add allias to `./vendor/bin/sail` for less typing

./vendor/bin/sail up -d
./vendor/bin/sail composer install
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

### Access points
- Web: http://127.0.0.1
- Database: http://127.0.0.1:3000
- Emails: http://127.0.0.1:8025