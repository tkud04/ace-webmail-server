<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\Contracts\HelperContract; 
use Auth;
use Session; 
use Validator; 
use Carbon\Carbon; 
use App\User;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller {

	protected $helpers; //Helpers implementation
    
    public function __construct(HelperContract $h)
    {
    	$this->helpers = $h;            
    }
	
		/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getSignup(Request $request)
    {
		 $user = null;
		$cart = [];
		if(Auth::check())
		{
			return redirect()->intended('dashboard');
		}
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cart = [];
         return view('signup', compact(['cart','user','signals','plugins']));
    }
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	 
    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getHello(Request $request)
    {
        $user = null;
		$cart = [];
		if(Auth::check())
		{
			return redirect()->intended('dashboard');
		}
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cart = [];
         return view('login', compact(['cart','user','signals','plugins']));
    }

  
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postHello(Request $request)
    {
		$req = $request->all();
       #dd($req);
	  
			 $validator = Validator::make($req, [
                             'password' => 'required|min:6',
                             'id' => 'required'                  
         ]);
         
         if($validator->fails())
         {
             session()->flash("validation-status-error","ok");
			 return redirect()->back()->withInput();
         }
         
         else
         {
			$remember = true; 
             
         	//authenticate this login
            if(Auth::attempt(['username' => $req['id'],'password' => $req['password'],'status'=> "enabled"],$remember))
            {
            	//Login successful               
               $user = Auth::user();   
               return redirect()->intended('/');		   
            }
			
			else
			{
				 session()->flash("login-auth-status-error","ok");
			     return redirect()->back()->withInput();
			}			
          }	 
		 
		
    }


    
    
	
    public function postSignup(Request $request)
    {
        $req = $request->all();
       #dd($req);
	   
		    $validator = Validator::make($req, [
                             'pass' => 'required|min:7|confirmed',
                             'username' => 'required',
                            // 'role' => 'required',
                             'fname' => 'required',
                             'lname' => 'required'                  
         ]);
         
         if($validator->fails())
         {
             session()->flash("validation-status-error","ok");
			     return redirect()->back()->withInput();
         }
         
         else
         {
			 $isNew = !$this->helpers->isDuplicateUser(['username' => $req['username']]);
			 
            $req['status'] = "enabled";     
            $req['role'] = "user";     
            
            # dd($isNew);            
            
			if($isNew)
			{
				$user =  $this->helpers->createUser($req);
				Auth::login($user);
				 return redirect()->intended('/');		
			}
			else
			{
				session()->flash("signup-auth-status-error","ok");
			     return redirect()->back()->withInput();	
			}
            
            
          }	
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	 
    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getOauth(Request $request)
    {
        $user = null;
		$cart = [];
		if(Auth::check())
		{
			return redirect()->intended('dashboard');
		}
		
		 $req = $request->all();
		 #dd($req);
		 if(isset($req['type']))
		 {
			 $type = $req['type'];
			 
			 return Socialite::driver($type)->redirect();
		 }
		 else
		 {
			return redirect()->intended("/"); 
		 }
		
    }
	
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getOAuthRedirect(Request $request,$type)
    {
        $user = null;
		$cart = [];
		if(Auth::check())
		{
			return redirect()->intended('dashboard');
		}
		
		 $req = $request->all();
		  $socialUser = Socialite::driver($type)->user();
		 
		 if($socialUser != null)
		 {
			 $dt = [
			   'name' => $socialUser->name,
			   'type' => $type,
			   'email' => $socialUser->email,
			   'img' => $socialUser->avatar,
			   'token' => $socialUser->token,
			 ];
			$auth = $this->helpers->oauth($dt);
			
			if($auth['status'] == "ok")
			{
				if(($auth['message'] == "new-user") || ($auth['message'] == "existing-user-no-pass"))
				{
					//set password for new user
					$uu = $auth['user'];
					//set user role to admin
					$uu->update(['role' => "admin"]);
					return redirect()->intended("oauth-sp?xf=".$uu->email);
				}
			}
			else
			{
				session()->flash("oauth-status-error","ok");
			}
		 }
		 else
		 {
			session()->flash("oauth-status-error","ok");
		 }
		 
		 return redirect()->intended("/"); 
		
    }
	
	 /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getOAuthSP(Request $request)
    {
       $user = null;
		
		if(Auth::check())
		{
			$user = Auth::user();
		}
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cart = [];
            $req = $request->all();
			#dd($req);
			if(isset($req['xf']) && $this->helpers->isOAuthSP($req['xf']))
            {
				$xf = $req['xf'];
				return view("oauth-sp",compact(['cart','user','xf','plugins']));
            }
            
            else
            {
            	return redirect()->intended('/');
            }
    }
    
    
    /**
     * Send username to the given user.
     * @param  \Illuminate\Http\Request  $request
     */
    public function postOAuthSP(Request $request)
    {
    	$req = $request->all(); 
        $validator = Validator::make($req, [
                             'pass' => 'required|min:6|confirmed',
                             'acsrf' => 'required'
                  ]);
                  
        if($validator->fails())
         {
             $messages = $validator->messages();
             //dd($messages);
             
             return redirect()->back()->withInput()->with('errors',$messages);
         }
         
         else
		 {
         	$id = $req['acsrf'];
             $ret = $req['pass'];

            $user = User::where('email',$id)->first();
			if($user != null)
			{
				$user->update(['password' => bcrypt($ret)]);
                Auth::login($user);
                session()->flash("oauth-sp-status","ok");                  
			}
            
            return redirect()->intended('/');

         }
                  
    }    

    
    public function getForgotPassword()
    {
    	$user = null;
		
		if(Auth::check())
		{
			$user = Auth::user();
			return redirect()->intended('/');
		}
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cart = [];
         return view('forgot-password', compact(['cart','user','signals','plugins']));
    }
    
    /**
     * Send username to the given user.
     * @param  \Illuminate\Http\Request  $request
     */
    public function postForgotPassword(Request $request)
    {
    	 $req = $request->all();
       #dd($req);
	   $ret = ['status' => "error",'message' => "Nothing happened"];
        
		$reqValidator = Validator::make($req,[
		                    'dt' => 'required'
		]);
		
		if($reqValidator->fails())
         {
             $ret['message'] = "dt-validation";
         }
		 else
		 {
			 $dt = json_decode($req['dt'],true);
			 $validator = Validator::make($dt, [
                             'email' => 'required|email'          
             ]);
         
            if($validator->fails())
            {
              $ret['message'] = "validation";
            }
         
            else
           {
         	  $id = $dt['email'];

                $user = User::where('email',$id)
                                  ->orWhere('phone',$id)->first();

                if(is_null($user))
                {
                         $ret['message'] = "auth";
                }
				else
				{
					//get the reset code 
                    $code = $this->helpers->getPasswordResetCode($user);
                    $user->update(['reset_code' => $code]);
                    $ret = $this->helpers->getCurrentSender();
				    $ret['code'] = $code;
				    $ret['name'] = $user->fname;
				    $ret['subject'] = "Reset your password";
		            $ret['em'] = $id;
		            $this->helpers->sendEmailSMTP($ret,"emails.forgot-password");
                    $ret = ['status' => "ok",'message' => "Link sent"];
				}
            }
	     }
	  
	  return json_encode($ret);               
    }    
    
  
    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getPasswordReset(Request $request)
    {
       $user = null;
		
		if(Auth::check())
		{
			$user = Auth::user();
			return redirect()->intended('/');
		}
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cart = [];
            $req = $request->all();
			#dd($req);
			if(isset($req['code']))
            {
				$uu = $this->helpers->verifyPasswordResetCode($req['code']);
				#dd($uu);
                if($uu == null)   
                { 
                	session()->flash("rp-invalid-token-status-error","ok");
                    return redirect()->intended('/');					
                }
                $v =  'reset';
				return view($v,compact(['cart','user','uu','plugins']));
            }
            
            else
            {
            	return redirect()->intended('/');
            }
    }
    
    
    /**
     * Send username to the given user.
     * @param  \Illuminate\Http\Request  $request
     */
    public function postPasswordReset(Request $request)
    {
    	$req = $request->all(); 
        $ret = ['status' => "error",'message' => "Nothing happened"];
        
		$reqValidator = Validator::make($req,[
		                    'dt' => 'required'
		]);
		
		if($reqValidator->fails())
         {
             $ret['message'] = "dt-validation";
         }
		 else
		 {
			 $dt = json_decode($req['dt'],true);
			 $validator = Validator::make($dt, [
                             'id' => 'required',
                             'pass' => 'required|min:6'							 
             ]);
         
            if($validator->fails())
            {
              $ret['message'] = "validation";
            }
			else
			{
				$id = $dt['id'];
               $ret = $dt['pass'];

               $user = User::where('id',$id)->first();
               $user->update(['password' => bcrypt($ret)]);
                
               $ret = ['status' => "ok",'message' => "Password reset"];
			}
        }
         
         return json_encode($ret);         
    }    

   
    
    public function getBye()
    {
        if(Auth::check())
        {  
           Auth::logout();       	
        }
        
        return redirect()->intended('/');
    }

}