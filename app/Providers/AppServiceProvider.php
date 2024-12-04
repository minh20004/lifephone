<?php

namespace App\Providers;

use App\Models\News;
use App\Models\Category;
use App\Models\OrderNotification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
         // Chia sẻ dữ liệu danh mục và sản phẩm cho view header
         View::composer('client.layout.partials.header', function ($view) {
            $categories = Category::with(['products' => function ($query) {
                $query->take(11);
            }])->take(11)->get();
        
            $view->with('categories', $categories);
        });

        // Chia sẻ 3 bài viết mới nhất tới footer.blade.php
        View::composer('client.layout.partials.footer', function ($view) {
            $latestNews = News::where('status', 'Công khai')
                ->latest()
                ->take(3)
                ->get();

            $view->with('latestNews', $latestNews);
        });

        View::composer('*', function ($view) {
            $notifications = OrderNotification::with('order')
                ->orderBy('created_at', 'desc')
                ->get();
    
            $unreadCount = OrderNotification::where('is_read', false)->count();
    
            $view->with(compact('notifications', 'unreadCount'));
        });
    }
}
