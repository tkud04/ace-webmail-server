<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\Contracts\HelperContract; 
use Auth;
use Session; 
use Validator; 
use Carbon\Carbon; 
use Paystack; 
use App\Orders;

class PaymentController extends Controller {

	protected $helpers; //Helpers implementation
    
    public function __construct(HelperContract $h)
    {
    	$this->helpers = $h;                     
    }
    
	
	 /**
	 * Redirect GET requests to /pay.
	 * This could happen due to an expired page or network issues
	 *
	 * @return Response
	 */
	public function getPay()
    {
       return redirect()->intended('checkout');
    }
    
    
    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postRedirectToGateway(Request $request)
    {
		$user = null;
		
    	if(Auth::check())
		{
			$user = Auth::user();
		}
		
		
		$req = $request->all();
       #dd($req);
        $type = json_decode($req['metadata']);
        //dd($type);
        
		#$name = isset($req['name']) ? $req['name'] : $req['fname']." ".$req['lname'];
        #dd($name);
		
        $validator = Validator::make($req, [
							 'amount' => 'required',
                             'email' => 'required|email|filled'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
			 if($req['amount'] < 1)
			 {
				 $err = "error";
				 session()->flash("no-cart-status-error","ok");
				 return redirect()->back();
			 }
			 else
			 {
			   //$paystack = new Paystack();
			   #dd($request);
			   $request->reference = Paystack::genTranxRef();
               $request->key = config('paystack.secretKey');
			 
			   try{
				 return Paystack::getAuthorizationUrl()->redirectNow(); 
			   }
			   catch(Exception $e)
			   {
				 $request->session()->flash("pay-card-status-error","ok");
			     return redirect()->intended("checkout");
			   } 
			 }        
         }        
        
        
    }
    
    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getPaymentCallback(Request $request)
    {
		$user = null;
		$messages = [];
		
		if(Auth::check())
		{
			$user = Auth::user();
			$messages = $this->helpers->getMessages(['user_id' => $user->id]);
		}
		else
		{
			return redirect()->intended('/');
		}
		
        $paymentDetails = Paystack::getPaymentData();

        #dd($paymentDetails);       
        
        $paymentData = $paymentDetails['data'];
        $md = $paymentData['metadata'];
		
		
		#dd($md);       
		$successLocation = "";
        $failureLocation = "";
        
        switch($md['type'])
        {
        	case 'checkout':
              $successLocation = "orders";
             $failureLocation = "checkout";           
            break; 
            
       }
        //status, reference, metadata(order-id,items,amount,ssa), type
        if($paymentData['status'] == 'success')
        {
			#dd($md);
			$id = $md['ref'];
			 
			#dd($paymentData);
        	$this->helpers->checkout($user,$paymentData);
			
			
			/**
			//send email to user
			
			$o = $this->helpers->getOrder($id);
               #dd($o);
			   
               if($o != null || count($o) > 0)
               {		  
				  
               	//We have the user, notify the customer and admin
				//$ret = $this->helpers->smtp;
				$ret = $this->helpers->getCurrentSender();
				$ret['order'] = $o;
				$ret['name'] = $name;
				$ret['subject'] = "Your payment for order ".$o['payment_code']." has been confirmed!";
		        $ret['em'] = $email;
		        $this->helpers->sendEmailSMTP($ret,"emails.confirm-payment");
				
				#$ret = $this->helpers->smtp;
				$ret['order'] = $o;
				$ret['user'] =$email;
				$ret['phone'] =$phone;
		        $ret['subject'] = "URGENT: Received payment for order ".$o['payment_code'];
		        $ret['shipping'] = $shipping;
		        $ret['em'] = $this->helpers->adminEmail;
		        $this->helpers->sendEmailSMTP($ret,"emails.admin-payment-alert");
				$ret['em'] = $this->helpers->suEmail;
		        $this->helpers->sendEmailSMTP($ret,"emails.admin-payment-alert");
               }
			   **/
			   
            $request->session()->flash("pay-card-status","ok");
			//return redirect()->intended($successLocation);
			
			$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		$c = $this->helpers->getCategories();
		$ads = $this->helpers->getAds();
		$plugins = $this->helpers->getPlugins();
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		$signals = $this->helpers->signals;
			
			return view("cps",compact(['user','cart','c','messages','ad','signals','plugins']));
        }
        else
        {
        	//Payment failed, redirect to orders
            $request->session()->flash("pay-card-status","error");
			return redirect()->intended($failureLocation);
        }
    }
    
    
}
