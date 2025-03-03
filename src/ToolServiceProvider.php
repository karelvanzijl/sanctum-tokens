<?php

namespace Karelvanzijl\SanctumTokens;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Component identifier name.
     *
     * @var string
     */
    public static $name = "sanctum-tokens";

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . "/../resources/lang" => resource_path(
                "lang/vendor/" . static::$name
            ),
        ]);

        Nova::serving(function (ServingNova $event) {
            Nova::script("sanctum-tokens", __DIR__ . "/../dist/js/tool.js");
            Nova::style("sanctum-tokens", __DIR__ . "/../dist/css/tool.css");
            Nova::translations(static::getTranslations());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if (
            $this->app->routesAreCached() ||
            false === config("sanctum.routes")
        ) {
            return;
        }

        Route::middleware(["nova"])
            ->prefix("nova-vendor/" . static::$name)
            ->group(__DIR__ . "/../routes/api.php");
    }

    /**
     * Get the translation keys from file.
     */
    private static function getTranslations(): array
    {
        $translationFile = resource_path(
            "lang/vendor/" . static::$name . "/" . app()->getLocale() . ".json"
        );

        if (!is_readable($translationFile)) {
            $translationFile =
                __DIR__ . "/../resources/lang/" . app()->getLocale() . ".json";

            if (!is_readable($translationFile)) {
                return [];
            }
        }

        return json_decode(file_get_contents($translationFile), true);
    }
}
