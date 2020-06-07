@echo off

echo ==== COMMON ====
echo ls - Dir
doskey ls = dir $*

echo ==== LARAVEL ====

echo a - Artisan ...
doskey a = php artisan $*

echo am - Artisan make:...
doskey am = php artisan make:$*

echo mrs - Artisan migration:fresh --seed
doskey mrs = php artisan migrate:fresh --seed $*

echo acc - Artisan config:cache
doskey acc = php artisan config:cache $*

echo arl - Artisan route:list
doskey arl = php artisan route:list $*

echo aqo - Artisan queue:work --once
doskey aqo = php artisan queue:work --once $*

echo b - NPM Build Dev
doskey b = npm run dev $*

echo bp - NPM Build Production
doskey bp = npm run production $*

echo w - NPM Watch
doskey w = npm run watch $*

echo idem - IDE Helper Models Update
doskey idem = php artisan ide-helper:models -W $*

echo t  - Run PhpUnit Tests
doskey t = php vendor/phpunit/phpunit/phpunit $*

echo td  - Run Dusk Browser Tests
doskey td = php artisan dusk $*
