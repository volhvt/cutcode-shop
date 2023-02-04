<?php
declare(strict_types=1);

namespace App\Providers;

use App\Components\Fakers\FakerImageProvider;
use App\Http\Kernel;
use Carbon\CarbonInterval;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\Telescope;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
        Telescope::ignoreMigrations();
        if (!$this->app->isProduction()) {
            $this->app->singleton(Generator::class, static function () {
                ($faker = Factory::create())->addProvider(new FakerImageProvider($faker));
                return $faker;
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Model::shouldBeStrict(!app()->isProduction());

//        DB::whenQueryingForLongerThan(
//            CarbonInterval::seconds(1),
//            static function (Connection $connection, QueryExecuted $queryExecuted) {
//            }
//        );


        DB::listen(static function (QueryExecuted $query) {
            if ($query->time > 700) {
                logger()
                    ->channel('telegram')
                    ->debug(
                        'slow query : '. $query->time .' ms | ' . $query->sql . ' ',
                        $query->bindings
                    );
            }
        });


        app(Kernel::class)->whenRequestLifecycleIsLongerThan(
            CarbonInterval::seconds(3),
            static function ($startedAt, Request $request, Response $response) {
                logger()
                    ->channel('telegram')
                    ->debug('whenRequestLifecycleIsLongerThan : ' . $request->url());
            }
        );
    }
}
