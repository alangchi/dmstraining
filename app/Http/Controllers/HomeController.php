<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\DevicesRequest;
use App\Http\Controllers\Session;
use App\DeviceStatus;
use App\Manufactory;
use Carbon\Carbon;
use App\Version;
use App\History;
use App\Models;
use App\Device;
use App\Type;
use App\User;
use Illuminate\Support\Facades\Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Device $devices, History $history)
    {
        /*$this->applyMiddlewareForWeb();
        $this->applyMiddlewareForApi();*/

        $this->devices = $devices;
        $this->history = $history;
    }

/*    private function applyMiddlewareForWeb(){
        $this->middleware(function ($request, $next) {
            $user_data = \Session::get('user_data');
            if($user_data['role_name'] != 'admin'){
                return redirect('/login');
            }
            return $next($request);
        })->except(['updateDevice']);
    }

    private function applyMiddlewareForApi(){
        $this->middleware(function ($request, $next) {
            $user =  \JWTAuth::parseToken()->authenticate();
            if($user->roles->name !== "admin"){
                return response()->json(
                    [
                        'error' => 
                        [
                            'status_code' => 403,//loi ko co quyen truy cap
                            'message'     => 'Permission error',
                            'details'     =>(object)[]
                        ]
                    ],403
                );
            }   
            return $next($request);
        })->only(['updateDevice']);
    }*/

    /**
     * Show the application dashboard admin
     *
     * @return \Illuminate\Http\Response
     */

     public function homePage()
    {
        return view('auth/login');
    }

    //Serach device
    public function searchDeviceAPI(Request $request) {
        $search = $request->get('search');
        $search_device = DB::table('devices')
            ->join('types', 'devices.type_id', '=', 'types.id')
            ->join('manufactories', 'devices.manufatory_id', '=', 'manufactories.id')
            ->join('versions', 'devices.version_id', '=', 'versions.id')
            ->join('models', 'devices.model_id', '=', 'models.id')
            ->join('os', 'devices.os_id', '=', 'os.id')
            ->join('device_status', 'devices.status_id', '=', 'device_status.id')
            ->select('devices.id','devices.name','devices.device_code', 'devices.description','devices.image','types.id as type_id','types.name as type_name','manufactories.id as manufactory_id','manufactories.name as manufactory_name','versions.id as version_id', 'versions.name as version_name', 'models.id as model_id','models.name as model_name', 'os.id as os_id','os.name as os_name', 'device_status.id as status_id','device_status.name as status_name','device_status.image as status_image','devices.created_at', 'devices.updated_at')
            ->where('device_code', '=', $search)->get();
            //check valid
            $count_value = count($search_device);
            if($count_value > 0){
                return \Response::json([
                    'status_code'=>200,
                    'message'    =>'Search device successully!',
                    'details'    =>$search_device
                ],200); 
                
            }else{
                return \Response::json([
                    'status_code'=>401,
                    'message'    =>'Search device not found!',
                    'details'    => (object)[]
                ],401);
            }
            
    }

    //Show device details
    public function showDeviceDetails($deviceID) {
        $device_details   = DB::table('devices')
            ->join('types', 'devices.type_id', '=', 'types.id')
            ->join('manufactories', 'devices.manufatory_id', '=', 'manufactories.id')
            ->join('versions', 'devices.version_id', '=', 'versions.id')
            ->join('models', 'devices.model_id', '=', 'models.id')
            ->join('os', 'devices.os_id', '=', 'os.id')
            ->join('device_status', 'devices.status_id', '=', 'device_status.id')
            ->select('devices.*','types.name as type_name','manufactories.name as manufactory_name', 'versions.name as version_name', 'models.name as model_name', 'device_status.image as status_image', 'device_status.name as status_name')
            ->orderBy('devices.id', 'DESC')->first();
        return view('devices/details',['device_details'=>$device_details]);
    }

    public function index(Request $request)
    {
        
        //Get data to show in form
        $os          = DB::table('os')->get();
        $model       = DB::table('models')->get(); 
        $type        = Type::select('id', 'name')->get();
        $version     = Version::select('id', 'name')->get();
        $manufactory = Manufactory::select('id', 'name')->get();
        // Filter input data
        $manufatory_id = Input::get('manufactory_devices');
        $version_id    = Input::get('version_devices');
        $model_id      = Input::get('model_devices');
        $type_id       = Input::get('type_devices');
        $os_id         = Input::get('os_devices');

        $search = $request->Input('search');

        Log::debug('DevicesController@Deviecs :' .$search);
        //Show data on table
        $dashboard   = DB::table('devices')
            ->join('types', 'devices.type_id', '=', 'types.id')
            ->join('manufactories', 'devices.manufatory_id', '=', 'manufactories.id')
            ->join('versions', 'devices.version_id', '=', 'versions.id')
            ->join('models', 'devices.model_id', '=', 'models.id')
            ->join('os', 'devices.os_id', '=', 'os.id')
            ->join('device_status', 'devices.status_id', '=', 'device_status.id')
            ->select('devices.*','types.name as type_name','manufactories.name as manufactory_name', 'versions.name as version_name', 'models.name as model_name', 'device_status.image as status_image')
            ->whereRaw(\DB::raw("(devices.id like '%{$search}%' OR devices.name like '%{$search}%' OR devices.device_code like '%{$search}%' OR devices.description like '%{$search}%')"))
            ->orderBy('devices.id', 'DESC');
            //Filter before search
            if(!empty($manufatory_id)) {
                $dashboard->where('devices.manufatory_id','=',$manufatory_id);
            }

            if(!empty($version_id)) {
                $dashboard->where('devices.version_id','=', $version_id);
            }

            if(!empty($type_id)) {
                $dashboard->where('devices.type_id','=', $type_id);
            }

            if(!empty($model_id)) {
                $dashboard->where('devices.model_id', $model_id);
            }

            if(!empty($os_id)) {
                $dashboard->where('devices.os_id','=', $os_id);
            }

            $dashboard = $dashboard->paginate(20);    
    
        return view('dashboard', compact('dashboard', 'type', 'os','model', 'version', 'manufactory'));
    }

    public function getEdit($id) {

        $devicesChange = Device::find($id);
        // var_dump($devicesChange); die();
        $type          = Type::select('id', 'name')->get();
        $version       = Version::select('id', 'name')->get();
        $manufactory   = Manufactory::select('id', 'name')->get();
        $status        = DB::table('device_status')->get();
        $model         = DB::table('models')->get(); 
        $os            = DB::table('os')->get();
        return view('devices/change', compact('devicesChange', 'type','version', 'manufactory', 'status', 'model', 'os'));
    }

    public function updateDevice(Request $requests,$id)
    {
        if($requests->wantsJson()){ // api
            $user = \JWTAuth::parseToken()->authenticate();
        }else{
            // web
            $user = \Auth::user();
            if($user->roles->name !== "admin"){
                return response()->json(
                    [
                        'error' => 
                        [
                            'status_code' => 403,//loi ko co quyen truy cap
                            'message'     => 'Permission error with authenticate! You cann\'t update!',
                            'details'     =>(object)[]
                        ]
                    ],403
                );
            }
        }
        $devices = Device::find($id);
        $name          = $requests->get('name');
        $device_code   = $requests->get('device_code');
        $description   = $requests->get('description');
        $image         = $requests->get('image');
        $type_id       = $requests->get('type_id');
        $os_id         = $requests->get('os_id');
        $version_id    = $requests->get('version_id');
        $manufatory_id = $requests->get('manufatory_id');
        $model_id      = $requests->get('model_id');
        $status_id     = $requests->get('status_id');

        if($devices->image){ $image =$devices->image; }
        $devices->image = $image;

        if($requests->hasFile('image')) {
            //delete image if add new image
            \File::delete(public_path('/img_uploads/'.$devices->image));

            $file      = $requests->file('image');
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $image     = $timestamp. '-' .$file->getClientOriginalName();
            $file->move(public_path().'/img_uploads/', $image);
            $input['image'] = $image;
        }

        $devices->name = $name;
        $devices->device_code = $device_code;
        $devices->description = $description;
        $devices->image = $image;

        if($devices->type_id){$devices->type_id = $type_id;}
        $devices->type_id = $type_id;

        if($devices->os_id){$devices->os_id = $os_id;}
        $devices->os_id = $os_id;

        if($devices->manufatory_id){$devices->manufatory_id = $manufatory_id;}
        $devices->manufatory_id = $manufatory_id;

        if($devices->version_id){$devices->version_id = $version_id;}
        $devices->version_id = $version_id;

        if($devices->model_id){$devices->model_id = $model_id;}
        $devices->model_id = $model_id;

        if($devices->status_id){$devices->status_id = $status_id;}
        $devices->status_id = $status_id;
        $devices->save($requests->all());

        if ($requests->is('api/*')){
            return \Response::json(
                [
                    'status_code'=>200,
                    'message'    =>'Devices has been updated successully!',
                    'details'    => $devices
                ], 200
            );
        } else {
            \Session::flash('flash_message','Updated Device Successfully Where ID ='.$id.'!');
            return redirect('/dashboard');
        }
    }

    /*
    |   @Request id
    |   Delete relationship
    |   delete device functiom
    */
    public function getDelete($id) {

    try {
        $device = Device::where('id',$id)->first();
        $history = History::where('id',$id)->first();
      } catch (ModelNotFoundException $e) {
        return redirect('/dashboard')->with(['message'=> 'Failed']);
      }

        $devicefile = $device->image;
        $path = 'img_uploads/'.$devicefile;
        \File::delete(public_path($path));
        if($history){
            $history->delete();
            $device->delete();
        }else{
            $device->delete();
        }

        $flash_message = [
            'flash_level'=>'success', 
            'flash_message'=> 'Delete DEVICE successfully where ID = '.$id.'!'
        ];
        return redirect('/dashboard')->with($flash_message);
    }
}