<?php

namespace App\Providers;

use App\Services\PrinterProvider;
use App\Services\PrinterProviderInterface;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('printers', function (Container $app) {
            if (file_exists(base_path('printers.json'))) {
                return json_decode(file_get_contents(base_path('printers.json')), true);
            }

            return json_decode(file_get_contents(base_path('printers.example.json')), true);
        });

        $this->app->bind(PrinterProviderInterface::class, function (Container $app) {
            $printersConfig = $app->make('printers');

            return new PrinterProvider($printersConfig);
        });
    }
}
