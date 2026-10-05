<?php

namespace App\Providers;

use App\Http\Controllers\ActivityLogController;
use App\Http\Middleware\RecordActivity;
use App\Models\Document;
use App\Models\Employee;
use App\Observers\ActivityModelObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ActivityLogServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Document::observe(ActivityModelObserver::class);
        Employee::observe(ActivityModelObserver::class);
        $this->app['router']->pushMiddlewareToGroup('web', RecordActivity::class);
        if (!$this->app->routesAreCached()) {
            Route::middleware(['web', 'auth'])->get('/riwayat-aktivitas', [ActivityLogController::class, 'index'])->name('activity-logs.index');
        }
    }
}
