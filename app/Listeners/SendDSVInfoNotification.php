<?php

namespace App\Listeners;

use App\Jobs\SendToDSV;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendDSVInfoNotification
{
    /**
     * Create the event listener.
     */

    protected $file;


    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $news = $event;
        if($news->entry->email_dsv and $news->entry->locale == 'English') {

            /*
            $job = new SendToDSV($this->adress(), $news);
            // Dispatch Job and continue
            dispatch($job);
            */

            //Send to testgroup
            $emaillist = explode(";", $this->dsv_test());
            foreach($emaillist as $email) {
                $job = new SendToDSV($email, $news);
                // Dispatch Job and continue
                dispatch($job);
            }
        }


    }

    private function adress()
    {
        $this->file = base_path() . '/systemconfig/internt.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/internt.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['email']['dsv_info'];
    }

    private function dsv_test()
    {
        $this->file = base_path() . '/systemconfig/internt.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/internt.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['email']['dsv_test'];
    }
}
