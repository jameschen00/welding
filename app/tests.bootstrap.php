<?php

// app/tests.bootstrap.php
if (isset($_ENV['BOOTSTRAP_CLEAR_CACHE_ENV'])) {
    passthru(sprintf(
        'php "%s/console" cache:clear --env=%s --no-warmup',
        __DIR__,
        $_ENV['BOOTSTRAP_CLEAR_CACHE_ENV']
    ));

    passthru(sprintf(
        'php "%s/console" doctrine:database:drop --env=%s --force',
        __DIR__,
        $_ENV['BOOTSTRAP_CLEAR_CACHE_ENV']
    ));

    passthru(sprintf(
        'php "%s/console" doctrine:database:create --env=%s',
        __DIR__,
        $_ENV['BOOTSTRAP_CLEAR_CACHE_ENV']
    ));

    passthru(sprintf(
        'php "%s/console" doctrine:schema:update --env=%s --force',
        __DIR__,
        $_ENV['BOOTSTRAP_CLEAR_CACHE_ENV']
    ));
//
//    passthru(sprintf(
//        'php "%s/console" doctrine:fixtures:load --env=%s',
//        __DIR__,
//        $_ENV['BOOTSTRAP_CLEAR_CACHE_ENV']
//    ));
}

require __DIR__ . '/bootstrap.php.cache';