<?php

namespace Modules\Api\Http\Controllers\Api;

use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Api\Repositories\ApiInterface;
use Modules\Api\Entities\Api;
use Carbon\Carbon;
use Assets;


class ApiController extends Controller
{

     /**
     * @var ApiInterface
     */
    protected $api;


    public function __construct(
           ApiInterface $api
               )
    {
        $this->api = $api;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json($this->api->all());
    }

    public function receiveApi()
    {
        $data = request()->all();
           // $newData = json_decode($data);
           // logger($data);
            if(!empty($data)){

           $user = new \App\User();
           $user->telegramid = \Config::get(
               "services.telegram_id"
           );
           $notices = [];
           $email = '';
          // dd($user->telegramid);
           $user->notice = 'Có khách đăng ký form#'.$data['entryName']. PHP_EOL;
           if(!empty($data)){
            foreach($data as $subject):
                if(isset($subject['name'])){

            $user->notice .= $subject['name']. ': '. $subject['value']. PHP_EOL;
             }
            endforeach;
            }


           $user->notify(
               new \Modules\Api\Notifications\NotifySubmit($user->notice)
           );
           }
    }
    
    
    public function enableAds(){
        
        return response()->json([
            'status' => false,
            'message' => 'UnEnable'
            
        ]);
    }


//     public function receiveApiTest()
//     {
//         $data = request()->all();
//         $newData = json_decode($data);
//         logger('abc');
//          die();
//         if(!empty($newData)){
//
//        $user = new \App\User();
//        $user->telegramid = \Config::get(
//            "services.telegram_id"
//        );
//       // dd($user->telegramid);
//        $user->notice = 'Có khách đăng ký form#'.$newData['form_id'];
//        $user->notify(
//            new \Modules\Api\Notifications\NotifySubmit()
//        );
//        }
//     }




}
