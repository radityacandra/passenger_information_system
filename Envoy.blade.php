@servers(['web' => 'root@93.188.164.230'])

@task('deploy', ['on' => 'web'])
	cd /var/www/html/passenger_information_system
	git pull origin {{ $branch }}
	php artisan migrate --force
	php artisan db:seed --force
    composer install
@endtask

@task('deploy_no_seed', ['on' => 'web'])
    cd /var/www/html/passenger_information_system
    git pull origin {{ $branch }}
    php artisan migrate --force
    composer install
@endtask