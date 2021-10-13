<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\Contracts\HelperContract; 
use Auth;
use Session; 
use Cookie;
use Validator; 
use Carbon\Carbon;
use App\User; 
//use Codedge\Fpdf\Fpdf\Fpdf;
use PDF;

class AdminController extends Controller {

	protected $helpers; //Helpers implementation
    
    public function __construct(HelperContract $h)
    {
    	$this->helpers = $h;                      
    }

	
	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getIndex(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$v = "index";
				$stats = $this->helpers->getSiteStats();
				$accts = $this->helpers->getUsers();
				#dd($stats);
				$req = $request->all();
                array_push($cpt,'stats');					
                array_push($cpt,'accts');					
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		
		return view($v,compact($cpt));
		
    }
	
	
	/**
	 * Show list of registered users on the platform.
	 *
	 * @return Response
	 */
	public function getUsers(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "users";
				$req = $request->all();
                $users = $this->helpers->getUsers();
				#dd($users);
                array_push($cpt,'users');
                }
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Show the Add  User form
	 *
	 * @return Response
	 */
	public function getAddUser(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-user";
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Handle update user.
	 *
	 * @return Response
	 */
	public function postAddUser(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				$validator = Validator::make($req,[
		                    'fname' => 'required',
		                    'lname' => 'required',
		                    'username' => 'required',
		                    'role' => 'required|not_in:none',
		                    'status' => 'required|not_in:none'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->createUser($req);
					$ss = "create-user-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended('users');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Show details of a registered user on the platform.
	 *
	 * @return Response
	 */
	public function getUser(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				if(isset($req['xf']))
				{
					$xf = $req['xf'];
					$v = "user";
				    $u = $this->helpers->getUser($xf);
					
					if(count($u) < 1)
					{
						session()->flash("invalid-user-status-error","ok");
						return redirect()->intended('users');
					}
					else
					{
						$users = [];
						#dd(count($reviews));
                        array_push($cpt,'u');
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('users');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Handle update user.
	 *
	 * @return Response
	 */
	public function postUser(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				$validator = Validator::make($req,[
		                    'fname' => 'required',
		                    'lname' => 'required',
		                    'role' => 'required|not_in:none',
		                    'status' => 'required|not_in:none'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->updateUser($req);
					$ss = "update-user-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->back();
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Handle Enable/Disable user.
	 *
	 * @return Response
	 */
	public function getEnableDisableUser(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$validator = Validator::make($req,[
		                    'xf' => 'required|numeric',
		                    'type' => 'required',
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->updateEDU($req);
					$ss = "update-user-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->back();
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Show the Add Permission view.
	 *
	 * @return Response
	 */
	public function getAddPermission(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$permissions = $this->helpers->permissions;
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$xf = $req['xf'];
					$v = "add-permissions";
					$uu = User::where('id',$xf)
					          ->orWhere('email',$xf)->first();
							  
					if($uu == null)
					{
						session()->flash("invalid-user-status-error","ok");
						return redirect()->intended('users');
					}
				    $u = $this->helpers->getUser($xf);
					
					if(count($u) < 1)
					{
						session()->flash("invalid-user-status-error","ok");
						return redirect()->intended('users');
					}
					else
					{
						array_push($cpt,'u');                       
						array_push($cpt,'permissions');                       
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('users');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add permission.
	 *
	 * @return Response
	 */
	public function postAddPermission(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'xf' => 'required',
		                    'pp' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$pp = json_decode($req['pp']);
					$ptags = [];
					
					foreach($pp as $p)
					{
						if($p->selected) array_push($ptags,$p->ptag);
					}
					
					$dt = [
					     'xf' => $req['xf'],
					     'ptags' => $ptags,
					     'granted_by' => $user->id
					   ];
					   
					$ret = $this->helpers->addPermissions($dt);
					$ss = "add-permissions-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("user?xf=".$req['xf']);
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Handle remove permission.
	 *
	 * @return Response
	 */
	public function getRemovePermission(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required',
		                    'p' => 'required',
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removePermission($req);
					  $ss = "remove-permission-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("user?xf=".$req['xf']);
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	
	
	/**
	 * Show list of plugins.
	 *
	 * @return Response
	 */
	public function getPlugins(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_plugins']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				 $v = "plugins";
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Show the Add Plugin view.
	 *
	 * @return Response
	 */
	public function getAddPlugin(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_plugins','edit_plugins']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-plugin";
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add plugin.
	 *
	 * @return Response
	 */
	public function postAddPlugin(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_plugins','edit_plugins']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'status' => 'required|not_in:none',
                             'name' => 'required',
                             'value' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->createPlugin($req);
					$ss = "add-plugin-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("plugins");
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Show the Edit Plugin view.
	 *
	 * @return Response
	 */
	public function getPlugin(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$permissions = $this->helpers->permissions;
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_plugins','edit_plugins']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['s']))
				{
					$v = "plugin";
					$p = $this->helpers->getPlugin($req['s']);
					
					if(count($p) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('plugins');
					}
					else
					{
						array_push($cpt,'p');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('plugins');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Handle edit plugin.
	 *
	 * @return Response
	 */
	public function postPlugin(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_plugins','edit_plugins']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'status' => 'required|not_in:none',
                             'xf' => 'required|numeric',
                             'name' => 'required',
                             'value' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->updatePlugin($req);
					$ss = "update-plugin-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("plugins");
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Handle remove plugin.
	 *
	 * @return Response
	 */
	public function getRemovePlugin(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_plugins','edit_plugins']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    's' => 'required'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removePlugin($req['s']);
					  $ss = "remove-plugin-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("plugins");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
  /**
	 * Show the Add Sender view.
	 *
	 * @return Response
	 */
	public function getAddSender(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
       
	   
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_senders','edit_senders']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				 $v = "add-sender";
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
		
    }
	
	/**
	 * Handle add sender.
	 *
	 * @return Response
	 */
	public function postAddSender(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_senders','edit_senders']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				  #dd($req);
				
				  $validator = Validator::make($req,[
                    'server' => 'required|not_in:none',
                    'name' => 'required',
                    'username' => 'required'
		                   ]);
						
				 if($validator->fails())
                 {
                   session()->flash("validation-status-error","ok");
			       return redirect()->back()->withInput();
                 }
				 else
				 {
		         	$dt = ['type' => $req['server'],'sn' => $req['name'],'su' => $req['username'],'spp' => $req['password']];
         
					 if($req['server'] == "other")
					 {
						$v = isset($req['ss']) && isset($req['sp']) && isset($req['sec']) && $req['sec'] != "nonee";
						if($v)
						{
							$dt['ss'] = $req['ss'];
							$dt['sp'] = $req['sp'];
							$dt['sec'] = $req['sec'];
						}
						else
						{
							session()->flash("validation-status-error", "success"); 
							return redirect()->back()->withInput();
						}
					 }
					else
		            {
		            	$smtp = $this->helpers->smtpp[$req['server']];
		                $dt['ss'] = $smtp['ss'];
							$dt['sp'] = $smtp['sp'];
							$dt['sec'] = $smtp['sec'];
		            }
            
		            $dt['se'] = $dt['su'];
		            $dt['sa'] = "yes";
		            $dt['current'] = "no";
		            $ret = $this->helpers->createSender($dt);
					$ss = "add-sender-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("senders");
				 }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
    
         /**
	 * Show the Senders view.
	 *
	 * @return Response
	 */
	 	public function getSenders(Request $request)
	     {
	 		$user = null;
	 		$nope = false;
	 		$v = "";
		
	 		$signals = $this->helpers->signals;
	 		$plugins = $this->helpers->getPlugins();
	 		$cpt = ['user','signals','plugins'];
       
	   
	 		if(Auth::check())
	 		{
			
	 			$user = Auth::user();
			
	 			if($this->helpers->isAdmin($user))
	 			{
	 				$hasPermission = $this->helpers->hasPermission($user->id,['view_senders','edit_senders']);
	 				#dd($hasPermission);
	 				$req = $request->all();
				
	 				if($hasPermission)
	 				{
						$senders = $this->helpers->getSenders();
						array_push($cpt,'senders');
	 				    $v = "senders";
	 				}
	 				else
	 				{
	 					session()->flash("permissions-status-error","ok");
	 					return redirect()->intended('/');
	 				}				
	 			}
	 			else
	 			{
	 				Auth::logout();
	 				$u = url('/');
	 				return redirect()->intended($u);
	 			}
	 		}
	 		else
	 		{
	 			$v = "login";
	 		}
	 		return view($v,compact($cpt));
		
	     }
		 
         /**
	 * Show the Sender view.
	 *
	 * @return Response
	 */
	 	public function getSender(Request $request)
	     {
	 		$user = null;
	 		$nope = false;
	 		$v = "";
		
	 		$signals = $this->helpers->signals;
	 		$plugins = $this->helpers->getPlugins();
	 		$cpt = ['user','signals','plugins'];
       
	   
	 		if(Auth::check())
	 		{
			
	 			$user = Auth::user();
			
	 			if($this->helpers->isAdmin($user))
	 			{
	 				$hasPermission = $this->helpers->hasPermission($user->id,['view_senders','edit_senders']);
	 				#dd($hasPermission);
	 				$req = $request->all();
				
	 				if($hasPermission)
	 				{
						$req = $request->all();
						
				        $validator = Validator::make($req, [                          
				                             's' => 'required'
				         ]);
         
				         if($validator->fails())
				         {
				         	return redirect()->intended('senders');
				         }
						else
						{
						   $s = $this->helpers->getSender($req['s']);
						   array_push($cpt,'s');
	 				       $v = "sender";
					    }
	 				}
	 				else
	 				{
	 					session()->flash("permissions-status-error","ok");
	 					return redirect()->intended('/');
	 				}				
	 			}
	 			else
	 			{
	 				Auth::logout();
	 				$u = url('/');
	 				return redirect()->intended($u);
	 			}
	 		}
	 		else
	 		{
	 			$v = "login";
	 		}
	 		return view($v,compact($cpt));
		
	     }
		 
		 
	 	/**
	 	 * Handle update sender.
	 	 *
	 	 * @return Response
	 	 */
	 	public function postSender(Request $request)
	     {
	 		$user = null;
	 		if(Auth::check())
	 		{
	 			$user = Auth::user();
			
	 			if($this->helpers->isAdmin($user))
	 			{
	 				$hasPermission = $this->helpers->hasPermission($user->id,['view_senders','edit_senders']);
	 				#dd($hasPermission);
	 				$req = $request->all();
				
	 				if($hasPermission)
	 				{
				
	 				  #dd($req);
				
	 				  $validator = Validator::make($req,[
	                     'server' => 'required|not_in:none',
	                     'name' => 'required',
	                     'username' => 'required'
	 		                   ]);
						
	 				 if($validator->fails())
	                  {
	                    session()->flash("validation-status-error","ok");
	 			       return redirect()->back()->withInput();
	                  }
	 				 else
	 				 {
	 		         	$dt = ['type' => $req['server'],'sn' => $req['name'],'su' => $req['username'],'spp' => $req['password']];
         
	 					 if($req['server'] == "other")
	 					 {
	 						$v = isset($req['ss']) && isset($req['sp']) && isset($req['sec']) && $req['sec'] != "nonee";
	 						if($v)
	 						{
	 							$dt['ss'] = $req['ss'];
	 							$dt['sp'] = $req['sp'];
	 							$dt['sec'] = $req['sec'];
	 						}
	 						else
	 						{
	 							session()->flash("validation-status-error", "success"); 
	 							return redirect()->back()->withInput();
	 						}
	 					 }
	 					else
	 		            {
	 		            	$smtp = $this->helpers->smtpp[$req['server']];
	 		                $dt['ss'] = $smtp['ss'];
	 							$dt['sp'] = $smtp['sp'];
	 							$dt['sec'] = $smtp['sec'];
	 		            }
            
	 		            $dt['se'] = $dt['su'];
	 		            $dt['sa'] = "yes";
	 		            $dt['current'] = "no";
	 		            $ret = $this->helpers->createSender($dt);
	 					$ss = "add-sender-status";
	 					if($ret == "error") $ss .= "-error";
	 					session()->flash($ss,"ok");
	 			        return redirect()->intended("senders");
	 				 }
	 				}
	 				else
	 				{
	 					session()->flash("permissions-status-error","ok");
	 					return redirect()->intended("/");
	 				}
	 			}
	 			else
	 			{
	 				Auth::logout();
	 				$u = url('/');
	 				return redirect()->intended($u);
	 			}
	 		}
	 		else
	 		{
	 			return redirect()->intended('/');
	 		}
	     }
		 
		 
         /**
	 * Handle Remove Sender.
	 *
	 * @return Response
	 */
	 	public function getRemoveSender(Request $request)
	     {
	 		$user = null;
	 		$nope = false;
	 		$v = "";
		
	 		$signals = $this->helpers->signals;
	 		$plugins = $this->helpers->getPlugins();
	 		$cpt = ['user','signals','plugins'];
       
	   
	 		if(Auth::check())
	 		{
			
	 			$user = Auth::user();
			
	 			if($this->helpers->isAdmin($user))
	 			{
	 				$hasPermission = $this->helpers->hasPermission($user->id,['view_senders','edit_senders']);
	 				#dd($hasPermission);
	 				$req = $request->all();
				
	 				if($hasPermission)
	 				{
						$req = $request->all();
						
				        $validator = Validator::make($req, [                          
				                             's' => 'required'
				         ]);
         
				         if($validator->fails())
				         {
				         	return redirect()->intended('senders');
				         }
						else
						{
						   $this->helpers->removeSender($req['s']);
   	 					   $ss = "remove-sender-status";
   	 					   session()->flash($ss,"ok");
   	 			           return redirect()->intended("senders");
					    }
	 				}
	 				else
	 				{
	 					session()->flash("permissions-status-error","ok");
	 					return redirect()->intended('/');
	 				}				
	 			}
	 			else
	 			{
	 				Auth::logout();
	 				$u = url('/');
	 				return redirect()->intended($u);
	 			}
	 		}
	 		else
	 		{
	 			$v = "login";
	 		}
	 		return view($v,compact($cpt));
		
	     }
		 
		 
         /**
	 * Handle Remove Sender.
	 *
	 * @return Response
	 */
	 	public function getMarkSender(Request $request)
	     {
	 		$user = null;
	 		$nope = false;
	 		$v = "";
		
	 		$signals = $this->helpers->signals;
	 		$plugins = $this->helpers->getPlugins();
	 		$cpt = ['user','signals','plugins'];
       
	   
	 		if(Auth::check())
	 		{
			
	 			$user = Auth::user();
			
	 			if($this->helpers->isAdmin($user))
	 			{
	 				$hasPermission = $this->helpers->hasPermission($user->id,['view_senders','edit_senders']);
	 				#dd($hasPermission);
	 				$req = $request->all();
				
	 				if($hasPermission)
	 				{
						$req = $request->all();
						
				        $validator = Validator::make($req, [                          
				                             's' => 'required'
				         ]);
         
				         if($validator->fails())
				         {
				         	return redirect()->intended('senders');
				         }
						else
						{
						   $this->helpers->setAsCurrentSender($req['s']);
   	 					   $ss = "mark-sender-status";
   	 					   session()->flash($ss,"ok");
   	 			           return redirect()->intended("senders");
					    }
	 				}
	 				else
	 				{
	 					session()->flash("permissions-status-error","ok");
	 					return redirect()->intended('/');
	 				}				
	 			}
	 			else
	 			{
	 				Auth::logout();
	 				$u = url('/');
	 				return redirect()->intended($u);
	 			}
	 		}
	 		else
	 		{
	 			$v = "login";
	 		}
	 		return view($v,compact($cpt));
		
	     }
	
	
	
	
	
	
	/**
	 * Show list of banners.
	 *
	 * @return Response
	 */
	public function getBanners(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_banners']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				 $v = "banners";
				 $banners = $this->helpers->getBanners();
				 #dd($banners);
				 array_push($cpt,'banners');
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Show the Add Banner view.
	 *
	 * @return Response
	 */
	public function getAddBanner(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_banners','edit_banners']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-banner";
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add banner.
	 *
	 * @return Response
	 */
	public function postAddBanner(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_banners','edit_banners']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                     'ab-images' => 'required',
                             'type' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ird = [];
                    $networkError = false;
				
                    for($i = 0; $i < count($req['ab-images']); $i++)
                    {
            		  $img = $req['ab-images'][$i];
					  $imgg = $this->helpers->uploadCloudImage($img->getRealPath());
						
					  if(isset($imgg['status']) && $imgg['status'] == "error")
					  {
						  $networkError = true;
						  break;
					  }
					  else
					  {
						 $req['cover'] = "no";
					     $req['ird'] = $imgg['public_id'];
					     $req['delete_token'] = $imgg['delete_token'];
					     $req['deleted'] = "no";
					  }
             	        								
					}
					
					if($networkError)
					{
						session()->flash("network-status-error","ok");
			            return redirect()->back()->withInput();
					}
					else
					{
						$req['status'] = "enabled";
					    $req['added_by'] = $user->id;
					   
			            $ret = $this->helpers->createBanner($req);
			            $ss = "add-banner-status";
					    if($ret == "error") $ss .= "-error";
					    session()->flash($ss,"ok");
			            return redirect()->intended("banners");
					}
					
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Handle update banner.
	 *
	 * @return Response
	 */
	public function getUpdateBanner(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_banners','edit_banners']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'xf' => 'required|numeric',
                             'type' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->updateBanner($req);
					$ss = "update-banner-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("banners");
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Handle remove banner.
	 *
	 * @return Response
	 */
	public function getRemoveBanner(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_banners','edit_banners']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required|numeric'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removeBanner($req['xf']);
					  $ss = "remove-banner-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("banners");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	
	/**
	 * Show list of FAQs.
	 *
	 * @return Response
	 */
	public function getFAQs(Request $request)
    {
		$user = null;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				 $v = "faqs";
				 $faqs = $this->helpers->getFAQs();
				 #dd($banners);
				 array_push($cpt,'faqs');
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Show the Add FAQ view.
	 *
	 * @return Response
	 */
	public function getAddFAQ(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-faq";
					$tags = $this->helpers->getFAQTags();
					array_push($cpt,'tags');
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add FAQ.
	 *
	 * @return Response
	 */
	public function postAddFAQ(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                     'tag' => 'required',
                             'question' => 'required',
							 'answer' => "required"
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$networkError = false;
				
					if($networkError)
					{
						session()->flash("network-status-error","ok");
			            return redirect()->back()->withInput();
					}
					else
					{
						$ret = $this->helpers->createFAQ($req);
			            $ss = "add-faq-status";
					    if($ret == "error") $ss .= "-error";
					    session()->flash($ss,"ok");
			            return redirect()->intended("faqs");
					}
					
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Handle update FAQ.
	 *
	 * @return Response
	 */
	public function getUpdateFAQ(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'xf' => 'required|numeric',
                             'tag' => 'required',
                             'question' => 'required',
							 'answer' => "required"
							 
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->updateFAQ($req);
					$ss = "update-faq-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("faqs");
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Handle remove FAQ.
	 *
	 * @return Response
	 */
	public function getRemoveFAQ(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required|numeric'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removeFAQ($req['xf']);
					  $ss = "remove-faq-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("faqs");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Show list of FAQ tags.
	 *
	 * @return Response
	 */
	public function getFAQTags(Request $request)
    {
		$user = null;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				 $v = "faq-tags";
				 $tags = $this->helpers->getFAQTags();
				 #dd($banners);
				 array_push($cpt,'tags');
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Show the Add FAQ view.
	 *
	 * @return Response
	 */
	public function getAddFAQTag(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-faq-tag";
					
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add FAQ.
	 *
	 * @return Response
	 */
	public function postAddFAQTag(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                     'tag' => 'required',
                             'name' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$networkError = false;
				
					if($networkError)
					{
						session()->flash("network-status-error","ok");
			            return redirect()->back()->withInput();
					}
					else
					{
						$ret = $this->helpers->createFAQTag($req);
			            $ss = "add-faq-tag-status";
					    if($ret == "error") $ss .= "-error";
					    session()->flash($ss,"ok");
			            return redirect()->intended("faq-tags");
					}
					
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Handle remove FAQ tag.
	 *
	 * @return Response
	 */
	public function getRemoveFAQTag(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required|numeric'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removeFAQTag($req['xf']);
					  $ss = "remove-faq-tag-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("faq-tags");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	
	
	
	
	
/**
	 * Switch user mode (host/guest).
	 *
	 * @return Response
	 */
	public function getTestBomb(Request $request)
    {
		$user = null;
		$messages = [];
		$ret = ['status' => "error", 'message' => "nothing happened"];
		
		if(Auth::check())
		{
			$user = Auth::user();
			$messages = $this->helpers->getMessages(['user_id' => $user->id]);
		}
		else
		{
			$ret['message'] = "auth";
		}
		
		$req = $request->all();
		
		$validator = Validator::make($req, [
                             'type' => 'required',
                             'method' => 'required',
                             'url' => 'required'
         ]);
         
         if($validator->fails())
         {
             $ret['message'] = "validation";
         }
		 else
		 {
       $rr = [
          'data' => [],
          'headers' => [],
          'url' => $req['url'],
          'method' => $req['method']
         ];
      
      $dt = [];
      
		   switch($req['type'])
		   {
		     case "bvn":
		       /**
			   $rr['data'] = [
		         'bvn' => $req['bvn'],
		         'account_number' => $req['account_number'],
		        'bank_code' => $req['bank_code'],
		         ];
		       **/  
			   //localhost:8000/tb?url=https://api.paystack.co/bank/resolve_bvn/:22181211888&method=get&type=bvn
		         $rr['headers'] = [
		           'Authorization' => "Bearer ".env("PAYSTACK_SECRET_KEY")
		           ];
		     break;
		   }
		   
			$ret = $this->helpers->bomb($rr);
			 
		 }
		 
		 dd($ret);
    }
	
	
	

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getZoho()
    {
        $ret = "97916613";
    	return $ret;
    }
	
	

	
}
