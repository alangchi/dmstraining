<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Mail\OrderShipped;
use App\User;
use Hash;
use Auth;
use Mail;
use App\Role;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user_data = \Session::get('user_data');
            if($user_data['role_name'] != 'admin'){
                return redirect('/login');
            }
            return $next($request);
        });
    }

    //test serach ajax auto complete
    public function searchUsers(Request $request) {
        return view('users.search');
    }
    public function TestSearchUsers(Request $request) {
        $defaultRoleUserAdmin  = Role::where('alias',User::DEFAULT_ROLE_ADMIN)->first();
        $defaultRoleUserManger = Role::where('alias',User::DEFAULT_ROLE_MANAGER)->first();
        $defaultRoleUserMember = Role::where('alias',User::DEFAULT_ROLE_ALIAS_USER_MEMBER)->first();
        //Normal search
        $search = $request->Input('search');
        $users_list = \DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*','roles.name as role_name')
         ->whereRaw(\DB::raw("(users.id like '%{$search}%' OR users.full_name like '%{$search}%' OR users.username like '%{$search}%' OR users.email like '%{$search}%')"))->paginate(20);
         //Search using ajax
        if($request->ajax()){
            $output = "";
            $role_name = "";
            $users = User::join('roles', 'users.role_id', '=', 'roles.id')
                ->where('full_name',  'LIKE', '%'.$request->search.'%')
                ->orWhere('full_name','LIKE', '%'.$request->search.'%')
                ->orWhere('username', 'LIKE', '%'.$request->search.'%')
                ->orWhere('email',    'LIKE', '%'.$request->search.'%')->get();
            if($users){
                $No = 0;
                foreach ($users as $key => $user) {
                $No = $No + 1 ;
                    if($user->role_id == $defaultRoleUserAdmin->id) {
                        $role_name = 'admin';
                    }elseif($user->role_name == $defaultRoleUserMember->id){
                        $role_name = 'member'; 
                    }else{
                        $role_name = 'manager';
                    }
                    
                    $output .= '<tr>'.
                                '<td>'.$No.'</td>'.
                                '<td>'.$user->id.'</td>'.
                                '<td>'.$user->full_name.'</td>'.
                                '<td>'.$user->username.'</td>'.
                                '<td>'.$user->email.'</td>'.
                                '<td>'.$role_name.'</td>'.
                                '<td>'.'<a href="edit_user/'.$user->id.'"><span class="glyphicon glyphicon-wrench"></span></a> &nbsp;&nbsp;
                                   <a Onclick="return ConfirmDelete();" href="delete_user/'.$user->id.'"><span class="glyphicon glyphicon-trash"></span></a>'.'</td>'.
                                '</tr>';
                }
                return Response($output);
            }
        }else{
            return view('users.search', ['users' => $users_list]);
        }
    }

    public function getCreateUser(){
        return view('users.add');
    }

    public function postCreateUser(UserRequest $requests){
        $create_new_user = new User();
        $create_new_user->full_name = $requests->full_name;
        $create_new_user->username  = $requests->username;
        $create_new_user->email     = $requests->email;
        $create_new_user->password  = Hash::make($requests->password);
        $create_new_user->role_id   = $requests->role_id;
        $create_new_user->remember_token = $requests->_token;

        $create_new_user->save();
        \Session::flash('flash_message','Add user successfully!');
        return redirect('/users/search');
    }

    //Show user
    public function ShowUser($id) {
        $defaultRoleUserAdmin = Role::where('alias',User::DEFAULT_ROLE_ADMIN)->first();
        $defaultRoleUserManger = Role::where('alias',User::DEFAULT_ROLE_MANAGER)->first();
        $defaultRoleUserMember = Role::where('alias',User::DEFAULT_ROLE_ALIAS_USER_MEMBER)->first();

        $data = \DB::table('users')->where('id', '=', $id)->first();
        $data = json_encode($data);
        $data = json_decode($data, true);
        // print_r(Auth::user()->id); die();
        // if((Auth::user()->id != 1) && ($id == 1 || ($data["role_id"] == 1 && (Auth::user()->id != $id)))) {
        //     return redirect()->route('admin.user.list')->with(['flash_level'=>'danger','flash_message'=>'Sorry !! You can not update this user!']);
        // }
        if((Auth::user()->id != $defaultRoleUserAdmin->id) && ($id == $defaultRoleUserAdmin->id || ($data["role_id"] == $defaultRoleUserAdmin->id && (Auth::user()->id != $id)))) {
            return redirect()->route('admin.user.list')->with(['flash_level'=>'danger','flash_message'=>'Sorry !! You can not update this user!']);
        }

        return view('users.update', compact('user', 'data', 'id', 'defaultRoleUserAdmin', 'defaultRoleUserManger', 'defaultRoleUserMember'));
    }

    public function updateUser($id, Request $request) {
        $data = User::find($id);

        if($request->input('txtPass')){
            $this->validate($request,
                [
                    'txtRePass'=>'same:txtPass'
                ], 
                [
                    'txtRePass.same'=>'Password not match!'
                ]);

            $password = $request->input('txtPass');

            $data->password   = Hash::make($password);
        }

        $data->full_name      = $request->full_name;
        $data->username       = $request->txtUser;
        $data->role_id        = $request->rdoLevel;
        $data->remember_token = $request->input('_token');
        $data->save();

        \Session::flash('flash_message','Updated user successfully!');
        return redirect('/users/list_users');
    }

    public function destroyUser($id) {
        \DB::table('users')->where('id','=',$id)->delete();  
        \DB::table('histories')->where('user_id','=',$id)->delete(); 
        $flash_message = [
            'flash_level'=>'success', 
            'flash_message'=> 'Delete USER successfully where ID = '.$id.'!'
        ];
        return redirect('/users/list_users')->with($flash_message);
    }

    //Sending email to user
    public function getSendEmail() {
        return view('users.email');
    }
    public function postSendEmail(Request $request) {
        // $data = $request->all();
        $data = array(
            'username' =>$request->username,
            'email'    =>$request->email,
            'bodymessage'=>$request->get('message')
        );
        Log::debug($data);
        Mail::send('users.mailsent', ['data'=>$data] , function($msg) use($data) {   
            // $msg->to('alangchi1994.pnv@gmail.com', 'User ');
            $msg->to($data['email'], $data['username']);
            $msg->subject('Sent email successfully!');
        });  

        $flash_message = ['flash_level'=>'success', 'Sent email successfully!'];
        return redirect('/users/list_users')->with($flash_message);
        
    }
}

