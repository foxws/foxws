@setup
    $repository = 'git@github.com:foxws/foxws.git';
    $branch = 'devel'; // TODO: change to main
    $baseDir = '/home/francois/foxws';
@endsetup

@servers(['remote' => 'foxws'])

@story('deploy')
    maintenance-mode
    update-repository
    build-containers
    restart-containers
    install-dependencies
    clear-caches
    build-assets
    optimize
    restart-services
@endstory

@task('clone-repository', ['on' => 'remote'])
    mkdir -p {{ $baseDir }}
    git clone --depth 1 {{ $repository }} {{ $baseDir }}
@endtask

@task('maintenance-mode', ['on' => 'remote'])
    podman exec -it systemd-foxws-app php artisan down --with-secret
@endtask

@task('update-repository', ['on' => 'remote'])
    cd {{ $baseDir }}
    git pull origin {{ $branch }}
@endtask

@task('build-containers', ['on' => 'remote'])
    cd {{ $baseDir }}/podman
    ./make
@endtask

@task('restart-containers', ['on' => 'remote'])
    systemctl --user daemon-reload
    systemctl --user restart foxws-app foxws
@endtask

@task('install-dependencies', ['on' => 'remote'])
    podman exec -it systemd-foxws-app sh -c "
        composer install --prefer-dist --no-scripts -q -o &&
        yarn install;
    ";
@endtask

@task('clear-caches', ['on' => 'remote'])
    podman exec -it systemd-foxws-app sh -c "
        php artisan permission:cache-reset;
        php artisan structure-scouts:clear;
        php artisan optimize:clear;
        php artisan cache:clear;
        php artisan storage:link;
    ";
@endtask

@task('build-assets', ['on' => 'remote'])
    podman exec -it systemd-foxws-app sh -c "
        php artisan google-fonts:fetch &&
        php artisan icons:cache &&
        yarn run build;
    ";
@endtask

@task('optimize', ['on' => 'remote'])
    podman exec -it systemd-foxws-app sh -c "
        php artisan structure-scouts:cache;
        php artisan route:cache;
        php artisan view:cache;
        php artisan event:cache;
    ";
@endtask

@task('restart-services', ['on' => 'remote'])
    podman exec -it systemd-foxws-app sh -c "
        php artisan horizon:terminate;
        php artisan up;
    ";
@endtask
