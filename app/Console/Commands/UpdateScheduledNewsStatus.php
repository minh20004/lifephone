<?php

namespace App\Console\Commands;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateScheduledNewsStatus extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-news-status';
    protected $description = 'Update news status to public if the scheduled date has passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $listNews = News::all();

        foreach ($listNews as $news) {
            if ($news->status === 'Đã lên lịch' && $news->scheduled_at <= Carbon::now()) {
                $news->status = 'Công khai';
                $news->published_at = Carbon::now();
                $news->save();
            }
        }
        $this->info('News status updated successfully.');
    }
}
