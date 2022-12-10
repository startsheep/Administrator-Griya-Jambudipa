<h1 align="center"> Administrator Griya- Jambudipa Bandung</h1>
```bash
cls && php artisan config:clear && php artisan migrate:fresh --env=testing && php artisan db:seed --env=testing --class=UnitTestingSeeder && php artisan test --stop-on-failure
```
