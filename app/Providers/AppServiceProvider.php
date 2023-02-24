<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
        if ($this->app->isLocal()) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);

            $this->app->register(\Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class,);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('money', function ($money) {
            return "<?php echo number_format($money); ?>";
        });

        view()->composer('*', function ($view) {
            // Add only to backend views (start with `admin.`).
            if (strpos($view->getName(), 'admin.') === 0) {
                $viewData = $view->getData();
                if (isset($viewData['logged_in_admin'])) {
                    return;
                }

                $admin = auth()->guard('admin')->user();
                if (is_null($admin)) {
                    return;
                }
                $view->with('logged_in_admin', $admin);

                if (isset($viewData['unread_notice_counter'])) {
                    return;
                }
                $unreadNotices = $admin->unreadNotifications()->get();
                $counter = count($unreadNotices);
                $view->with('unread_notice_counter', $counter);

                if (isset($viewData['showup_notices'])) {
                    return;
                }
                $notices = array();
                $readNoticeLimit = 5;

                if ($counter == 0) {
                    $notices = $admin->notifications()->limit($readNoticeLimit)->get();
                }
                else {
                    $notices = $unreadNotices;
                }

                $showupNotices = array();

                foreach ($notices as $notice) {
                    $key = $notice->id;

                    $showupNotices[$key] = $notice->toArray();

                    $showupNotices[$key]['created_at'] = $notice->created_at->toDateTimeString();
                    $showupNotices[$key]['updated_at'] = $notice->updated_at->toDateTimeString();
                }

                // if ($counter < $readNoticeLimit) {
                //     $readNotices = $admin->notifications()->limit($readNoticeLimit - $counter)->get();
                //     foreach ($readNotices as $readNotice) {
                //         $key = $readNotice->id;

                //         if (isset($showupNotices[$key])) {
                //             continue;
                //         }

                //         $readNoticeArr = $readNotice->toArray();

                //         $readNoticeArr['created_at'] = $readNotice->created_at->toDateTimeString();
                //         $readNoticeArr['updated_at'] = $readNotice->updated_at->toDateTimeString();

                //         $showupNotices[$key] = $readNoticeArr;
                //     }
                // }

                $view->with('showup_notices', $showupNotices);
            }
        });

        Validator::extend('gte_field', function($attribute, $value, $parameters, $validator) {
            $min_field = $parameters[0];
            $data = $validator->getData();
            $min_value = $data[$min_field];
            return $value >= $min_value;
        });

        Validator::replacer('gte_field', function($message, $attribute, $rule, $parameters) {
            return str_replace(':field', $parameters[0], $message);
        });

        Validator::extend('sunique', function ($attribute, $value, $parameters, $validator) {
            $query = DB::table($parameters[0]);
            $column = $query->getGrammar()->wrap($parameters[1]);
            return ! $query->whereRaw("BINARY {$column} = ?", [$value])->count();
        });
    }
}
