<?php

namespace App\Providers;

use App;
use Session;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $admin_lang = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($admin_lang->name);
        User::chekValidation();

        view()->composer('*',function($settings){

            $settings->with('gs', cache()->remember('generalsettings', now()->addDay(), function () {
                return DB::table('generalsettings')->first();
            }));

            $settings->with('seo', cache()->remember('seotools', now()->addDay(), function () {
                return DB::table('seotools')->first();
            }));
            
            $settings->with('socialsetting', cache()->remember('socialsettings', now()->addDay(), function () {
                return DB::table('socialsettings')->first();
            }));

            $settings->with('categories', cache()->remember('categories', now()->addDay(), function () {
                return Category::with('subs')->where('status','=',1)->get();
            }));

            if (Session::has('language')){
                $data = cache()->remember('session_language', now()->addDay(), function () {
                    return DB::table('languages')->find(Session::get('language'));
                });
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $lang = json_decode($data_results);
                $settings->with('langg', $lang);
            }
            else{
                $data = cache()->remember('default_language', now()->addDay(), function () {
                    return DB::table('languages')->where('is_default','=',1)->first();
                });
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $lang = json_decode($data_results);
                $settings->with('langg', $lang);
            }

            if (!Session::has('popup'))
            {
                $settings->with('visited', 1);
            }

            Session::put('popup' , 1);

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

    }
}
