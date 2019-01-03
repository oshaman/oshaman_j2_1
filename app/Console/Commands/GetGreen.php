<?php

namespace App\Console\Commands;

use App\Delivery;
use App\Dispensary;
use App\Doctor;
use Illuminate\Console\Command;

class GetGreen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:green';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Green';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = simplexml_load_file(public_path('doctors.xml'), 'SimpleXMLElement', LIBXML_NOBLANKS);
        $bar = $this->output->createProgressBar(count($file));
        $count = 0;
        foreach ($file as $item) {
            $count++;
            if (1 == $count) continue;
//            if (10 < $count) continue;
//            if (4597 > $count) continue;
            $str = preg_replace('#https://weedmaps.com/doctors/#', '', $item->loc);

            try {
                $content = file_get_contents("https://api-g.weedmaps.com/wm/web/v1/listings/$str/menu?type=doctor");
            } catch (\Exception $e) {
                $content = null;
                \Log::info('Error - ' . $e->getMessage());
            }

            if (null != $content) {
                Doctor::create(['content' => $content]);
//                $this->line($count . ' - ' . $str);
            } else {
                $this->line('error -----------> '.$count .' - '. $str);
            }
            $bar->advance();
        }
        $bar->finish();
    }
}
