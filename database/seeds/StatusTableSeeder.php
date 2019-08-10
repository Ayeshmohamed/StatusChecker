<?php

use Illuminate\Database\Seeder;
use App\Status;
class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $keys=[
            '201',
            '500',
            '403',
            '419',
            '401'
        ];
        foreach ($keys as $key) {
            switch ($key) {
                case '200':
                Status::create([
                   'title'=>'active',
                   'code'=>$key 
                ]);
                    break;
                case '500':
                Status::create([
                   'title'=>'Error',
                   'code'=>$key 
                ]);
                    break;
                case '419':
                Status::create([
                   'title'=>'expired',
                   'code'=>$key 
                ]);
                    break;
                case '401':
                Status::create([
                   'title'=>'UnAuthrize',
                   'code'=>$key 
                ]);
                    break;
                
                default:
                Status::create([
                    'title'=>'Not found',
                    'code'=>404
                 ]);                   
                  break;
            }
        }

    }
}
