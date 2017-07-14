<?php namespace crocodicstudio\crudbooster\controllers;

use crocodicstudio\crudbooster\controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use CRUDBooster;

class AdminController extends CBController {	

	function getIndex() {

		
		$dashboard = CRUDBooster::sidebarDashboard();		
		if($dashboard && $dashboard->url) {

			$resp = redirect($dashboard->url); 

			if(session()->has('message'))
			{
				$resp = 
				$resp->with(['message'=>session()->get('message'),'message_type'=>session()->get('message_type')]);
			}

			return $resp;
		}
		$data = array();			
		$data['page_title']       = '<strong>Dashboard</strong>';		
		$data['page_menu']        = Route::getCurrentRoute()->getActionName();		
		return view('crudbooster::home',$data);
	}

	public function getLockscreen() {
		
		if(!CRUDBooster::myId()) {
			Session::flush();
			return redirect()->route('getLogin')->with('message',trans('crudbooster.alert_session_expired'));
		}
		
		Session::put('admin_lock',1);
		return view('crudbooster::lockscreen');
	}

	public function postUnlockScreen() {
		$id       = CRUDBooster::myId();
		$password = Request::input('password');		
		$users    = DB::table(config('crudbooster.USER_TABLE'))->where('id',$id)->first();		

		if(\Hash::check($password,$users->password)) {
			Session::put('admin_lock',0);	
			return redirect()->route('AdminControllerGetIndex'); 
		}else{
			echo "<script>alert('".trans('crudbooster.alert_password_wrong')."');history.go(-1);</script>";				
		}
	}	

	public function getLogin()
	{											
		return view('crudbooster::login');
	}
 
	public function postLogin() {		

		$validator = Validator::make(Request::all(),			
			[
			'email'=>'required|email|exists:'.config('crudbooster.USER_TABLE'),
			'password'=>'required'			
			]
		);
		
		if ($validator->fails()) 
		{
			$message = $validator->errors()->all();
			return redirect()->back()->with(['message'=>implode(', ',$message),'message_type'=>'danger']);
		}

		$email 		= Request::input("email");
		$password 	= Request::input("password");
		$users 		= DB::table(config('crudbooster.USER_TABLE'))->where("email",$email)->first(); 		

		if(\Hash::check($password,$users->password)) {
			$priv = DB::table("cms_privileges")->where("id",$users->id_cms_privileges)->first();

			$roles = DB::table('cms_privileges_roles')
			->where('id_cms_privileges',$users->id_cms_privileges)
			->join('cms_moduls','cms_moduls.id','=','id_cms_moduls')
			->select('cms_moduls.name','cms_moduls.path','is_visible','is_create','is_read','is_edit','is_delete')
			->get();

			$other_permissions = DB::table('cms_privileges_other_permissions')
		->where('cms_privilege_id',$users->id_cms_privileges)
		->join('cms_other_permissions','cms_other_permissions.id', '=', 'cms_privileges_other_permissions.cms_other_permission_id')
		->select('cms_other_permissions.permission_group', 'cms_other_permissions.name')
		->get();


		Session::put('admin_other_permissions',$other_permissions);

			
			
			$photo = ($users->photo)?asset($users->photo):'https://www.gravatar.com/avatar/'.md5($users->email).'?s=100';
			Session::put('admin_id',$users->id);			
			Session::put('admin_is_superadmin',$priv->is_superadmin);
			Session::put('admin_name',$users->name);	
			Session::put('admin_photo',$photo);
			Session::put('admin_privileges_roles',$roles);
			Session::put('admin_other_permissions',$other_permissions);
			Session::put("admin_privileges",$users->id_cms_privileges);
			Session::put('admin_privileges_name',$priv->name);			
			Session::put('admin_lock',0);
			Session::put('theme_color',$priv->theme_color);
			Session::put("appname",CRUDBooster::getSetting('appname'));		

			CRUDBooster::insertLog(trans("crudbooster.log_login",['email'=>$users->email,'ip'=>Request::server('REMOTE_ADDR')]));		

			$cb_hook_session = new \App\Http\Controllers\CBHook;
			$cb_hook_session->afterLogin();

			return redirect()->route('AdminControllerGetIndex'); 
		}else{
			return redirect()->route('getLogin')->with('message', trans('crudbooster.alert_password_wrong'));			
		}		
	}

	public function getForgot() {		
		return view('crudbooster::forgot');
	}

	public function postForgot() {
		$validator = Validator::make(Request::all(),			
			[
			'email'=>'required|email|exists:'.config('crudbooster.USER_TABLE')			
			]
		);
		
		if ($validator->fails()) 
		{
			$message = $validator->errors()->all();
			return redirect()->back()->with(['message'=>implode(', ',$message),'message_type'=>'danger']);
		}	

		$rand_string = str_random(5);
		$password = \Hash::make($rand_string);

		DB::table(config('crudbooster.USER_TABLE'))->where('email',Request::input('email'))->update(array('password'=>$password));
 	
		$appname = CRUDBooster::getSetting('appname');		
		$user = CRUDBooster::first(config('crudbooster.USER_TABLE'),['email'=>g('email')]);	
		$user->password = $rand_string;
		CRUDBooster::sendEmail(['to'=>$user->email,'data'=>$user,'template'=>'forgot_password_backend']);

		CRUDBooster::insertLog(trans("crudbooster.log_forgot",['email'=>g('email'),'ip'=>Request::server('REMOTE_ADDR')]));

		return redirect()->route('getLogin')->with('message', trans("crudbooster.message_forgot_password"));

	}	

	public function getLogout() {
		
		$me = CRUDBooster::me();
		CRUDBooster::insertLog(trans("crudbooster.log_logout",['email'=>$me->email]));

		Session::flush();
		Cache::flush();
		
		return redirect()->route('getLogin')->with('message',trans("crudbooster.message_after_logout"));
	}

	public function getChangePassword()
	{
		$header_info['page_title'] = __('Change Password');
        $header_info['page_icon'] = 'fa fa-key';

        $header_info['breadcrumb_items'] = [
            [
                'icon' => $header_info['page_icon'],
                'name' => $header_info['page_title'],
                'url' => CRUDbooster::adminPath('admin/dashboard'),
            ],
        ];

        return view('crudbooster::change_password',compact('header_info'));
	}

	public function postChangePassword()
	{

		$validator = Validator::make(Request::all(),			
			[
				'old_password' => 'required',
				'password' => 'confirmed',
			]
		);
		
		if ($validator->fails()) 
		{
			$message = $validator->errors()->all();
			return redirect()->back()->with(['message'=>implode(', ',$message),'message_type'=>'danger']);
		}

		$current_user = DB::table('cms_users')
							->where('id', CRUDBooster::myId())
							->first();

		if (Hash::check(request()->old_password, $current_user->password) == false) {
		    
		    return redirect()->back()->with(['message'=>'Old password did not match!','message_type'=>'danger']);
		}

		DB::table('cms_users')
			->where('id', CRUDBooster::myId())
			->update(['password'=>Hash::make(request()->password)]);

		return redirect()->back()->with(['message'=>'Password Changed Successfully','message_type'=>'success']);
	}

}
