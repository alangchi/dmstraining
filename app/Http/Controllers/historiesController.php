<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Requests\DevicesRequest;
use App\Http\Controllers\Session;
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
use Auth;
use DB;
use Carbon\Carbon;
class historiesController extends Controller
{
    public function __construct(History $history){
    
        $this->history = $history;
    }

    public function getHistories(Request $request)
    {
        $defaultRequestDevice   = HistoryStatus::where('name',History::DEFAULT_HIS_REQUEST)->first();
        $defaultBorrowedDevice  = HistoryStatus::where('name',History::DEFAULT_HIS_BORROWED)->first();
        $defaultWarningDevice   = HistoryStatus::where('name',History::DEFAULT_HIS_WARNING)->first();
        $defaultReturnedDevice  = HistoryStatus::where('name',History::DEFAULT_HIS_RETURNED)->first();
        $defaultLostDevice      = HistoryStatus::where('name',History::DEFAULT_HIS_LOST)->first();
        $defaultCancelledDevice = HistoryStatus::where('name',History::DEFAULT_HIS_CANCELLED)->first();
        // $histories = DB::table('histories')->truncate();die(); 
        
         $search = $request->Input('search');

    	$query = DB::table('histories')
            ->join('devices', 'histories.device_id', '=', 'devices.id')
            ->join('history_status', 'histories.status_id', '=', 'history_status.id')
            ->join('users', 'histories.user_id', '=', 'users.id')
            ->join('types', 'devices.type_id', '=', 'types.id')
            ->join('manufactories', 'devices.manufatory_id', '=', 'manufactories.id')
            ->join('versions', 'devices.version_id', '=', 'versions.id')
            ->join('models', 'devices.model_id', '=', 'models.id')
            ->select('histories.*','history_status.image as status_image', 'users.full_name as username', 'devices.name as device_name','devices.description as device_description', 'devices.device_code as device_code','types.name as type_name','manufactories.name as manufactory_name', 'versions.name as version_name', 'models.name as model_name','history_status.id as history_status_id')
            ->whereRaw(\DB::raw("(histories.id like '%{$search}%' OR histories.start_at like '%{$search}%' OR histories.end_at like '%{$search}%' OR histories.user_id like '%{$search}%')"))
            ->orderBy('histories.status_id', 'ASC');

            $histories = $query->paginate(20);
        return view('devices/history', compact('histories', 'defaultRequestDevice',$defaultRequestDevice , 'defaultBorrowedDevice', $defaultBorrowedDevice, 'defaultWarningDevice',$defaultWarningDevice, 'defaultReturnedDevice',$defaultReturnedDevice, 'defaultLostDevice', $defaultLostDevice, 'defaultCancelledDevice', $defaultCancelledDevice));
    }
    /**
     * Get info to show interface.
     *
     * @return details devices 
     */
    public function getAdd() {
        $type        = Type::select('id', 'name')->get();
        $version     = Version::select('id', 'name')->get();
        $manufactory = Manufactory::select('id', 'name')->get();
        $status      = DB::table('device_status')->get();
        $model       = DB::table('models')->get(); 
        $os          = DB::table('os')->get();
    	return view('devices/add', compact('type', 'version', 'manufactory', 'status','model','os'));	
    }

    /**
     * @Store infomation of devices.
     * @param Request, $request
     * @return details devices 
     */

