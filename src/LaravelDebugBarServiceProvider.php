<?php

namespace LaravelDebugBar;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use LaravelDebugBar\Http\Middleware\DebugMiddleware;

class LaravelDebugBarServiceProvider extends ServiceProvider {
	public function register() {
		$this->mergeConfigFrom(__DIR__.'/../config/debug-bar.php', 'debug-bar');
	}

	public function boot() {
		$this->publishes([
			__DIR__.'/../config/debug-bar.php' => config_path('debug-bar.php'),
		]);

        // add debug middleware on debug mode
        if ( config('app.debug') ) {
            DB::connection()->enableQueryLog();

            /** @var Kernel $kernel */
            $kernel = $this->app->make(Kernel::class);
            $kernel->prependMiddleware(DebugMiddleware::class);
        }
	}
}