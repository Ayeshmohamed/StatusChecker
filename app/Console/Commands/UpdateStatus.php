<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Url;
use Notification;
use App\Notifications\UserNotify;

class UpdateStatus extends Command

{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'urls:updatestatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $urls = Url::with('users')->get();
        $count=0;
        foreach ($urls as $url) {
            $ch = curl_init("$url->path");
            curl_exec($ch);
            $info = curl_getinfo($ch,CURLINFO_HTTP_CODE);
            curl_close($ch);
            switch ($info) {
                case 200:
                $count=$count+1;
                $urlupdate=Url::where('id',$url->id)->update([
                    'statu_id'=>1
                ]);
                $deatials=[
                    'url'=>$url->path,
                    'status'=>'active',
                    'code' => $info
                ];
                Notification::send($url->users,new UserNotify($deatials));
                    break;
                case 500:
                $count=$count+1;
                $urlupdate=Url::where('id',$url->id)->update([
                    'statu_id'=>2
                ]);
                $deatials=[
                    'url'=>$url->path,
                    'status'=>'Error',
                    'code' => $info
                ];
                Notification::send($url->users,new UserNotify($deatials));
                    break;
                case 419:
                $count=$count+1;
                $urlupdate=Url::where('id',$url->id)->update([
                    'statu_id'=>4
                ]);
                $deatials=[
                    'url'=>$url->path,
                    'status'=>'Expired',
                    'code' => $info
                ];
                Notification::send($url->users,new UserNotify($deatials));
                    break;
                case 401:
                $count=$count+1;
                $urlupdate=Url::where('id',$url->id)->update([
                    'statu_id'=>5
                ]);
                $deatials=[
                    'url'=>$url->path,
                    'status'=>'UnAuthrized',
                    'code' => $info
                ];
                Notification::send($url->users,new UserNotify($deatials));
                    break;
                case 404:
                $count=$count+1;
                $urlupdate=Url::where('id',$url->id)->update([
                    'statu_id'=>3
                ]);
                $deatials=[
                    'url'=>$url->path,
                    'status'=>'Not Found',
                    'code' => $info
                ];
                Notification::send($url->users,new UserNotify($deatials));
                    break;
                default:
                $urlupdate="non";
                  break;
            }
        }
        $this->info("all urls is checked , there ".$count." status changes and users is notify");

    }
}
