<?php
namespace Iankibet\InfluxDb;

use Illuminate\Support\ServiceProvider;

class InfluxDbServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->singleton('influx-db', function ($app) {
            return new InfluxDb();
        });
        $this->app->alias('influx-db', InfluxDb::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->publishes([
            __DIR__.'/../config/influxdb.php' => config_path('influxdb.php')
        ], 'influx-db');
    }
}