    public function storeDevice(DevicesRequest $request) {
        if($request->wantsJson()){ // api
            $user = \JWTAuth::parseToken()->authenticate();
        }else{
            // web
            $user = Auth::user();
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

        $defaultDevice = DeviceStatus::where('name',Device::DEFAULT_DEVICE_AVAILABLE)->first();
        $name          = $request->get('name');
        $device_code   = $request->get('device_code');
        $description   = $request->get('description');
        $image         = $request->get('image');
        $type_id       = $request->get('type_id');
        $os_id         = $request->get('os_id');
        $version_id    = $request->get('version_id');
        $manufatory_id = $request->get('manufatory_id');
        $model_id      = $request->get('model_id');
        $status_id     = $defaultDevice->id;

        if($request->hasFile('image')) {
            $file = $request->file('image');
            //getting timestamp
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $image = $timestamp. '-' .$file->getClientOriginalName();
            $file->move(public_path().'/img_uploads/', $image);
        }
        $device = new Device();
        $device->name = $name;
        $device->device_code = $device_code;
        $device->description = $description;
        $device->image = $image;
        if($type_id       != 0) $device->type_id = $type_id;
        if($os_id         != 0) $device->os_id = $os_id;
        if($manufatory_id != 0) $device->manufatory_id = $manufatory_id;
        if($version_id    != 0) $device->version_id = $version_id;
        if($model_id      != 0) $device->model_id = $model_id;
        if($status_id     != 0) $device->status_id = $status_id;
        $device->save();
        Log::debug('Store device ion DB :' .$device);
        //check API
        //if($request->wantsJson())

        if ($request->is('api/*')){
            return \Response::json(
                [
                    'status_code'=>200,
                    'message'    =>'Stored successfully!',
                    'details'    => $device
                ], 200
            );
        } else {
            \Session::flash('flash_message','Add Device Successfully!');
            return redirect('/dashboard');
        }
    }

    //Update status id in histories to Approve borrow devices
    public function approveDeviceBorrow(Request $request, $id) {
        if($request->wantsJson()){ // api
            $user = \JWTAuth::parseToken()->authenticate();
        }else{
            // web
            $user = Auth::user();
            if($user->roles->name !== "admin"){
                return response()->json(
                    [
                        'error' => 
                        [
                            'status_code' => 403,//loi ko co quyen truy cap
                            'message'     => 'Permission error with authenticate! You cann\'t Approve to borrow!',
                            'details'     =>(object)[]
                        ]
                    ],403
                );
            }
        }

        $history_status_default_requesting = HistoryStatus::where('name',History::DEFAULT_HIS_REQUEST)->first();
        $history_status_default_borrowed   = HistoryStatus::where('name',History::DEFAULT_HIS_BORROWED)->first();
        $history_status_default_cancelled  = HistoryStatus::where('name',History::DEFAULT_HIS_CANCELLED)->first();

        $history = $this->history->find($id);
        $history ->status_id = $history_status_default_borrowed->id;//Borrowed,
        $history ->save();

        //Cancel requesting of others 
        $device = Device::find($history->device_id);
        $history_cancel = DB::table('histories')
            ->select('histories.id')
            ->where('device_id', $device->id)
            ->where('histories.status_id', $history_status_default_requesting->id)
            ->update(['histories.status_id' => $history_status_default_cancelled->id]);
        //Update device
        $defaultDeviceUnavailable = DeviceStatus::where('name',Device::DEFAULT_DEVICE_UNAVAILABLE)->first();
        $device->status_id = $defaultDeviceUnavailable->id;//status id of device unavailable
        $device->save();

        if ($request->is('api/*')){
            return \Response::json(
                [
                    'status_code'=>200,
                    'message'    =>'approve Borrow Device successfully!',
                    'details'    => [
                        'device'    =>$device,
                        'histories' =>$history
                    ]
                ], 200
            );
        } else {
            return redirect('devices/histories');
        }
    }


    //Admin approve users return devices 
    public function approveReturnDevices(Request $request, $id){
        if($request->wantsJson()){ // api
            $user = \JWTAuth::parseToken()->authenticate();
        }else{
            // web
            $user = Auth::user();
            if($user->roles->name !== "admin"){
                return response()->json(
                    [
                        'error' => 
                        [
                            'status_code' => 403,//loi ko co quyen truy cap
                            'message'     => 'Permission error with authenticate! You cann\'t Approve Return!',
                            'details'     =>(object)[]
                        ]
                    ],403
                );
            }
        }

        $defaultReturnDevices = HistoryStatus::where('name',History::DEFAULT_HIS_RETURNED)->first();
        $history = $this->history->find($id);
        $history->status_id = $defaultReturnDevices->id;//available
        $history->save();

        $defaultDevicesAvalable = DeviceStatus::where('name',Device::DEFAULT_DEVICE_AVAILABLE)->first();
        $device = Device::find($history->device_id);
        $device->status_id = $defaultDevicesAvalable->id;//available
        $device->save();

        if ($request->is('api/*')){
            return \Response::json(
                [
                    'status_code'=>200,
                    'message'    =>'approve returned Device successfully!',
                    'details'    => [
                        'device'    =>$device,
                        'histories' =>$history
                    ]
                ], 200
            );
        } else {
            return redirect('devices/histories');
        }
    }

    //Admin send messages
    public function sendMessages(Request $requests, $id)
    {
        if($requests->wantsJson()){ // api
            $user = \JWTAuth::parseToken()->authenticate();
        }else{
            // web
            $user = Auth::user();
            if($user->roles->name !== "admin"){
                return response()->json(
                    [
                        'error' => 
                        [
                            'status_code' => 403,//loi ko co quyen truy cap
                            'message'     => 'Permission error with authenticate! You cann\'t Send message!',
                            'details'     =>(object)[]
                        ]
                    ],403
                );
            }
        }

        $defaultWarningDevicesBorrow = HistoryStatus::where('name',History::DEFAULT_HIS_WARNING)->first();
        $history = $this->history->find($id);
        $history->status_id = $defaultWarningDevicesBorrow->id;//warning
        $history->save();

        if ($requests->is('api/*')){
            return \Response::json(
                [
                    'status_code'=>200,
                    'message'    =>'Send successfully!',
                    'details'    => $history
                ], 200
            );
        } else {
            return redirect('devices/histories');
        }
    }

}
