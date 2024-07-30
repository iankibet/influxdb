<?php
return [
    'default' => env('INFLUXDB_CONNECTION', 'local'),
    'connections' => [
        'local' => [
            'host' => env('INFLUXDB_HOST', 'localhost'),
            'port' => env('INFLUXDB_PORT', '8086'),
            'username' => env('INFLUXDB_USERNAME', ''),
            'password' => env('INFLUXDB_PASSWORD', ''),
            'token' => env('INFLUXDB_TOKEN', ''),
            'bucket' => env('INFLUXDB_BUCKET', ''),
            'org' => env('INFLUXDB_ORG', ''),
            'precision' => env('INFLUXDB_PRECISION', 's'),
            'ssl' => env('INFLUXDB_SSL', false),
            'verifySSL' => env('INFLUXDB_VERIFY_SSL', false),
            'timeout' => env('INFLUXDB_TIMEOUT', 0),
            'connectTimeout' => env('INFLUXDB_CONNECT_TIMEOUT', 0),
            'writeTimeout' => env('INFLUXDB_WRITE_TIMEOUT', 0),
            'queryTimeout' => env('INFLUXDB_QUERY_TIMEOUT', 0),
        ],
    ],
];
