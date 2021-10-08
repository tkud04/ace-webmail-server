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
		$req = $request->all();
		$ret = ['status' => "ok"];
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
		$ret = ['status' => "ok"];
		#dd($req);
		$this->helpers->createFmail($req);
		return json_encode($ret);
		
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
