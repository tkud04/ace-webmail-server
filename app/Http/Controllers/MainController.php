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
        $cpt = ['user','signals','plugins'];
		$req = $request->all();
		
		if(Auth::check())
		{
			$user = Auth::user();
			
			   if($user->role == "admin")
			   {
				$v = "index";
				$stats = $this->helpers->getSiteStats();
				$accts = $this->helpers->getUsers();
				#dd($stats);
				
                array_push($cpt,'stats');					
                array_push($cpt,'accts');
               }
               else
			   {
				  $v = "messages"; 
				  $msgs = $this->helpers->getMessages(['u' => $user->username,'l' => "inbox"]);
				  $title = "Inbox";
				  $subtitle = "View messages in your inbox";
				  #dd($msgs);
				  array_push($cpt,'msgs');		
				  array_push($cpt,'title');		
				  array_push($cpt,'subtitle');		
			   }			   
			
		}
		else
		{
			$v = "login";
		}
		
		return view($v,compact($cpt));
		
    }
    
    /**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getInbox(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
        $cpt = ['user','signals','plugins'];
		$req = $request->all();
		
		if(Auth::check())
		{
			$user = Auth::user();
				  $v = "messages"; 
				  $msgs = $this->helpers->getMessages(['u' => $user->username,'l' => "inbox"]);
				  $title = "Inbox";
				  $subtitle = "View messages in your inbox";
				  #dd($msgs);
				  array_push($cpt,'msgs');		
				  array_push($cpt,'title');		
				  array_push($cpt,'subtitle');		
			  		   
			
		}
		else
		{
			return redirect()->intended('/');
		}
		
		return view($v,compact($cpt));
		
    } 
    
    /**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getDrafts(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
        $cpt = ['user','signals','plugins'];
		$req = $request->all();
		
		if(Auth::check())
		{
			$user = Auth::user();
				  $v = "messages"; 
				  $msgs = $this->helpers->getMessages(['u' => $user->username,'l' => "drafts"]);
				  $title = "Drafts";
				  $subtitle = "View messages you're still editing";
				  #dd($msgs);
				  array_push($cpt,'msgs');		
				  array_push($cpt,'title');		
				  array_push($cpt,'subtitle');		
			  		   
			
		}
		else
		{
			return redirect()->intended('/');
		}
		
		return view($v,compact($cpt));
		
    } 
    
    /**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getSent(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
        $cpt = ['user','signals','plugins'];
		$req = $request->all();
		
		if(Auth::check())
		{
			$user = Auth::user();
				  $v = "messages"; 
				  $msgs = $this->helpers->getMessages(['u' => $user->username,'l' => "sent"]);
				  $title = "Sent";
				  $subtitle = "View messages you have sent";
				  #dd($msgs);
				  array_push($cpt,'msgs');		
				  array_push($cpt,'title');		
				  array_push($cpt,'subtitle');		
			  		   
			
		}
		else
		{
			return redirect()->intended('/');
		}
		
		return view($v,compact($cpt));
		
    } 

	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getUsername(Request $request)
    {
		$user = null; $u = "nothing";
		$req = $request->all();
		
		if(Auth::check())
		{
			$user = Auth::user();
				  
				  $u =$user->username;
			
		}
		
		return $u;
		
    } 
	
	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getNewMessage(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
        $cpt = ['user','signals','plugins'];
		$req = $request->all();
		
		if(Auth::check())
		{
			$user = Auth::user();
			$v = "new-message"; 
		}
		else
		{
			return redirect()->intended('/');
		}
		
		return view($v,compact($cpt));
		
    }
	
	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getMessage(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
        $cpt = ['user','signals','plugins'];
		$req = $request->all();
		
		if(Auth::check())
		{
			$user = Auth::user();
			
			  if(isset($req['xf']))
			  {
				  $v = "message"; 
				  $m = $this->helpers->getMessage($req['xf']);
				  #dd($m);
				  if(count($m) > 0)
				  {
					  $req['op'] = "read";
					  $this->helpers->updateMessage($req);
					   $title = $m['subject'];
					   $contacts = $this->helpers->getContacts($user->username);
				  $subtitle = "";
				  #dd($msgs);
				  array_push($cpt,'m');		
				  array_push($cpt,'title');		
				  array_push($cpt,'subtitle');		
				  array_push($cpt,'contacts');		
				  }
				  else
				  {
					  return redirect()->intended('/');
				  }
				 
			  }
			  else
			  {
				  return redirect()->intended('/');
			  }
		}
		else
		{
			$v = "login";
		}
		
		return view($v,compact($cpt));
		
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
			$v = "login";
		}
		return view($v,compact($cpt));
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
			$v = "login";
		}
		return view($v,compact($cpt));
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
