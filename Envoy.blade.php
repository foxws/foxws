@setup
    $repository = 'git@github.com:foxws/foxws.git';
    $branch = 'main';
    $baseDir = '/home/francois/foxws';
@endsetup

@servers(['remote' => 'foxws'])

@story('deploy')
    maintenance-mode
    update-repository
    build-containers
    restart-containers
    install-dependencies
    update-application
    build-assets
    restart-services
@endstory

@task('setup-environment', ['on' => 'remote'])
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

@task('update-application', ['on' => 'remote'])
    podman exec -it systemd-foxws-app sh -c "
        php artisan app:update --force
    ";
@endtask

@task('build-assets', ['on' => 'remote'])
    podman exec -it systemd-foxws-app sh -c "
        yarn run build;
    ";
@endtask

@task('restart-services', ['on' => 'remote'])
    podman exec -it systemd-foxws-app sh -c "
        php artisan up;
    ";
@endtask
