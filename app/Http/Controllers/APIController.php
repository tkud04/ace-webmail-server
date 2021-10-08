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
			  $msgs = $this->helpers->getMessages($req['u']);
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

