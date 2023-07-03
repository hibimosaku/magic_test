<?php

namespace App\Console;

use App\Models\ImagePrint;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // ここに画像削除の処理を記述する
            $expiredImages = ImagePrint::where('expired_date', '<', now())->get();

            foreach ($expiredImages as $image) {
                // 画像の削除処理
                if (Storage::disk('public')->exists($image->filepath)) {
                    Storage::disk('public')->delete($image->filepath);
                }

                // レコードの削除
                $image->delete();
            }
            // })->daily();
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
