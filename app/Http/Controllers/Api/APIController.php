<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Auth\Reminders\RemindableInterface;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\UserInterface;
use Illuminate\Http\Request;
use App\HistoryStatus;
use App\DeviceStatus;
use App\Manufactory;
use App\History;
use App\Version;
use App\Device;
use App\Models;
use App\User;
use App\Type;
use App\Os;
use JWTAuth;
use Input;
use Auth;
use DateTime;
use Validator;
use Carbon\Carbon;
class APIController extends Controller {
	private $jwtauth;

	public function __construct(JWTAuth $jwtauth) {
	    $this->jwtauth = $jwtauth;
	}

	/**
     * Handle register request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     * @author Chi Lang <chi.al@neo-lab.vn>
     */

	//Login API


	public function login(Request $request) {

        $login = $request->only('email','password');
        // $token = $request->get('token');
        Log::debug($login);
        if(!empty($login)) {
        	
	        try {
	            if (!$token = JWTAuth::attempt($login)) {
		            return response()->json([
		            	'status_code' => 401,
		            	'message'     => 'Invalid login',
		            	'details' => (object)[]
		            ], 401);
	            }
	        }catch (JWTException $e) {
	            return response()->json(
	            	[
		            	'error' => 
		            	[
		            		'status_code' => 500,
			                'message'     => 'could_not_create_token, Server Error!',
			                'details'     =>(object)[]
		            	]
	            	],500
	            );
	        }
	        //Get users info
	        $user   = Auth::User();    
	        $userId = $user->id;
	        $find   = Auth::User($userId);
	        return response()->json(
	        	[
	        		'status_code'  =>200,
	        		'message'      =>'Login successfully!',
	        		'details'      =>(object)
	        		[
	        			'user_id'  =>$find->id,
	        			'name'     =>$find->full_name,
	        			'username' =>$find->username,
	        			'email'    =>$find->email,
	        			'role_id'  =>$find->role_id,
	        			'server_key_id'=>env('APP_KEY'),
	        			'access_token' =>$token
	        		]
	        	],200
	        );	
        }else{
        	return response()->json([
                'error' => 
	                [
	                	'status_code' =>400,
	                    'message'     => 'HTTP 400 Bad Request Login',
	                    'details'     => (object)[]
	                ]
                ],400
            );
        }

    }
    
    //List histories API 
    	public function APIHistories(Request $request) {
		$user          = Auth::User();    
        $userId        = $user->id;

    	// $histories = \DB::table('histories')

            $histories = History::join('devices', 'histories.device_id', '=', 'devices.id')
            ->join('history_status', 'histories.status_id', '=', 'history_status.id')
            ->join('users', 'histories.user_id', '=', 'users.id')
            ->join('types', 'devices.type_id', '=', 'types.id')
            ->join('manufactories', 'devices.manufatory_id', '=', 'manufactories.id')
            ->join('versions', 'devices.version_id', '=', 'versions.id')
            ->join('models', 'devices.model_id', '=', 'models.id')
            ->select('histories.*','history_status.image as status_image', 'users.full_name as username', 'devices.name as device_name','devices.description as device_description', 'devices.device_code as device_code','types.name as type_name','manufactories.name as manufactory_name', 'versions.name as version_name', 'models.name as model_name','history_status.name as status_name')
            ->orderBy('histories.status_id', 'ASC');

	        $limit   = $request->get('limit');
            $offset  = $request->get('offset');
            $server_key_id = $request->get('server_key_id');
			$token         = $request->get('Authorization');
			$start_at      = $request->get('start_at');
	        
	        if(isset($start_at) && empty($limit) && empty($offset)) {
	        	$histories->where('start_at','>=',$start_at);
	        	$histories = $histories->take(10)->get();
	        
	        }elseif(isset($start_at) && !empty($limit) && empty($offset)){
	        	$histories = $histories->limit($limit)->offset(0)->get();
	        
	        }elseif(isset($start_at) && !empty($limit) && !empty($offset)){
	        	$histories = $histories->limit(10)->offset($offset)->get();
	        
	        }elseif(empty($start_at) && !empty($limit) && !empty($offset)){
	        	$histories = $histories->limit($limit)->offset($offset)->get();
	        
	        }elseif(empty($start_at) && empty($limit) && empty($offset)){
	        	$histories = $histories->limit(10)->offset(0)->get();
	        
	        }else{
	        	$histories = $histories->take(10)->get();
	        }

		Log::debug("APIController@APIHistories" .$histories);
        return \Response::json(
			[	
				'status_code'=>200,
				'message'    =>'Show histories successully!',
				'details'    => $histories->toArray()
			], 200
		);
	}

