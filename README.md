# InfluxDB Integration for Laravel


## Installation

1. Install the package via Composer:

```bash
composer require iankibet/influxdb
````

2. Publish the configuration file:

```bash
php artisan vendor:publish --provider="Iankibet\InfluxDB\InfluxDBServiceProvide"
```

3. Configure the package by setting the following environment variables in your `.env` file:

```bash
INFLUXDB_HOST=127.0.0.1
INFLUXDB_PORT=8086
INFLUXDB_TOKEN=
INFLUXDB_BUCKET=
INFLUXDB_ORG=
```

## Usage

### Writing Data
```php
use Iankibet\InfluxDb\InfluxDbPoint;
use Iankibet\InfluxDb\Facades\InfluxDb;

// in your controller/method
$point = new InfluxDbPoint();
$point->setMeasurement('measurement_name');
$point->setTags(['tag_key' => 'tag_value']);
$point->setFields(['field_key' => 'field_value']);
$point->setTime(time());

InfluxDb::write($point);
```

### Querying Data
```php
use Iankibet\InfluxDb\Facades\InfluxDb;
$measurement = 'measurement_name';
$fields = [
    'key1'=>'value1',
    'key2'=>'value2'
];
$from = '2021-01-01T00:00:00Z';
$to = '2021-01-02T00:00:00Z';
$res = InfluxDb::query('measurement_name', $fields, $from, $to);
```
For more details, visit the [InfluxDB Integration for Laravel: A Comprehensive Guide](https://iankibet.com/packages/laravel/influxdb).
