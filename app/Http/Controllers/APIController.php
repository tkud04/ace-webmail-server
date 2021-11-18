<?php 
namespace App\Http\Controllers;

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

class APIController extends Controller {

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
    	/**
    	$this->helpers->createSender([
             'ss' => "smtp-pulse.com",
             'sp' => "587",
             'sa' => "yes",
             'sec' => "tls",
             'su' => "aceluxurystoree@gmail.com",
             'spp' => "jGeskg5KoD2",
             'current' => "yes",
             'type' => "other",
             'sn' => "Ace Luxury Store",
             'se' => "admin@aceluxurystore.com",
             'status' => "enabled",
 ]);
 **/
		$req = $request->all();
		$ret = ['status' => "ok"];
		return json_encode($ret);
		
    }
	
	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getHello(Request $request)
    {
		$ret = ['status' => "error",'msg' => "unsupported"];
		return json_encode($ret);
    }
	
	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function postHello(Request $request)
    {
		$req = $request->all();
		$ret = $this->helpers->apiLogin($req);
		
		return json_encode($ret);
		
    }	
	
	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getBye(Request $request)
    {
		$req = $request->all();
		$ret = $this->helpers->apiLogout($req);
		
		return json_encode($ret);
		
    }
	
	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getPostman(Request $request)
    {
		$req = $request->all();
		$ret = $this->helpers->getFmails();
		$r2 = [];
		
		foreach($ret as $r)
		{
			$m = json_decode($r['message'],true);
			array_push($r2,$m);		
		}
		dd($r2);
		return json_encode($ret);
		
    }
	
	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function postPostman(Request $request)
    {
		$req = $request->all();
		#dd($req);
		$ret = $this->helpers->createFmail($req);
		return json_encode($ret);
		
    }

	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getMessages(Request $request)
    {
		$req = $request->all();
		
		$ret = ['status' => "error",'msg' => "forbidden"];
		
		if(isset($req['tk']) && isset($req['u']))
		{
		  if($this->helpers->apiAuth($req))
		  {
			 $l = "all";
		     if(!isset($req['l'])) $req['l'] = $l;
			  $msgs = $this->helpers->getMessages($req);
              $ret = ['status' => "ok",'data' => $msgs];		
		  }
		  else
          {
          	$ret['msg'] = "auth";
          }
        }
		
		return json_encode($ret);
		
    }
    
    /**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getNewMessage(Request $request)
    {
		$req = $request->all();
		
		$ret = ['status' => "error",'msg' => "forbidden"];
		
		return json_encode($ret);
		
    }
	
    /**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function postNewMessage(Request $request)
    {
		$req = $request->all();
		$user = null;
		
		$ret = ['status' => "error",'msg' => "forbidden"];
		
		  if($this->helpers->apiAuth($req))
		  {
			$v = Validator::make($req,[
		                    't' => 'required',
		                    's' => 'required',
                            'c' => 'required'                  
		                   ]);
						
				if($v->fails())
                {
                	$ret['msg'] = "validation";
                }
				else
                {
					$to = json_decode($req['t']);
					$u = $req['u'];
					
					$rr = [
					  'c' => $req['c'],
					  's' => $req['s'],
					  'u' => $u,
					];
					
					//attachments
		              $atts = $request->file('atts');
                 $ird = [];
				 $rr['atts'] = [];
				 
			if(is_array($atts))
			{
             for($i = 0; $i < count($atts); $i++)
             {  
			     #dd($ret);
			    array_push($rr['atts'],['name' => $atts[$i]->getClientOriginalName(), 'content' => $atts[$i]->getRealPath()]);
             }
			} 
					foreach($to as $i)
					{
						$rr['t'] = $i->em;
						$this->helpers->sendMessage($rr);
					}
                	
                    $ret = ['status' => "ok"];
                }		
		  }
		  else
          {
          	$ret['msg'] = "auth";
          }
        
		
		return json_encode($ret);
		
    } 
	
	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getSaveDraft(Request $request)
    {
		$req = $request->all();
		
		$ret = ['status' => "error",'msg' => "forbidden"];
		
		return json_encode($ret);
		
    }
	
    /**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function postSaveDraft(Request $request)
    {
		$req = $request->all();
		$user = null;
		
		$ret = ['status' => "error",'msg' => "forbidden"];
		
		  if($this->helpers->apiAuth($req))
		  {
			$v = Validator::make($req,[
		                    't' => 'required',
		                    's' => 'required',
                            'c' => 'required'                  
		                   ]);
						
				if($v->fails())
                {
                	$ret['msg'] = "validation";
                }
				else
                {
					$to = json_decode($req['t']);
					$u = $req['u'];
					
					$rr = [
					  'c' => $req['c'],
					  's' => $req['s'],
					  't' => $req['t'],
					  'u' => $u,
					];
					
					 $this->helpers->saveDraft($rr);
					 
                    $ret = ['status' => "ok"];
                }		
		  }
		  else
          {
          	$ret['msg'] = "auth";
          }
        
		
		return json_encode($ret);
		
    }

	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getMessage(Request $request)
    {
		$req = $request->all();
		
		$ret = ['status' => "error",'msg' => "forbidden"];
		
		if(isset($req['tk']) && isset($req['u']) && isset($req['m']))
		{
		  if($this->helpers->apiAuth($req))
		  {
			  $msg = $this->helpers->getMessage($req['m']);
              $ret = ['status' => "ok",'data' => $msg];		
		  }
		  else
          {
          	$ret['msg'] = "auth";
          }
        }
		
		return json_encode($ret);
		
    }
	
    /**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function postMessage(Request $request)
    {
		$req = $request->all();
		
		$ret = ['status' => "error",'msg' => "forbidden"];
		
		  if($this->helpers->apiAuth($req))
		  {
			$v = Validator::make($req,[
		                    'm' => 'required',
                            'xf' => 'required'                  
		                   ]);
						
				if($v->fails())
                {
                	$ret['msg'] = "validation";
                }
				else
                {
                	switch($req['xf'])
                    {
                    	case 'reply':
                          $this->helpers->replyMessage($req);
                        break;
                        
                        case 'forward':
                          $this->helpers->forwardMessage($req);
                        break;
                    }
 
                    $ret = ['status' => "ok"];
                }		
		  }
		  else
          {
          	$ret['msg'] = "auth";
          }
        
		
		return json_encode($ret);
		
    }
	
	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getUpdateSession(Request $request)
    {
		$ret = ['status' => "error",'msg' => "unsupported"];
		return json_encode($ret);
    }

	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function postUpdateSession(Request $request)
    {
		$req = $request->all();
		
		$ret = ['status' => "error",'msg' => "forbidden"];
		
		  if($this->helpers->apiAuth($req))
		  {
			$v = Validator::make($req,[
		                    'etk' => 'required'                
		                   ]);
						
				if($v->fails())
                {
                	$ret['msg'] = "validation";
                }
				else
                {
                	$this->helpers->updateSession($req);
                    $ret = ['status' => "ok"];
                }		
		  }
		  else
          {
          	$ret['msg'] = "auth";
          }
        
		
		return json_encode($ret);
		
    }
	
	
	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getRemoveSignature(Request $request)
    {
		$req = $request->all();
		
		$ret = ['status' => "error",'msg' => "forbidden"];
		
		  if($this->helpers->apiAuth($req))
		  {
			$v = Validator::make($req,[
		                    'xf' => 'required'                
		                   ]);
						
				if($v->fails())
                {
                	$ret['msg'] = "validation";
                }
				else
                {
                	$this->helpers->removeUSignature($req['xf']);
					if($req['tk'] == "kt") return redirect()->intended('settings');
                    $ret = ['status' => "ok"];
                }		
		  }
		  else
          {
          	$ret['msg'] = "auth";
          }
        
		
		return json_encode($ret);
		
    }
	
	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getSettings(Request $request)
    {
		$ret = ['status' => "error",'msg' => "unsupported"];
		return json_encode($ret);
    }

	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function postSettings(Request $request)
    {
		$req = $request->all();
		
		$ret = ['status' => "error",'msg' => "forbidden"];
		
		  if($this->helpers->apiAuth($req))
		  {
			$v = Validator::make($req,[
		                    'sig' => 'required',
		                    'u' => 'required',
                            'new-sigs' => 'required'            
		                   ]);
						
				if($v->fails())
                {
                	$ret['msg'] = "validation";
                }
				else
                {
                	$newsigs = json_decode($req['new-sigs']);
                    $u = $req['u'];
                    
                	if($req['sig'] == "none" && count($newsigs) > 0)
                    {
                    	foreach($newsigs as $ns)
                        {
                        	$this->helpers->createUSignature([
                                                   'username' => $u,
                                                   'value' => $ns,
                                                   'current' => "no"
                                                 ]);
                        }
                    }
                    else
                    {
                    	$v2 = ['current' => "yes"];
                    	$this->helpers->updateUSignature($req['sig'],$v2);
                    }
                    if($req['tk'] == "kt") return redirect()->intended('settings');
                    $ret = ['status' => "ok"];
                }		
		  }
		  else
          {
          	$ret['msg'] = "auth";
          }
        
		
		return json_encode($ret);
		
    }

	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getDeleteMessage(Request $request)
    {
		$req = $request->all();
		#dd($req);
		$ret = ['status' => "error",'msg' => "forbidden"];
		
		  if($this->helpers->apiAuth($req))
		  {
			$v = Validator::make($req,[
		                    'dt' => 'required',
		                    'u' => 'required',
		                   ]);
						
				if($v->fails())
                {
                	$ret['msg'] = "validation";
                }
				else
                {
                   $this->helpers->deleteMessage($req);
                }
                    if($req['tk'] == "kt") return redirect()->intended('inbox');
                    $ret = ['status' => "ok"];
		  }
		  else
          {
          	$ret['msg'] = "auth";
          }
        
		
		return json_encode($ret);
		
    }
	
	public function getMoveMessage(Request $request)
    {
		$req = $request->all();
		
		$ret = ['status' => "error",'msg' => "forbidden"];
		
		  if($this->helpers->apiAuth($req))
		  {
			$v = Validator::make($req,[
		                    'dt' => 'required',
		                    'l' => 'required',
		                   ]);
						
				if($v->fails())
                {
                	$ret['msg'] = "validation";
                }
				else
                {
                   $this->helpers->moveMessage($req);
                }
                    if($req['tk'] == "kt") return redirect()->intended($req['l']);
                    $ret = ['status' => "ok"];
		  }
		  else
          {
          	$ret['msg'] = "auth";
          }
        
		
		return json_encode($ret);
		
    }
	
	public function getMarkUnread(Request $request)
    {
		$req = $request->all();
		
		$ret = ['status' => "error",'msg' => "forbidden"];
		
		  if($this->helpers->apiAuth($req))
		  {
			$v = Validator::make($req,[
		                    'dt' => 'required',
		                   ]);
						
				if($v->fails())
                {
                	$ret['msg'] = "validation";
                }
				else
                {
                   $this->helpers->markUnread($req);
                }
                    if($req['tk'] == "kt") return redirect()->intended('inbox');
                    $ret = ['status' => "ok"];
		  }
		  else
          {
          	$ret['msg'] = "auth";
          }
        
		
		return json_encode($ret);
		
    }
    
    
    /**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function postSendNotification(Request $request)
    {
		$req = $request->all();
		$ret = ['status' => "error", 'message' => "forbidden"];
		#dd($req);
		
	   $v = Validator::make($req,[
		                    'u' => 'required',
		                    'title' => 'required',
		                    'body' => 'required'
		                   ]);
						
				if($v->fails())
                {
                	$ret['message'] = "validation";
                }
				else
                {
                   $rr = $this->helpers->sendNotification($req);
                   $ret = ['status' => "ok", 'data' => $rr];
                }
                
		 return json_encode($ret);
    }
	
	
	
	
	
	
/**
	 * Switch user mode (host/guest).
	 *
	 * @return Response
	 */
	public function getTest(Request $request)
    {
		$ret = ['status' => "error",'msg' => "forbidden"];
		$req = $request->all();
		
       $rr = [
          'content' => "<p>testing with small file</p>",
          'subject' => "small att",
          'fmail_id' => "275",
          'username' => "tkudayisi",
          'sn' => "Ace Luxury Store",
          'sa' => "aceluxurystoree@gmail.com",
          'label' => "inbox",
          'status' => "enabled",
         ];
      
       $ret = $this->helpers->createMessage($rr);
		 
		 dd($ret);
    }
	
	/**
	 * Switch user mode (host/guest).
	 *
	 * @return Response
	 */
	public function getTestBomb(Request $request)
    {
		$ret = ['status' => "error",'msg' => "forbidden"];
		$req = $request->all();
		
		
       $rr = [
          'data' => [
            'u' => $req['u'],
            'p' => $req['p'],
          ],
          'headers' => [],
          'url' => $req['url'],
          'method' => $req['method']
         ];
      
       $ret = $this->helpers->bomb($rr);
		 
		 dd($ret);
    }
	
	/**
	 * Switch user mode (host/guest).
	 *
	 * @return Response
	 */
	public function getF(Request $request)
    {
		return view('f');
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

