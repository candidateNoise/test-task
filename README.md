# Test task solution #

- `git clone https://github.com/candidateNoise/test-task`
- `composer update`
- create two databases. one for solution itself and second one for test.
- edit `config/db.php` and `config/test_db.php` files.
- run `php yii migrate` to run database migrations.
- run `php tests/bin/yii migrate` to run database migrations for test.
- `web` is document root.

## Tests ##

- composer exec codecept run