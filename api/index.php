<?php

// 1. Buat folder sementara di /tmp (satu-satunya lokasi writable di Vercel)
$storageFolders = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($storageFolders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

// 2. Override variabel lingkungan untuk path storage dan driver ringan
putenv('APP_STORAGE_PATH=/tmp/storage');
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
putenv('APP_SERVICES_CACHE=/tmp/bootstrap/cache/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/bootstrap/cache/packages.php');
putenv('APP_CONFIG_CACHE=/tmp/bootstrap/cache/config.php');
putenv('APP_ROUTES_CACHE=/tmp/bootstrap/cache/routes.php');

// Matikan kebutuhan DB sementara jika hanya untuk tampilan tugas
putenv('CACHE_DRIVER=array');
putenv('SESSION_DRIVER=array');
putenv('LOG_CHANNEL=stderr');

require __DIR__ . '/../public/index.php';