	//Devices API
	public function listDevices(Request $request) {

		// $devices = \DB::table('devices')

            $devices = Device::join('types', 'devices.type_id', '=', 'types.id')
            ->join('manufactories', 'devices.manufatory_id', '=', 'manufactories.id')
            ->join('versions', 'devices.version_id', '=', 'versions.id')
            ->join('models', 'devices.model_id', '=', 'models.id')
            ->join('os', 'devices.os_id', '=', 'os.id')
            ->join('device_status', 'devices.status_id', '=', 'device_status.id')
            ->select('devices.id','devices.name','devices.device_code', 'devices.description','devices.image','types.id as type_id','types.name as type_name','manufactories.id as manufactory_id','manufactories.name as manufactory_name','versions.id as version_id', 'versions.name as version_name', 'models.id as model_id','models.name as model_name', 'os.id as os_id','os.name as os_name', 'device_status.id as status_id','device_status.name as status_name','device_status.image as status_image','devices.created_at', 'devices.updated_at')
            ->orderBy('devices.id', 'DESC');

            //Set values
            $limit   = $request->get('limit');
            $offset  = $request->get('offset');
            
	        if(empty($limit) && empty($offset)) {
	        	$devices = $devices->take(10)->get();
	        	// echo count($devices);
	        }elseif(!empty($limit) && empty($offset)){
	        	$devices = $devices->limit($limit)->offset(0)->get();
	        }elseif(empty($limit) && !empty($offset)){
	        	$devices = $devices->limit(10)->offset($offset)->get();/*paginate($offset);*/
	        }elseif(!empty($limit) && !empty($offset)){
	        	$devices = $devices->limit($limit)->offset($offset)->get();
	        }
	        
            // die();
            Log::debug('APIController@list_Deviecs: '.$devices);

			return \Response::json(
				[
					'status_code'=>200,
					'message'    =>'Show devices successully!',
					'details'    => $devices->toArray()
				], 200
			);
	}
	//response()->json($properties)-->setEncodingOptions(JSON_NUMERIC_CHECK);

	/*
	@Request Devices
	*/

	public function requestDevice($id ) {
		$defaultRequest = HistoryStatus::where('name',History::DEFAULT_HIS_REQUEST)->first();
		$user         = Auth::User();    
        $user_id      = $user->id;

		$device       = Device::findOrFail($id);
		$device_id    = $device->id;
		$status_id    = $defaultRequest->id;

        $input = Input::all();
        $request_device = new History();

        $request_device->device_id  = $device_id;
        $request_device->user_id    = $user_id;
        $request_device->status_id  = $status_id;

        if (!empty($input['start_at'] )) {
            $request_device->start_at = $input['start_at'];
        }
        if (!empty($input['end_at'] )) {
            $request_device->end_at = $input['end_at'];
        }
        //check if empty values
        if(empty($request_device->start_at) || empty($request_device->end_at)) {
        	return \Response::json(
				[
					'status_code'=>400,
					'message'    =>'Bad Request!',
					'details'    => (object)[]
				], 400
			);
        }

        //Check request devices before save data
    	// $histories = \DB::table('histories')
            $histories = History::join('devices', 'histories.device_id', '=', 'devices.id')
            ->join('history_status', 'histories.status_id', '=', 'history_status.id')
            ->join('users', 'histories.user_id', '=', 'users.id')
            ->select('histories.id')
            ->where('user_id', $user->id)
            ->where('device_id', $device->id)
            ->where('histories.status_id', $defaultRequest->id)->get();

        if(!count($histories)){
        	$request_device->save();

			return \Response::json(
				[
					'status_code'=>200,
					'message'    =>'You requests has been sent successully!',
					'details'    =>
					[
						'user_id'   => $request_device->user_id,
						'device_id' => $request_device->device_id,
						'status_id' => $request_device->status_id,
						'start_at'  => $request_device->start_at,
						'end_at'    => $request_device->end_at
					]
				], 200
			);
        	}else{
            return response()->json(
	            [
	                'status_code' => 404, 
	                'message'=> 'Sorry! You just request only one time!',
	                'details'   => (object)[]
	            ]
            );
        }
	}
	public function showAPIDevice(){
		$device_status = DeviceStatus::select('id', 'name', 'image')->get();
		$type          = Type::select('id', 'name')->get();
		$manufactories = Manufactory::select('id', 'name')->get();
		$versions      = Version::select('id', 'name')->get();
		$os            = Os::select('id', 'name')->get();
        $model         = Models::select('id', 'name')->get();

        return \Response::json(
			[
				'status_code'=>200,
				'message'    =>'Show data successully!',
				'details'    =>[
					'os'=>$os,
					'type'=>$type,
					'model'=>$model,
					'versions'=>$versions,
					'device_status'=>$device_status,
					'manufactories'=>$manufactories
				]
			], 200
		);
	}

	/*  
	 *@delete Devices
	/*/
	 public function deleteDevice($id) {
        \DB::table('devices')->where('id','=',$id)->delete();  
        \DB::table('histories')->where('device_id','=',$id)->delete(); 

        return \Response::json(array(
            'status_code'=> 200,
            'message'    => 'Device has been Deleted',
        	'details'    =>  (object)[]
        	),200
        );
    }

    //Loggout
    public function logout (Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        JWTAuth::invalidate($request->input('token'));
    }

}
// 200: Sucess //400: Bad Request //401: Authenticate //404: Not Found //500: Server Eror 
