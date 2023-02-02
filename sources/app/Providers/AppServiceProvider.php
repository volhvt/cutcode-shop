<?php
declare(strict_types=1);

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Model::preventLazyLoading(!app()->isProduction());
        Model::preventSilentlyDiscardingAttributes(!app()->isProduction());
        DB::whenQueryingForLongerThan(
            CarbonInterval::seconds(1),
            static function(Connection $connection, QueryExecuted $queryExecuted) {
                logger()
                    ->channel('telegram')
                    ->debug('whenQueryingForLongerThan : ' . $connection->query()->toSql());
            }
        );

        /** @var Kernel $kernel */
        $kernel = app(Kernel::class);
        $kernel->whenRequestLifecycleIsLongerThan(
            CarbonInterval::seconds(3),
            static function($startedAt, Request $request, Response $response) {
                logger()
                    ->channel('telegram')
                    ->debug('whenRequestLifecycleIsLongerThan : ' . $request->url());
            }
        );
    }
}
