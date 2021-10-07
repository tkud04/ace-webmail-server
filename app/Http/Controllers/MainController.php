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

class MainController extends Controller {

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
				#$orders = $this->helpers->getAllOrders();
				#dd($stats);
				$req = $request->all();
                array_push($cpt,'orders');					
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
						$users = [];
						$apts = $this->helpers->getApartments($uu);
					    $reviews = $this->helpers->getReviews($uu->id,"user");
					    $permissions = $this->helpers->getPermissions($uu);
						#dd(count($reviews));
                        array_push($cpt,'u');
                        array_push($cpt,'apts');
                        array_push($cpt,'reviews');
                        array_push($cpt,'users');
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
		                    'phone' => 'required|numeric',
		                    'email' => 'required|email',
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
	 * Show list of reviews.
	 *
	 * @return Response
	 */
	public function getReviews(Request $request)
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
				$hasPermission = $this->helpers->hasPermission($user->id,['view_reviews']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "reviews";
				$req = $request->all();
                $reviews = $this->helpers->getAllReviews();
				#dd($reviews);
                array_push($cpt,'reviews');
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
	 * Handle approve/reject review.
	 *
	 * @return Response
	 */
	public function getApproveRejectReview(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_reviews','edit_reviews']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required',
		                    'type' => 'required',
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $dt = ['id' => $req['xf'],'status' => ""];
					  $dt['status'] = $req['type'] == "approve" ? "approved" : "rejected";
					  $ret = $this->helpers->updateReviewStatus($dt);
					  
					  $ss = "update-review-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("reviews");
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
	 * Handle remove review.
	 *
	 * @return Response
	 */
	public function getRemoveReview(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_reviews','edit_reviews']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removeReview($req);
					  $ss = "remove-review-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("reviews");
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
	 * Show list of transactions on the platform.
	 *
	 * @return Response
	 */
	public function getTransactions(Request $request)
    {
	    return redirect()->intended("finance");
    }
	
	/**
	 * Show list of transactions on the platform.
	 *
	 * @return Response
	 */
	public function getFinance(Request $request)
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
				$hasPermission = $this->helpers->hasPermission($user->id,['view_transactions']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "transactions";
				$req = $request->all();
                $transactions = $this->helpers->getAllTransactions();
				#dd($transactions);
                array_push($cpt,'transactions');
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
	 * Show the Communications view.
	 *
	 * @return Response
	 */
	public function getCommunication(Request $request)
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
				$v = "communication";
				$req = $request->all();
                $dt = $this->helpers->getCommunicationData();
				#dd($dt);
                array_push($cpt,'dt');
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
	 * Redirect
	 *
	 * @return Response
	 */
	public function getSendMessage(Request $request)
    {
		return redirect()->intended('communication');
    }
	
	/**
	 * Redirect
	 *
	 * @return Response
	 */
	public function postSendMessage(Request $request)
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
				    $req = $request->all();
						#dd($req);
				        $validator = Validator::make($req, [                          
				                             'xf' => 'required',
				                             'type' => 'required',
				                             'message' => 'required'
				         ]);
         
				         if($validator->fails())
				         {
							  session()->flash("validation-status-error","ok");
				         	return redirect()->intended('senders');
				         }
						else
						{
						    $r = $this->helpers->sendMessage($req);
			                $ret = "send-message-status";
			                if($r == "error") $ret .= "-error";
			                session()->flash($ret,"ok");
			                return redirect()->intended('communication');
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
	 * Show list of top performing hosts on the platform.
	 *
	 * @return Response
	 */
	public function getTopPerformingHosts(Request $request)
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
				$hasPermission = $this->helpers->hasPermission($user->id,['view_transactions']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "tph";
				$req = $request->all();
                $tph = $this->helpers->getTopPerformingHosts();
				$tph = $tph->all();
				#dd($hs);
                array_push($cpt,'tph');
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
	 * Show the View Transaction view.
	 *
	 * @return Response
	 */
	public function getTransaction(Request $request)
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
				$hasPermission = $this->helpers->hasPermission($user->id,['view_transactions','edit_transactions']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$v = "transaction";
					$t = $this->helpers->getTransaction($req['xf'],['guest' => true]);
					#dd($t);
					if(count($t) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('transactions');
					}
					else
					{
						array_push($cpt,'t');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('transactions');
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
	 * Show the Post Apartment view.
	 *
	 * @return Response
	 */
	public function getAddApartment(Request $request)
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
				$hasPermission = $this->helpers->hasPermission($user->id,['view_apartments','edit_apartments']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "add-apartment";
				$req = $request->all();
                $states = $this->helpers->states;
		        $countries = $this->helpers->countries;
		        $services = $this->helpers->getServices();
				#dd($apartments);
                array_push($cpt,'states');
                array_push($cpt,'countries');
                array_push($cpt,'services');
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
	 * Handle add ticket.
	 *
	 * @return Response
	 */
	public function postAddApartment(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_apartments','edit_apartments']);
				#dd($hasPermission);
				$req = $request->all();
				$ret = ['status' => "error",'message' => "nothing happened"];
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'name' => 'required',
		                    'url' => 'required|unique:apartments',
		                    'description' => 'required',
		                    'category' => 'required|not_in:none',
		                    'property_type' => 'required|not_in:none',
		                    'rooms' => 'required|numeric',
		                    'units' => 'required|numeric',
		                    'bathrooms' => 'required|numeric',
		                    'bedrooms' => 'required|numeric',
		                    'max_adults' => 'required|numeric',
		                    'amount' => 'required|numeric',
		                    'address' => 'required',
		                    'city' => 'required',
		                    'lga' => 'required',
		                    'state' => 'required',
							'country' => 'required',
		                    'facilities' => 'required',
		                    'img_count' => 'required|numeric',
		                    'cover' => 'required',
		                    'avb' => 'required|not_in:none',
		                    'status' => 'required|not_in:none',
		                   ]);
						
				if($validator->fails())
                {
                  $ret['message'] = "validation";
                }
				else
				{
					$ird = [];
                    $networkError = false;
				
                    for($i = 0; $i < $req['img_count']; $i++)
                    {
            		  $img = $request->file("pa-image-".$i);
					  $imgg = $this->helpers->uploadCloudImage($img->getRealPath());
						
					  if(isset($imgg['status']) && $imgg['status'] == "error")
					  {
						  $networkError = true;
						  break;
					  }
					  else
					  {
						$ci = ($req['cover'] != null && $req['cover'] == $i) ? "yes": "no";
					    $temp = [
					       'public_id' => $imgg['public_id'],
					       'delete_token' => $imgg['delete_token'],
					       'deleted' => "no",
					       'ci' => $ci,
						   'type' => "image"
						  ];
			             array_push($ird, $temp);  
					  }
             	        
                      										
					}
					
					if($networkError)
					{
						$ret['message'] = "network";
					}
					else
					{
						$req['payment_type'] = "card";
					    $req['user_id'] = "admin";
					    $req['ird'] = $ird;
					    $req['checkin'] = "12pm";
					    $req['checkout'] = "1pm";
					    $req['id_required'] = "yes";
					    $req['children'] = "none";
					    $req['pets'] = "no";
					    $req['bank_id'] = "admin";
				 
			            $this->helpers->createApartment($req);
			             $ret = ['status' => "ok"];
					}
				 }
				 return json_encode($ret);
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
	 * Show list of apartments on the platform.
	 *
	 * @return Response
	 */
	public function getApartments(Request $request)
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
				$hasPermission = $this->helpers->hasPermission($user->id,['view_apartments','edit_apartments']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "apartments";
				$req = $request->all();
                $apartments = $this->helpers->getAllApartments();
				#dd($apartments);
                array_push($cpt,'apartments');
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
	 * Show the View Apartment view.
	 *
	 * @return Response
	 */
	public function getApartment(Request $request)
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
				$hasPermission = $this->helpers->hasPermission($user->id,['view_apartments','edit_apartments']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$v = "apartment";
					$apartment = $this->helpers->getApartment($req['xf'],['host' => true,'imgId' => true]);
					$services = $this->helpers->getServices();
					$states = $this->helpers->states;
					$countries = $this->helpers->countries;
					#dd($apartment);
					if(count($apartment) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('apartment');
					}
					else
					{
						array_push($cpt,'apartment');                                 
						array_push($cpt,'services');                                 
						array_push($cpt,'states');                                 
						array_push($cpt,'countries');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('apartments');
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
	 * Handle Remove Apartment.
	 *
	 * @return Response
	 */
	 	public function getRemoveApartment(Request $request)
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
	 				$hasPermission = $this->helpers->hasPermission($user->id,['view_apartments','edit_apartments']);
	 				#dd($hasPermission);
	 				
	 				if($hasPermission)
	 				{
						$req = $request->all();
						#dd($req);
				        $validator = Validator::make($req, [                          
				                             'axf' => 'required'
				         ]);
         
				         if($validator->fails())
				         {
				         	return redirect()->intended('apartments');
				         }
						else
						{
						   $this->helpers->deleteApartment($req['axf']);
   	 					   $ss = "delete-apartment-status";
   	 					   session()->flash($ss,"ok");
   	 			           return redirect()->intended("apartments");
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
	 * Handle Update Apartment Status.
	 *
	 * @return Response
	 */
	 	public function getUpdateApartmentStatus(Request $request)
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
	 				$hasPermission = $this->helpers->hasPermission($user->id,['view_apartments','edit_apartments']);
	 				#dd($hasPermission);
	 				
	 				if($hasPermission)
	 				{
						$req = $request->all();
						#dd($req);
				        $validator = Validator::make($req, [                          
				                             'axf' => 'required'
				         ]);
         
				         if($validator->fails())
				         {
				         	return redirect()->intended('apartments');
				         }
						else
						{
							$ss = "pending";
							
							switch($req['type'])
							{
								case "approve":
								  $ss = "approved";
								break;
								
								case "reject":
								  $ss = "rejected";
								break;
							}
							
							$dd = [
							  'apartment_id' => $req['axf'],
							  'status' => $ss
							];
							
						   $this->helpers->updateApartmentStatus($dd);
   	 					   $ss = "update-apartment-status";
   	 					   session()->flash($ss,"ok");
   	 			           return redirect()->intended("apartments");
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
	 * Show list of transactions on the platform.
	 *
	 * @return Response
	 */
	public function getTickets(Request $request)
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
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "tickets";
				$req = $request->all();
                $tickets = $this->helpers->getAllTickets();
				#dd($tickets);
                array_push($cpt,'tickets');
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
	 * Show the Add Ticket view.
	 *
	 * @return Response
	 */
	public function getAddTicket(Request $request)
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
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-ticket";
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
	 * Handle add ticket.
	 *
	 * @return Response
	 */
	public function postAddTicket(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'type' => 'required|not_in:none',
                             'email' => 'required|email',
                             'subject' => 'required',
                             'msg' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$req['added_by'] = $user->id;
					$ret = $this->helpers->addTicket($req);
					$ss = "add-ticket-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("tickets");
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
	 * Show the View Ticket view.
	 *
	 * @return Response
	 */
	public function getTicket(Request $request)
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
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$v = "ticket";
					$t = $this->helpers->getTicket($req['xf']);
					#dd($t);
					if(count($t) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('tickets');
					}
					else
					{
						array_push($cpt,'t');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('tickets');
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
	 * Show the Update Ticket view.
	 *
	 * @return Response
	 */
	public function getUpdateTicket(Request $request)
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
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$v = "update-ticket";
					$t = $this->helpers->getTicket($req['xf']);
					#dd($t);
					if(count($t) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('tickets');
					}
					else
					{
						array_push($cpt,'t');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('tickets');
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
	 * Handle update ticket.
	 *
	 * @return Response
	 */
	public function postUpdateTicket(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'xf' => 'required',
                             'msg' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$req['added_by'] = $user->id;
					$ret = $this->helpers->updateTicket($req);
					$ss = "update-ticket-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
					$uu = "ticket?xf=".$req['xf'];
			        return redirect()->intended($uu);
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
	 * Handle remove ticket.
	 *
	 * @return Response
	 */
	public function getRemoveTicket(Request $request)
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
		                    'xf' => 'required'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removeTicket($req['xf']);
					  $ss = "remove-ticket-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("tickets");
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
	public function getApartmentTips(Request $request)
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
				$hasPermission = $this->helpers->hasPermission($user->id,['view_apartments','edit_apartments']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				 $v = "apartment-tips";
				 $tips = $this->helpers->getApartmentTips();
				 #dd($tips);
				 array_push($cpt,'tips');
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
	public function getAddApartmentTip(Request $request)
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
					$v = "add-apartment-tip";
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
	public function postAddApartmentTip(Request $request)
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
		                     'message' => 'required'
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
						$ret = $this->helpers->createApartmentTip($req);
			            $ss = "add-apartment-tip-status";
					    if($ret == "error") $ss .= "-error";
					    session()->flash($ss,"ok");
			            return redirect()->intended("apartment-tips");
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
	 * Handle remove banner.
	 *
	 * @return Response
	 */
	public function getRemoveApartmentTip(Request $request)
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
					  $ret = $this->helpers->removeApartmentTip($req['xf']);
					  $ss = "remove-apartment-tip-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("apartment-tips");
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
	 * Show list of blog posts.
	 *
	 * @return Response
	 */
	public function getPosts(Request $request)
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
				$hasPermission = $this->helpers->hasPermission($user->id,['view_posts','edit_posts']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				 $v = "posts";
				 $posts = $this->helpers->getPosts();
				 #dd($posts);
				 array_push($cpt,'posts');
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
	 * Show the Add Post view.
	 *
	 * @return Response
	 */
	public function getAddPost(Request $request)
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
				$hasPermission = $this->helpers->hasPermission($user->id,['view_posts','edit_posts']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-post";
					
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
	 * Handle add post.
	 *
	 * @return Response
	 */
	public function postAddPost(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_posts','edit_posts']);
				#dd($hasPermission);
				$req = $request->all();

				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                     'title' => 'required',
                             'url' => 'required|unique:posts',
							 'ap-images' => 'required',
                             'content' => 'required'
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
				
                    for($i = 0; $i < count($req['ap-images']); $i++)
                    {
            		  $img = $req['ap-images'][$i];
					  $imgg = $this->helpers->uploadCloudImage($img->getRealPath());
						
					  if(isset($imgg['status']) && $imgg['status'] == "error")
					  {
						  $networkError = true;
						  break;
					  }
					  else
					  {
						 $req['ird'] = $imgg['public_id'];
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
					    $req['author'] = $user->id;
					   
			            $ret = $this->helpers->createPost($req);
			            $ss = "add-post-status";
					    if($ret == "error") $ss .= "-error";
					    session()->flash($ss,"ok");
			            return redirect()->intended("posts");
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
	 * Show the Update Post view.
	 *
	 * @return Response
	 */
	public function getUpdatePost(Request $request)
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
				$hasPermission = $this->helpers->hasPermission($user->id,['view_posts','edit_posts']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$v = "post";
					$p = $this->helpers->getPost($req['xf']);
				    #dd($p);
					if(count($p) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('posts');
					}
					else
					{
						array_push($cpt,'p');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('posts');
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
	 * Handle update post.
	 *
	 * @return Response
	 */
	public function postUpdatePost(Request $request)
    {
		$user = null;
		
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_posts','edit_posts']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				$req = $request->all();
				#dd($req);
				
				$validator = Validator::make($req,[
		                     'xf' => 'required',
		                     'title' => 'required',
                             'url' => 'required',
							 'ap-images' => 'required',
                             'content' => 'required',
                             'status' => 'required'
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
				    
					
                      for($i = 0; $i < count($req['ap-images']); $i++)
                      {
						  $img = $req['ap-images'][$i];
						  if($img != null)
					      {
            		        
					        $imgg = $this->helpers->uploadCloudImage($img->getRealPath());
						
					        if(isset($imgg['status']) && $imgg['status'] == "error")
					        {
						      $networkError = true;
						      break;
					        }
					        else
					        {
						      $req['ird'] = $imgg['public_id'];
					        }    								
					     }
					  }
					  if($networkError)
					  {
					    session()->flash("network-status-error","ok");
			            return redirect()->back()->withInput();
					  }
					  else
					  {
					    $req['author'] = $user->id;
					   
			            $ret = $this->helpers->updatePost($req);
			            $ss = "update-post-status";
					    if($ret == "error") $ss .= "-error";
					    session()->flash($ss,"ok");
			            return redirect()->back();
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
	 * Handle remove post.
	 *
	 * @return Response
	 */
	public function getRemovePost(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_posts','edit_posts']);
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
	 * Handle Respond to reservation request.
	 *
	 * @return Response
	 */
	public function getRespondToReservation(Request $request)
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
							'axf' => 'required',
							'gxf' => 'required|numeric'
		        ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->intended('/');
                }
				else
				{
					$dt = [
			         'id' => $req['xf'],
			         'apartment_id' => $req['axf'],
			         'user_id' => $req['gxf']
			        ];
			 
			       if($this->helpers->hasReservation($dt))
			       {
				     $dt['type'] = $req['type'];
				     $dt['auth'] = $user->id;
				
			         $this->helpers->respondToReservation($dt);
			         session()->flash("respond-to-reservation-status","ok");
                     return redirect()->intended('/');
			       }
			       else
			       {
			   	     session()->flash("duplicate-reservation-status-error","ok");
			         return redirect()->intended('/');
			       }
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
	 * Show list of subscription plans.
	 *
	 * @return Response
	 */
	public function getPlans(Request $request)
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
				 $v = "plans";
				 $plans = $this->helpers->getPlans();
				 #dd($posts);
				 array_push($cpt,'plans');
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
	 * Show the Add Plan view.
	 *
	 * @return Response
	 */
	public function getAddPlan(Request $request)
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
					$v = "add-plan";
					
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
	 * Handle add plan.
	 *
	 * @return Response
	 */
	public function postAddPlan(Request $request)
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
		                     'name' => 'required',
                             'amount' => 'required|numeric',
                             'pc' => 'required|numeric',
							 'frequency' => 'required',
                             'ps_id' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$req['status'] = "enabled";
					$req['added_by'] = $user->id;
					   
			        $ret = $this->helpers->createPlan($req);
			            $ss = "add-plan-status";
					    if($ret == "error") $ss .= "-error";
					    session()->flash($ss,"ok");
			            return redirect()->intended("plans");
					
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
	 * Show the Update Plan view.
	 *
	 * @return Response
	 */
	public function getUpdatePlan(Request $request)
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
					$v = "plan";
					$p = $this->helpers->getPlan($req['xf']);
				    #dd($p);
					if(count($p) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('plans');
					}
					else
					{
						array_push($cpt,'p');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('plans');
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
	 * Handle update plan.
	 *
	 * @return Response
	 */
	public function postUpdatePlan(Request $request)
    {
		$user = null;
		
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				$req = $request->all();
				#dd($req);
				
				$validator = Validator::make($req,[
		                     'xf' => 'required',
		                     'name' => 'required',
                             'amount' => 'required|numeric',
							 'pc' => 'required|numeric',
							 'frequency' => 'required',
                             'ps_id' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					
					    $req['added_by'] = $user->id;
					   
			            $ret = $this->helpers->updatePlan($req);
			            $ss = "update-plan-status";
					    if($ret == "error") $ss .= "-error";
					    session()->flash($ss,"ok");
			            return redirect()->back();
					
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
	 * Handle remove plan.
	 *
	 * @return Response
	 */
	public function getRemovePlan(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    dd($req);
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
	 * Handle Enable/Disable plan.
	 *
	 * @return Response
	 */
	public function getEnableDisablePlan(Request $request)
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
					$ret = $this->helpers->updateEDP($req);
					$ss = "update-plan-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended('plans');
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
