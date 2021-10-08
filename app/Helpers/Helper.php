<?php
namespace App\Helpers;

use App\Helpers\Contracts\HelperContract; 
use Crypt;
use Carbon\Carbon; 
use Mail;
use Auth;
use Illuminate\Http\Request;
use App\User;
use App\Carts;
use App\Ads;
use App\Banners;
use App\Senders;
use App\Settings;
use App\Plugins;
use App\Socials;
use App\Messages;
use App\Permissions;
use App\Tickets;
use App\TicketItems;
use App\Faqs;
use App\FaqTags;
use App\Fmails;
use App\Attachments;
use App\Guests;
use \Swift_Mailer;
use \Swift_SmtpTransport;
use \Cloudinary;
use \Cloudinary\Api;
use \Cloudinary\Api\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Codedge\Fpdf\Fpdf\Fpdf;


class Helper implements HelperContract
{

 public $signals = ['okays'=> [
                     //SUCCESS NOTIFICATIONS
					 "login-status" => "Welcome back!",            
                     "update-user-status" => "User profile updated.",
                     "switch-mode-status" => "You have now switched your account mode.",
					 "valid-mode-status-error" => "Access denied. Try switching your account mode to access the resource.",
					 "sci-status" => "Cover image updated.",
					 "cover-image-status-error" => "You cannot delete the cover image.",
					 "ri-status" => "Image deleted.",
					 "delete-avatar-status" => "Avatar removed.",
					 "delete-apartment-status" => "Apartment removed.",
					 "update-apartment-status" => "Apartment information updated.",
					 "oauth-sp-status" => "Welcome to Etuk NG! You can now use your new account.",
					 "add-review-status" => "Thanks for your review! It will be displayed after review by our admins.",
					 "add-to-cart-status" => "Added to your cart.",
					 "remove-from-cart-status" => "Removed from your cart.",
					 "pay-card-status" => "Payment successful. Have a lovely stay!",
					 "save-apartment-status" => "Apartment saved.",
					 "save-duplicate-apartment-status" => "You have saved this apartment already.",
					 "add-permissions-status" => "Permission(s) added.",
					 "remove-permission-status" => "Permission(s) removed.",
					 "update-review-status" => "Review updated.",
					 "remove-review-status" => "Review removed.",
					 "add-plugin-status" => "Plugin installed.",
					 "update-plugin-status" => "Plugin updated.",
					 "remove-plugin-status" => "Plugin removed.",
	                                 "add-sender-status" => "Sender added",
                                         "remove-sender-status" => "Sender removed",
                                         "mark-sender-status" => "Sender updated",
					 "remove-ticket-status" => "Ticket removed.",
					 "add-ticket-status" => "Ticket created.",
					 "update-ticket-status" => "Ticket updated.",
					 "add-banner-status" => "Banner image uploaded.",
					 "update-banner-status" => "Banner info updated.",
					 "remove-banner-status" => "Banner image removed.",
					 "add-faq-status" => "FAQ added.",
					 "update-faq-status" => "FAQ updated.",
					 "remove-faq-status" => "FAQ removed.",
					 "add-faq-tag-status" => "FAQ tag added.",
					 "remove-faq-tag-status" => "FAQ tag removed.",
					 "add-post-status" => "Post added.",
					 "update-post-status" => "Post updated.",
					 "remove-post-status" => "Post removed.",
					 "add-reservation-status" => "Reservation added.",
					 "update-reservation-status" => "Reservation log updated.",
					 "remove-reservation-status" => "Reservation log removed.",
					 "respond-to-reservation-status" => "Response sent.",
					 "add-plan-status" => "Subscription plan added.",
					 "update-plan-status" => "Subscription plan updated.",
					 "remove-plan-status" => "Subscription plan removed.",
					 "send-message-status" => "Message sent!",
					 "add-apartment-tip-status" => "Tip added!",
					 "remove-apartment-tip-status" => "Tip removed!",
					 
					 //ERROR NOTIFICATIONS
					 "invalid-user-status-error" => "User not found.",
					 "invalid-apartment-id-status-error" => "Apartment not found.",
					 "add-review-status-error" => "Please sign in to add a review.",
					 "duplicate-review-status-error" => "You have added a review already.",
					 "oauth-status-error" => "Social login failed, please try again.",
					 "login-auth-status-error" => "Your login/password was not correct.",
					 "cart-auth-status-error" => "Please sign in to view your cart.",
					 "save-apartment-auth-status-error" => "Please sign in to save an apartment.",
					 "validation-status-error" => "Please fill all required fields.",
					 "add-to-cart-host-status-error" => "You cannot book your own apartment.",
					 "rp-invalid-token-status-error" => "The code is invalid or has expired.",
					 "pay-card-status-error" => "Your payment could not be processed, please try again.",
					 "save-apartment-status-error" => "Apartment could not be saved, please try again.",
					 "add-permissions-status-error" => "Permission(s) could not be added, please try again.",
					 "remove-permission-status-error" => "Permission(s) could not be removed, please try again.",
					 "update-review-status-error" => "Review could not be updated, please try again.",
					 "remove-review-status-error" => "Review could not be removed, please try again.",
					 "update-plugin-status-error" => "Plugin could not be updated, please try again.",
					 "remove-plugin-status-error" => "Plugin could not be removed, please try again.",
					 "remove-ticket-status-error" => "Ticket could not be removed, please try again.",
					 "permissions-status-error" => "Access denied.",
					 "add-ticket-status-error" => "Ticket could not be created, please try again",
					 "update-ticket-status-error" => "Ticket could not be updated, please try again.",
					 "network-status-error" => "Network error occured, please check your Internet connection and try again.",
					 "add-banner-status-error" => "Banner could not be created, please try again",
					 "update-banner-status-error" => "Banner could not be updated, please try again",
					 "remove-banner-status-error" => "Banner could not be removed, please try again",
					 "add-faq-status-error" => "FAQ could not be added, please try again.",
					 "update-faq-status-error" => "FAQ could not be updated, please try again.",
					 "remove-faq-status-error" => "FAQ could not be removed, please try again.",
					 "add-faq-tag-status-error" => "FAQ tag could not be added, please try again.",
					 "remove-faq-tag-status-error" => "FAQ tag could not be removed, please try again.",
					 "add-post-status-error" => "Post could not be added, please try again.",
					 "update-post-status-error" => "Post could not be updated, please try again.",
					 "remove-post-status-error" => "Post could not be removed, please try again.",
					 "add-reservation-status-error" => "Reservation could not be created, please try again",
					 "update-reservation-status-error" => "Reservation could not be updated, please try again.",
					 "remove-reservation-status-error" => "Reservation could not be removed, please try again.",
					 "add-plan-status-error" => "Subscription plan could not be added, please try again.",
					 "update-plan-status-error" => "Subscription plan could not be updated, please try again.",
					 "remove-plan-status-error" => "Subscription plan could not be removed, please try again.",
					 "send-message-status-error" => "An error occured while sending your message.",
					 "add-apartment-tip-status-error" => "An error occured while adding tip.",
					 "remove-apartment-tip-status-error" => "An error occured while removing tip.",
                     ],
                     'errors'=> ["login-status-error" => "Wrong username or password, please try again.",
					 "signup-status-error" => "There was a problem creating your account, please try again.",
					 "update-profile-status-error" => "There was a problem updating your profile, please try again.",
                    ]
                   ];
  
  public $states = [
			                       'abia' => 'Abia',
			                       'adamawa' => 'Adamawa',
			                       'akwa-ibom' => 'Akwa Ibom',
			                       'anambra' => 'Anambra',
			                       'bauchi' => 'Bauchi',
			                       'bayelsa' => 'Bayelsa',
			                       'benue' => 'Benue',
			                       'borno' => 'Borno',
			                       'cross-river' => 'Cross River',
			                       'delta' => 'Delta',
			                       'ebonyi' => 'Ebonyi',
			                       'enugu' => 'Enugu',
			                       'edo' => 'Edo',
			                       'ekiti' => 'Ekiti',
			                       'gombe' => 'Gombe',
			                       'imo' => 'Imo',
			                       'jigawa' => 'Jigawa',
			                       'kaduna' => 'Kaduna',
			                       'kano' => 'Kano',
			                       'katsina' => 'Katsina',
			                       'kebbi' => 'Kebbi',
			                       'kogi' => 'Kogi',
			                       'kwara' => 'Kwara',
			                       'lagos' => 'Lagos',
			                       'nasarawa' => 'Nasarawa',
			                       'niger' => 'Niger',
			                       'ogun' => 'Ogun',
			                       'ondo' => 'Ondo',
			                       'osun' => 'Osun',
			                       'oyo' => 'Oyo',
			                       'plateau' => 'Plateau',
			                       'rivers' => 'Rivers',
			                       'sokoto' => 'Sokoto',
			                       'taraba' => 'Taraba',
			                       'yobe' => 'Yobe',
			                       'zamfara' => 'Zamfara',
			                       'fct' => 'FCT'  
			];  

  public $countries = [
'afghanistan' => "Afghanistan",
'albania' => "Albania",
'algeria' => "Algeria",
'andorra' => "Andorra",
'angola' => "Angola",
'antigua-barbuda' => "Antigua and Barbuda",
'argentina' => "Argentina",
'armenia' => "Armenia",
'australia' => "Australia",
'austria' => "Austria",
'azerbaijan' => "Azerbaijan",
'bahamas' => "The Bahamas",
'bahrain' => "Bahrain",
'bangladesh' => "Bangladesh",
'barbados' => "Barbados",
'belarus' => "Belarus",
'belgium' => "Belgium",
'belize' => "Belize",
'benin' => "Benin",
'bhutan' => "Bhutan",
'bolivia' => "Bolivia",
'bosnia' => "Bosnia and Herzegovina",
'botswana' => "Botswana",
'brazil' => "Brazil",
'brunei' => "Brunei",
'bulgaria' => "Bulgaria",
'burkina-faso' => "Burkina Faso",
'burundi' => "Burundi",
'cambodia' => "Cambodia",
'cameroon' => "Cameroon",
'canada' => "Canada",
'cape-verde' => "Cape Verde",
'caf' => "Central African Republic",
'chad' => "Chad",
'chile' => "Chile",
'china' => "China",
'colombia' => "Colombia",
'comoros' => "Comoros",
'congo-1' => "Congo, Republic of the",
'congo-2' => "Congo, Democratic Republic of the",
'costa-rica' => "Costa Rica",
'cote-divoire' => "Cote DIvoire",
'croatia' => "Croatia",
'cuba' => "Cuba",
'cyprus' => "Cyprus",
'czech' => "Czech Republic",
'denmark' => "Denmark",
'djibouti' => "Djibouti",
'dominica' => "Dominica",
'dominica-2' => "Dominican Republic",
'timor' => "East Timor (Timor-Leste)",
'ecuador' => "Ecuador",
'egypt' => "Egypt",
'el-salvador' => "El Salvador",
'eq-guinea' => "Equatorial Guinea",
'eritrea' => "Eritrea",
'estonia' => "Estonia",
'ethiopia' => "Ethiopia",
'fiji' => "Fiji",
'finland' => "Finland",
'france' => "France",
'gabon' => "Gabon",
'gambia' => "The Gambia",
'georgia' => "Georgia",
'germany' => "Germany",
'ghana' => "Ghana",
'greece' => "Greece",
'grenada' => "Grenada",
'guatemala' => "Guatemala",
'guinea' => "Guinea",
'guinea-bissau' => "Guinea-Bissau",
'guyana' => "Guyana",
'haiti' => "Haiti",
'honduras' => "Honduras",
'hungary' => "Hungary",
'iceland' => "Iceland",
'india' => "India",
'indonesia' => "Indonesia",
'iran' => "Iran",
'iraq' => "Iraq",
'ireland' => "Ireland",
'israel' => "Israel",
'italy' => "Italy",
'jamaica' => "Jamaica",
'japan' => "Japan",
'jordan' => "Jordan",
'kazakhstan' => "Kazakhstan",
'kenya' => "Kenya",
'kiribati' => "Kiribati",
'nk' => "Korea, North",
'sk' => "Korea, South",
'kosovo' => "Kosovo",
'kuwait' => "Kuwait",
'kyrgyzstan' => "Kyrgyzstan",
'laos' => "Laos",
'latvia' => "Latvia",																																																																																							
'lebanon' => "Lebanon",
'lesotho' => "Lesotho",
'liberia' => "Liberia",
'libya' => "Libya",
'liechtenstein' => "Liechtenstein",
'lithuania' => "Lithuania",
'luxembourg' => "Luxembourg",
'macedonia' => "Macedonia",
'madagascar' => "Madagascar",
'malawi' => "Malawi",
'malaysia' => "Malaysia",
'maldives' => "Maldives",
'mali' => "Mali",
'malta' => "Malta",
'marshall' => "Marshall Islands",
'mauritania' => "Mauritania",
'mauritius' => "Mauritius",
'mexico' => "Mexico",
'micronesia' => "Micronesia, Federated States of",
'moldova' => "Moldova",
'monaco' => "Monaco",
'mongolia' => "Mongolia",
'montenegro' => "Montenegro",
'morocco' => "Morocco",
'mozambique' => "Mozambique",
'myanmar' => "Myanmar (Burma)",
'namibia' => "Namibia",
'nauru' => "Nauru",
'nepal' => "Nepal",
'netherlands' => "Netherlands",
'nz' => "New Zealand",
'nicaragua' => "Nicaragua",
'niger' => "Niger",
'nigeria' => "Nigeria",
'norway' => "Norway",
'oman' => "Oman",
'pakistan' => "Pakistan",
'palau' => "Palau",
'panama' => "Panama",
'png' => "Papua New Guinea",
'paraguay' => "Paraguay",
'peru' => "Peru",
'philippines' => "Philippines",
'poland' => "Poland",
'portugal' => "Portugal",
'qatar' => "Qatar",
'romania' => "Romania",
'russia' => "Russia",
'rwanda' => "Rwanda",
'st-kitts' => "Saint Kitts and Nevis",
'st-lucia' => "Saint Lucia",
'svg' => "Saint Vincent and the Grenadines",
'samoa' => "Samoa",
'san-marino' => "San Marino",
'sao-tome-principe' => "Sao Tome and Principe",
'saudi -arabia' => "Saudi Arabia",
'senegal' => "Senegal",
'serbia' => "Serbia",
'seychelles' => "Seychelles",
'sierra-leone' => "Sierra Leone",
'singapore' => "Singapore",
'slovakia' => "Slovakia",
'slovenia' => "Slovenia",
'solomon-island' => "Solomon Islands",
'somalia' => "Somalia",
'sa' => "South Africa",
'ss' => "South Sudan",
'spain' => "Spain",
'sri-lanka' => "Sri Lanka",
'sudan' => "Sudan",
'suriname' => "Suriname",
'swaziland' => "Swaziland",
'sweden' => "Sweden",
'switzerland' => "Switzerland",
'syria' => "Syria",
'taiwan' => "Taiwan",
'tajikistan' => "Tajikistan",
'tanzania' => "Tanzania",
'thailand' => "Thailand",
'togo' => "Togo",
'tonga' => "Tonga",
'trinidad-tobago' => "Trinidad and Tobago",
'tunisia' => "Tunisia",
'turkey' => "Turkey",
'turkmenistan' => "Turkmenistan",
'tuvalu' => "Tuvalu",
'uganda' => "Uganda",
'ukraine' => "Ukraine",
'uae' => "United Arab Emirates",
'uk' => "United Kingdom",
'usa' => "United States of America",
'uruguay' => "Uruguay",
'uzbekistan' => "Uzbekistan",
'vanuatu' => "Vanuatu",
'vatican' => "Vatican City",
'venezuela' => "Venezuela",
'vietnam' => "Vietnam",
'yemen' => "Yemen",
'zambia' => "Zambia",
'zimbabwe' => "Zimbabwe"
];


public $smtpp = [
       'gmail' => [
       'ss' => "smtp.gmail.com",
       'sp' => "587",
       'sec' => "tls",
       ],
       'yahoo' => [
       'ss' => "smtp.mail.yahoo.com",
       'sp' => "587",
       'sec' => "ssl",
       ],
  ];
	
 public $banks = [
      'access' => "Access Bank", 
      'citibank' => "Citibank", 
      'diamond-access' => "Diamond-Access Bank", 
      'ecobank' => "Ecobank", 
      'fidelity' => "Fidelity Bank", 
      'fbn' => "First Bank", 
      'fcmb' => "FCMB", 
      'globus' => "Globus Bank", 
      'gtb' => "GTBank", 
      'heritage' => "Heritage Bank", 
      'jaiz' => "Jaiz Bank", 
      'keystone' => "KeyStone Bank", 
      'polaris' => "Polaris Bank", 
      'providus' => "Providus Bank", 
      'stanbic' => "Stanbic IBTC Bank", 
      'standard-chartered' => "Standard Chartered Bank", 
      'sterling' => "Sterling Bank", 
      'suntrust' => "SunTrust Bank", 
      'titan-trust' => "Titan Trust Bank", 
      'union' => "Union Bank", 
      'uba' => "UBA", 
      'unity' => "Unity Bank", 
      'wema' => "Wema Bank", 
      'zenith' => "Zenith Bank"
 ];			

  public $ip = "";
  
    public $permissions = [
	   'view_users','edit_users',
	   'view_apartments','edit_apartments',
	   'view_reviews','edit_reviews',
	   'view_transactions','edit_transactions',
	   'view_tickets','edit_tickets',
	   'view_banners','edit_banners',
	   'view_plugins','edit_plugins',
	    'view_senders','edit_senders',
	    'view_posts','edit_posts'
	   ];
  
  public $adminEmail = "aquarius4tkud@yahoo.com";
  public $suEmail = "kudayisitobi@gmail.com";
  
  public $admin = [
			    'id' => "admin",
			    'fname' => "Admin",
			    'lname' => "",
			    'phone' => "08168923876",
			    //'email' => "adesola.oje@etuk.ng",
			    'email' => "aquarius4tkud@yahoo.com",
			  ];

  public $su = [
			    'id' => "admin",
			    'fname' => "Admin",
			    'lname' => "",
			    'phone' => "07054291601",
			    'email' => "kudayisitobi@gmail.com",
			  ];

    
           
		   #{'msg':msg,'em':em,'subject':subject,'link':link,'sn':senderName,'se':senderEmail,'ss':SMTPServer,'sp':SMTPPort,'su':SMTPUser,'spp':SMTPPass,'sa':SMTPAuth};
           function sendEmailSMTP($data,$view,$type="view")
           {
           	    // Setup a new SmtpTransport instance for new SMTP
                $transport = "";
if($data['sec'] != "none") $transport = new Swift_SmtpTransport($data['ss'], $data['sp'], $data['sec']);

else $transport = new Swift_SmtpTransport($data['ss'], $data['sp']);

   if($data['sa'] != "no"){
                  $transport->setUsername($data['su']);
                  $transport->setPassword($data['spp']);
     }
// Assign a new SmtpTransport to SwiftMailer
$smtp = new Swift_Mailer($transport);

// Assign it to the Laravel Mailer
Mail::setSwiftMailer($smtp);

$se = $data['se'];
$sn = $data['sn'];
$to = $data['em'];
$subject = $data['subject'];
                   if($type == "view")
                   {
                     Mail::send($view,$data,function($message) use($to,$subject,$se,$sn){
                           $message->from($se,$sn);
                           $message->to($to);
                           $message->subject($subject);
                          if(isset($data["has_attachments"]) && $data["has_attachments"] == "yes")
                          {
                          	foreach($data["attachments"] as $a) $message->attach($a);
                          } 
						  $message->getSwiftMessage()
						  ->getHeaders()
						  ->addTextHeader('x-mailgun-native-send', 'true');
                     });
                   }

                   elseif($type == "raw")
                   {
                     Mail::raw($view,$data,function($message) use($to,$subject,$se,$sn){
                            $message->from($se,$sn);
                           $message->to($to);
                           $message->subject($subject);
                           if(isset($data["has_attachments"]) && $data["has_attachments"] == "yes")
                          {
                          	foreach($data["attachments"] as $a) $message->attach($a);
                          } 
                     });
                   }
           }

           function bomb($data) 
           {
             $url = $data['url'];
               
			       $client = new Client([
                 // Base URI is used with relative requests
                 'base_uri' => 'http://httpbin.org',
                 // You can set any number of default request options.
                 //'timeout'  => 2.0,
				 'headers' => isset($data['headers']) && count($data['headers']) > 0 ? $data['headers'] : []
                 ]);
                  
				 
				 $dt = [
				    
				 ];
				 
				 if(isset($data['auth']))
				 {
					 $dt['auth'] = $data['auth'];
				 }
				 if(isset($data['data']))
				 {
					if(isset($data['type']) && $data['type'] == "raw")
					{
					  $dt['body'] = $data['data'];
					}
					else
					{
					  $dt['multipart'] = [];
					  foreach($data['data'] as $k => $v)
				      {
					    $temp = [
					      'name' => $k,
						  'contents' => $v
					     ];
						 
					     array_push($dt['multipart'],$temp);
				      }
					}
				   
				 }
				 
				 try
				 {
					 dd($data);
					$res = $client->request(strtoupper($data['method']),$url,$dt);
					$ret = $res->getBody()->getContents(); 
			       //dd($ret);

				 }
				 catch(RequestException $e)
				 {
					dd($e);
					# $mm = (is_null($e->getResponse())) ? null: Psr7\str($e->getResponse());
					 $mm = (is_null($e->getResponse())) ? null: $e->getResponse();
					 $ret = json_encode(["status" => "error","message" => $mm]);
				 }
			     $rett = json_decode($ret);
           return $ret; 
           }
		   
		   
		   function text($data) 
           {
           	//form query string
              // $qs = "sn=".$data['sn']."&sa=".$data['sa']."&subject=".$data['subject'];

               $lead = $data['to'];
			   
			   if($lead == null || $lead == "")
			   {
				    $ret = json_encode(["status" => "error","message" => "Invalid number"]);
			   }
			   else
			    { 
                  
			       $url = "https://smartsmssolutions.com/api/?";
			       $url .= "message=".urlencode($data['msg'])."&to=".$data['to'];
			       $url .= "&sender=Etuk+NG&type=0&routing=3&token=".env('SMARTSMS_API_X_KEY', '');
			      #dd($url);
				  
                  $dt = [
				       'headers' => [
					     'Content-Type' => "text/html"
					   ],
                       'method' => "get",
                       'url' => $url
                  ];
				
				 $ret = $this->bomb($dt);
				 #dd($ret);
				 $smsData = explode("||",$ret);
				 if(count($smsData) == 2)
				 {
					 $status = $smsData[0];
					 $dt = $smsData[1];
					 
					 if($status == "1000")
					 {
						$rett = json_decode($dt);
			            if($rett->code == "1000")
			            {
					      $ret = json_encode(["status" => "ok","message" => "Message sent!"]); 			
			             }
				         else
			             {
			         	   $ret = json_encode(["status" => "error","message" => "Error sending message."]); 
			             } 
					 }
					 else
					 {
						 $ret = json_encode(["status" => "error","message" => "Error sending message."]); 
					 }
				 }
				 else
				 {
					$ret = json_encode(["status" => "error","message" => "Malformed response from SMS API"]); 
				 }
			     
			    }
				
              return $ret; 
           }
		   
		   
           function createUser($data)
           {
			   $pass = (isset($data['pass']) && $data['pass'] != "") ? bcrypt($data['pass']) : "";
			   
           	   $ret = User::create(['fname' => $data['fname'], 
                                                      'lname' => $data['lname'], 
                                                      'username' => $data['username'], 
                                                      'role' => $data['role'], 
                                                      'status' => $data['status'], 
                                                      'password' => $pass, 
                                                      ]);
                                                      
                return $ret;
           }
		   
		   	function getSetting($id)
	{
		$temp = [];
		$s = Settings::where('id',$id)
		             ->orWhere('name',$id)->first();
 
              if($s != null)
               {
				      $temp['name'] = $s->name; 
                       $temp['value'] = $s->value;                  
                       $temp['id'] = $s->id; 
                       $temp['date'] = $s->created_at->format("jS F, Y"); 
                       $temp['updated'] = $s->updated_at->format("jS F, Y"); 
                   
               }      
       return $temp;            	   
   }
		   
   function getUsers()
   {
	   $ret = [];
	   
	   $users = User::where('id','>',"0")->get();
	   $users = $users->sortByDesc('created_at');
	   
	   if(!is_null($users))
	   {
		   foreach($users as $u)
		   {
				$temp = $this->getUser($u->id);
		        array_push($ret,$temp); 
	       }
	   }
	   
	   return $ret;
   }
   
		   
		   function getUser($id)
           {
           	$ret = [];
			if($id == "adminn" || $id == "suu")
			{
			  if($id == "adminn")
			  {
				  $ret = $this->admin;
			  }
			  else if($id == "suu")
			  {
				  $ret = $this->su;
			  }
			  
			  $ret['avatar'] = "";
			}
			else
			{
				$u = User::where('username',$id)
			            ->orWhere('id',$id)->first();
              
              if($u != null)
               {
                   	$temp['fname'] = $u->fname; 
                       $temp['lname'] = $u->lname; 
                       //$temp['wallet'] = $this->getWallet($u);
                       $temp['username'] = $u->username; 
                       $temp['role'] = $u->role; 
                       $temp['status'] = $u->status;
					  $temp['id'] = $u->id; 
                       $temp['date'] = $u->created_at->format("jS F, Y"); 
                       $temp['updated'] = $u->updated_at->format("jS F, Y h:i A"); 
                       $ret = $temp; 
               }
			}                                      
            
			return $ret;
           }
		   
		   function updateUser($data)
           {  
              $ret = 'error'; 
         
              if(isset($data['xf']))
               {
               	$u = User::where('id', $data['xf'])->first();
                   
                        if($u != null)
                        {
							$role = $u->role;
							if(isset($data['role'])) $role = $data['role'];
							$status = $u->status;
							if(isset($data['status'])) $status = $data['status'];
							#$avatar = isset($data['avatar']) ? $data['avatar'] : "";
							
                        	$u->update(['fname' => $data['fname'],
                                              'lname' => $data['lname'],
                                              'role' => $role,
                                              'status' => $status,
                                           ]);
						                   
                                           $ret = "ok";
                        }                                    
               }                                 
                  return $ret;                               
           }

		   function updateEDU($data)
           {  
              $ret = 'error'; 
         
              if(isset($data['xf']))
               {
               	$u = User::where('id', $data['xf'])->first();
                   
                        if($u != null)
                        {
							$status = $data['type'] == "enable" ? "enabled" : "disabled";
							
                        	$u->update(['status' => $status]);
						                   
                             $ret = "ok";
                        }                                    
               }                                 
                  return $ret;                               
           }



function isDuplicateUser($data)
	{
		$ret = false;

		$dup = User::where('username',$data['username'])->get();

       if(count($dup) > 0) $ret = true;		
		return $ret;
	}
	
	function isValidUser($data)
	{
		$ret = false;
        $email = isset($data['email']) ? $data['email'] : "none";
        $phone = isset($data['phone']) ? $data['phone'] : "none";
		
		$dup = User::where('email',$email)
		           ->orWhere('phone',$phone)->get();

       if(count($dup) == 1) $ret = true;		
		return $ret;
	}

	function isOAuthSP($em)
	{
		$ret = false;
		
		$u = User::where('email',$em)->first();

       if($u->password == "") $ret = true;		
		return $ret;
	}
	
	function getPasswordResetCode($user)
           {
           	$u = $user; 
               
               if($u != null)
               {
               	//We have the user, create the code
                   $code = bcrypt(rand(125,999999)."rst".$u->id);
               	$u->update(['reset_code' => $code]);
               }
               
               return $code; 
           }
           
           function verifyPasswordResetCode($code)
           {
           	$u = User::where('reset_code',$code)->first();
               
               if($u != null)
               {
               	//We have the user, delete the code
               	$u->update(['reset_code' => '']);
               }
               
               return $u; 
           }
	
	
	 function getSender($id)
           {
           	$ret = [];
               $s = Senders::where('id',$id)->first();
 
              if($s != null)
               {
                   	$temp['ss'] = $s->ss; 
                       $temp['sp'] = $s->sp; 
                       $temp['se'] = $s->se;
                       $temp['sec'] = $s->sec; 
                       $temp['sa'] = $s->sa; 
                       $temp['su'] = $s->su; 
                       $temp['current'] = $s->current; 
                       $temp['spp'] = $s->spp; 
					   $temp['type'] = $s->type;
                       $sn = $s->sn;
                       $temp['sn'] = $sn;
                        $snn = explode(" ",$sn);					   
                       $temp['snf'] = $snn[0]; 
                       $temp['snl'] = count($snn) > 0 ? $snn[1] : ""; 
					   
                       $temp['status'] = $s->status; 
                       $temp['id'] = $s->id; 
                       $temp['date'] = $s->created_at->format("jS F, Y"); 
                       $ret = $temp; 
               }                          
                                                      
                return $ret;
           }
		   
		    function getCurrentSender()
		   {
			   $ret = [];
			   $s = Senders::where('current',"yes")->first();
			   
			   if($s != null)
			   {
				   $ret = $this->getSender($s['id']);
			   }
			   
			   return $ret;
		   }
		   
		   function createPlugin($data)
           {
			   #dd($data);
			 $ret = null;
			 
			 
				 $ret = Plugins::create(['name' => $data['name'], 
                                                      'value' => $data['value'], 
                                                      'status' => $data['status'], 
                                                      ]);
			  return $ret;
           }
		   
		    function getPlugins()
   {
	   $ret = [];
	   
	   $plugins = Plugins::where('id','>',"0")->get();
	   
	   if(!is_null($plugins))
	   {
		   foreach($plugins as $p)
		   {
			 
				$temp = $this->getPlugin($p->id);
		        array_push($ret,$temp); 
			 
	       }
	   }
	   
	   return $ret;
   }
   
   function getPlugin($id)
           {
           	$ret = [];
               $p = Plugins::where('id',$id)->first();
 
              if($p != null)
               {
                   	$temp['name'] = $p->name; 
                       $temp['value'] = $p->value; 	   
                       $temp['status'] = $p->status; 
                       $temp['id'] = $p->id; 
                       $temp['date'] = $p->created_at->format("jS F, Y"); 
                       $temp['updated'] = $p->updated_at->format("jS F, Y"); 
                       $ret = $temp; 
               }                          
                                                      
                return $ret;
           }
		   
		    function updatePlugin($data,$user=null)
           {
			   #dd($data);
			 $ret = "error";
			  $p = Plugins::where('id',$data['xf'])->first();
			 
			 
			 if(!is_null($p))
			 {
				 $p->update(['name' => $data['name'], 
                                                      'value' => $data['value'], 
                                                      'status' => $data['status']
                                                      ]);
			   $ret = "ok";
			 }
           	
                                                      
                return $ret;
           }

		   function removePlugin($xf,$user=null)
           {
			   #dd($data);
			 $ret = "error";
			 $p = Plugins::where('id',$xf)->first();

			 
			 if(!is_null($p))
			 {
				 $p->delete();
			   $ret = "ok";
			 }
           
           }
		   
		    function isAdmin($user)
           {
           	$ret = false; 
               if($user->role === "admin" || $user->role === "su") $ret = true; 
           	return $ret;
           }
		   
		   function generateSKU()
           {
           	$ret = "ETUK".rand(1,9999)."GN".rand(1,999);
                                                      
                return $ret;
           }
		   



function createSocial($data)
           {
			   $token = isset($data['token']) ? $data['token'] : "";
			   $ret = Socials::create(['name' => $data['name'], 
                                                      'email' => $data['email'],
                                                      'token' => $token,
                                                      'type' => $data['type']
                                                      ]);
                                                      
                return $ret;
           }
		   
		   function getSocials($em)
           {
           	$ret = [];
              $socials = Socials::where('email',$em)->get();
              $socials = $socials->sortByDesc('created_at');	
			  
              if($socials != null)
               {
				  foreach($socials as $s)
				  {
					  $temp = $this->getSocial($s->id);
					  array_push($ret,$temp);
				  }
               }                         
                                  
                return $ret;
           }
		   
		   function getSocial($id)
           {
           	$ret = [];
              $s = Socials::where('id',$id)
			                 ->orWhere('email',$id)->first();
 
              if($s != null)
               {
				  $temp = [];
				  $temp['id'] = $s->id;
				  $temp['name'] = $s->name;
				  $temp['token'] = $s->token;
     			  $temp['email'] = $s->email;
     			  $temp['type'] = $s->type;
				  $temp['date'] = $s->created_at->format("jS F, Y");
				  $ret = $temp;
               }                         
                                                      
                return $ret;
           }
		   
		   
		   function oauth($dt)
		   {
			   #dd($dt);
			   /**
^ array:5 [▼
  "name" => "Tobi Kudayisi"
  "type" => "google"
  "email" => "kudayisitobi@gmail.com"
  "img" => "https://lh5.googleusercontent.com/-4mnp7uOSAcQ/AAAAAAAAAAI/AAAAAAAAAAA/AMZuucnPGlNuP-mD3NeQ2yJaa3I_OzCrzQ/photo.jpg"
  "token" => "ya29.a0AfH6SMCXQrY-b4cp1DDLepffsJKBg7tHsoGTuDuXCGguKJ-IAuK3ZGCu2bSJ3MByO2H4YQmLDJ1T2z2QC5JiyZkASGWN_xc1gI4UBv9TOu4S15w5r4XdusffD_xKdo8P-BCvzX0Ti5pa4zTVUl3YDcZvw ▶"
]
			   **/
			    $ret = ['status' => "error",
					           'message' => "oauth"
							  ];
							  
			   if($dt != null && count($dt) > 0)
			   {
				    $s = [
					          'name' => $dt['name'],
					          'email' => $dt['email'],
					          'type' => $dt['type'],
					          'token' => $dt['token']
					        ];
							
				   //check if user exists in db
				   $userExists = $this->isValidUser($dt);
				   $social =  Socials::where('email',$dt['email'])
				                           ->where('type',$dt['type'])->first();
				   if($userExists)
				   {
					   //user exists. Log user in
					   $u = User::where('email',$dt['email'])->first();
					   if($u->password == "")
					   {
						   //User signed up via social and has not set password
						  
                            $ret = [
							   'status' => "ok",
					           'message' => "existing-user-no-pass",
							   'user' => $u
							  ];
					   }
					   else
					   {
						  //User exists and has password. Sign user in 
						  Auth::login($u);
					      $ret = [
						          'status' => "ok",
					              'message' => "existing-user"
							     ]; 
							     
							        //update avatar 
					  if($u->avatar == "") $u->update(['avatar' => $dt['img'],'avatar_type' => "social"]);
					   }
				   }
				   else
				   {
					   //user does not exist. create new user
                       $nn = explode(" ",$dt['name']);
                       $dt['fname'] = $nn[0];
                       $dt['lname'] = $nn[1];
                       $dt['phone'] = "";
                       $dt['pass'] = "";
                       $dt['role'] = "user";    
                       $dt['status'] = "enabled";           
                       $dt['mode'] = "guest";           
                       $dt['currency'] = "ngn";           
                       $dt['verified'] = "yes";
					  
                       $uu = $this->createUser($dt);
                       
					   //set avatar 
					  if($uu->avatar == "") $uu->update(['avatar' => $dt['img'],'avatar_type' => "social"]);
					  
                       //set password for new user
                       $ret = ['status' => "ok",
					           'message' => "new-user",
							   'user' => $uu
							  ];
						
				   }
				   
				   //save social profile
                   if($social == null) $s = $this->createSocial($s);
			   }
			   
			   return $ret;
		   }
		   
		   
		   function createFmail($dt)
		   {
			    $ret = Fmails::create(['message' => json_encode($dt)]);
				$this->parseMessage($ret->id);
				return $ret;
		   }
		   
		   function getFmails()
           {
           	$ret = [];
			  $messages = Fmails::where('id','>','0')->get();
			  
              if($messages != null)
               {
				   $messages = $messages->sortByDesc('created_at');	
			  
				  foreach($messages as $m)
				  {
					  $temp = $this->getFmail($m->id);
					  array_push($ret,$temp);
				  }
               }                         
                                  
                return $ret;
           }
		   
		   function getFmail($id)
		   {
			   $ret = [];
			   $m = Fmails::where('id',$id)->first();
			   
			   if($m != null)
               {
				  $temp = [];
				  $temp['id'] = $m->id;
				  $temp['message'] =$m->message;
     			  $temp['date'] = $m->created_at->format("m/d/Y h:i A");
				  $ret = $temp;
               }

               return $ret;			   
		   }
		   
		   function createAttachment($dt)
		   {
			    $ret = Attachments::create([
				   'message_id' => $dt['message_id'],
				   'cid' => $dt['cid'],
				   'ctype' => $dt['ctype'],
				   'filename' => $dt['filename'],
				   'content' => $dt['content'],
				   'checksum' => $dt['checksum'],
				   'size' => $dt['size'],
				]);
				return $ret;
		   }
		   
		   function getAttachments($mid)
           {
           	$ret = [];
			  $atts = Attachments::where('message_id',$mid)->get();
			  
              if($atts != null)
               {
				   $atts = $atts->sortByDesc('created_at');	
			  
				  foreach($atts as $a)
				  {
					  $temp = $this->getAttachment($a->id);
					  array_push($ret,$temp);
				  }
               }                         
                                  
                return $ret;
           }
		   
		   function getAttachment($id)
		   {
			   $ret = [];
			   $a = Attachments::where('id',$id)->first();
			   
			   if($a != null)
               {
				  $temp = [];
				  $temp['id'] = $a->id;
				  $temp['message_id'] = $a->message_id;
				  $temp['cid'] = $a->cid;
				  $temp['ctype'] = $a->ctype;
				  $temp['filename'] = $a->filename;
				  $temp['content'] = $a->content;
				  $temp['checksum'] = $a->checksum;
				  $temp['size'] = $a->size;
     			  $temp['date'] = $a->created_at->format("m/d/Y h:i A");
				  $ret = $temp;
               }

               return $ret;			   
		   }
		   
		   
		   
		  
		   function createMessage($dt)
		   {
			   $ret = Messages::create(['fmail_id' => $dt['fmail_id'], 
                                                      'username' => $dt['username'], 
                                                      'sn' => $dt['sn'], 
                                                      'sa' => $dt['sa'], 
                                                      'subject' => $dt['subject'], 
                                                      'content' => $dt['content'], 
                                                      'label' => $dt['label'], 
                                                      'status' => "unread", 
                                                      ]);
                                                      
                return $ret;
		   }
		   
		   function getMessage($id)
		   {
			   $ret = [];
			   $m = Messages::where('id',$id)->first();
			   
			   if($m != null)
               {
				  $temp = [];
				  $temp['id'] = $m->id;
				  $temp['fmail_id'] = $m->fmail_id;
				  $temp['username'] = $m->username;
				  $temp['sn'] = $m->sn;
				  $temp['sa'] = $m->sa;
				  $temp['content'] = $m->content;
				  $temp['label'] = $m->label;
				  $temp['attachments'] = $this->getAttachments($m->username);
				  $temp['status'] = $m->status;
     			  $temp['date'] = $m->created_at->format("m/d/Y h:i A");
				  $ret = $temp;
               }

               return $ret;			   
		   }
		   
		   function getMessages($username)
           {
           	$ret = [];
			  $messages = Messages::where('username',$username)->get();
			  
              if($messages != null)
               {
				   $messages = $messages->sortByDesc('created_at');	
			  
				  foreach($messages as $m)
				  {
					  $temp = $this->getMessage($m->id);
					  array_push($ret,$temp);
				  }
               }                         
                                  
                return $ret;
           }
		   
		    function parseMessage($fid)
		   {
			   $ret = [];
			   
			   $fm =  $this->helpers->getFmail($fid);
			   
			   if(count($fm) > 0)
			   {
				   $m = json_decode($fm['message'],true);
				   $t = $m['to']; $f = $m['from'];
				   $r = $t['value'][0]; $s = $f['value'][0];
				   $username = explode('@',$r['address']);
				   
				   $u = User::where('username',$username[0])->first();
				   if($u == null)
				   {
					   $ret = ['status' => "nice try"];
				   }
				   else
				   {
					   //Email
				       $msg = [];
				       $msg['content'] = $m['textAsHtml'];
				       $msg['subject'] = $m['subject'];
				       $msg['fmail_id'] = $fid;
				       $msg['username'] = $username[0];
				       $msg['sn'] = ($s['name'] == null) ? "" : $s['name'];
				       $msg['sa'] = $s['address'];
				       $msg['status'] = "enabled";
					   $mm = $this->createMessage($msg);
					   
					    //Attachments
					   $fatts = $m['attachments']; $atts = [];
					   
					   foreach($fatts as $ff)
					   {
						   $atts = [];
						   $content = $ff['content'];
						   $atts['message_id'] = $mm->id;
						   $atts['cid'] = $ff['textAsHtml'];
						   $atts['ctype'] = $ff['contentType'];
						   $atts['filename'] = $ff['filename'];
						   $atts['content'] = json_encode($content['data']);
						   $atts['checksum'] = $ff['checksum'];
						   $atts['size'] = $ff['size'];
						   $this->createAttachment($msg);
					   }
					   
					   $ret = ['status' => "ok"];
				   }
			   
				  
				   
			   }
			   
			   return $ret;
		   }
		   
		   
		   function getChatHistory($dt)
		   {
			   $ret = [];
			   
			   if(isset($dt['user_id']) && isset($dt['apt']))
			   {
				   $apt = Apartments::where('apartment_id',$apt)->first();
				   
				   if($apt != null)
				   {
					   $ret = $this->getMessages(['user_id' => $dt['user_id'],'host' => $apt->user_id]);
				   }
			   }
			   
			   return $ret;
		   }
		   
		   function chat($dt)
		   {
			   $ret = null;
			    $apt = Apartments::where('apartment_id',$dt['apartment_id'])->first();
				
				if($apt != null)
				{
					$dt['host'] = $apt->user_id;
					$ret = $this->createMessage($dt);							   
				}
			   return $ret;
		   }
           
           
           function getRandomString($length_of_string) 
           { 
  
              // String of all alphanumeric character 
              $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
              // Shufle the $str_result and returns substring of specified length 
              return substr(str_shuffle($str_result),0, $length_of_string); 
            }
            

		   function createPermission($dt)
		   {
			    $ret = Permissions::where('user_id',$dt['user_id'])
				                ->where('ptag',$dt['ptag'])->first();
				
				if($ret == null)
				{
					$ret = Permissions::create(['user_id' => $dt['user_id'], 
                                             'ptag' => $dt['ptag'],
                                             'granted_by' => $dt['granted_by'],
                                            ]);
				}
			   
                                                      
                return $ret;
		   }
		   
		   function addPermissions($dt)
		   {
			   $ptags = $dt['ptags'];
			   #dd($dt);
			   foreach($ptags as $p)
			   {
				   $this->createPermission([
				           'user_id' => $dt['xf'],
				           'ptag' => $p,
						   'granted_by' => $dt['granted_by']
				   ]);
			   }
			   return "ok";
		   }
		   
		   function getPermission($id)
		   {
			   $ret = [];
			   $p = Permissions::where('id',$id)->first();
			   
			   if($p != null)
               {
				  $temp = [];
				  $temp['id'] = $p->id;
				  $temp['user_id'] = $p->user_id;
				  $temp['ptag'] = $p->ptag;
				  $temp['granted_by'] = User::where('id',$p->granted_by)->first();
				  $temp['date'] = $p->created_at->format("jS F, Y");
     			  $ret = $temp;
               }

               return $ret;			   
		   }
		   
		   function getPermissions($user)
           {
           	$ret = [];
			$ps = Permissions::where('user_id',$user->id)->get();
			  
              if($ps != null)
               {
				   $ps = $ps->sortByDesc('created_at');	
			  
				  foreach($ps as $p)
				  {
					  $temp = $this->getPermission($p->id);
					  array_push($ret,$temp);
				  }
               }                         
                                  
                return $ret;
           }
		   
		   function removePermission($dt)
		   {
			   $ret = "error";
			   
			   $p = Permissions::where('user_id',$dt['xf'])
			                   ->where('ptag',$dt['p'])->first();
			   
			   if($p != null)
               {
				  $p->delete();
				  $ret = "ok";
               }

               return $ret;			   
		   }
		   
		   function hasPermission($user_id,$ps)
		   {
			   $ret = true;
			   /**$pps = Permissions::where('user_id',$user_id)
			                     ->whereIn('ptag',$ps)->get();
			   
			   $hasAllPermissions = true;
			   
			   if($pps != null)
			   {   
				 foreach($ps as $p)
				 {
					$contains = $pps->contains(function($value) use($p){
                                                          return $value->ptag == $p;
                                                      });
                    $hasAllPermissions = $hasAllPermissions && $contains;													  
				 }
				 if($hasAllPermissions) $ret = true;  
			   } 
			   **/
			   return $ret;
		   }
		   
		   
		   
	
	function createSender($data)
           {
			   #dd($data);
			 $ret = null;
			 
			 
				 $ret = Senders::create(['ss' => $data['ss'], 
                                                      'type' => $data['type'], 
                                                      'sp' => $data['sp'], 
                                                      'sec' => $data['sec'], 
                                                      'sa' => $data['sa'], 
                                                      'su' => $data['su'], 
                                                      'current' => $data['current'], 
                                                      'spp' => $data['spp'], 
                                                      'sn' => $data['sn'], 
                                                      'se' => $data['se'], 
                                                      'status' => "enabled", 
                                                      ]);
			  return $ret;
           }

   function getSenders()
   {
	   $ret = [];
	   
	   $senders = Senders::where('id','>',"0")->get();
	   
	   if(!is_null($senders))
	   {
		   foreach($senders as $s)
		   {
		     $temp = $this->getSender($s->id);
		     array_push($ret,$temp);
	       }
	   }
	   
	   return $ret;
   }
   
  
		   
		   
		  function updateSender($data,$user=null)
           {
			   #dd($data);
			 $ret = "error";
			 if($user == null)
			 {
				 $s = Senders::where('id',$data['xf'])->first();
			 }
			 else
			 {
				$s = Senders::where('id',$data['xf'])
			             ->where('user_id',$user->id)->first(); 
			 }
			 
			 
			 if(!is_null($s))
			 {
				 $s->update(['ss' => $data['ss'], 
                                                      'type' => $data['type'], 
                                                      'sp' => $data['sp'], 
                                                      'sec' => $data['sec'], 
                                                      'sa' => $data['sa'], 
                                                      'su' => $data['su'], 
                                                      'spp' => $data['spp'], 
                                                      'sn' => $data['sn'], 
                                                      'se' => $data['se'], 
                                                      'status' => "enabled", 
                                                      ]);
			   $ret = "ok";
			 }
           	
                                                      
                return $ret;
           }

		   function removeSender($xf,$user=null)
           {
			   #dd($data);
			 $ret = "error";
			 if($user == null)
			 {
				 $s = Senders::where('id',$xf)->first();
			 }
			 else
			 {
				$s = Senders::where('id',$xf)
			             ->where('user_id',$user->id)->first(); 
			 }
			 
			 
			 if(!is_null($s))
			 {
				 $s->delete();
			   $ret = "ok";
			 }
           
           }
		   
		   function setAsCurrentSender($id)
		   {
			   $s = Senders::where('id',$id)->first();
			   
			   if($s != null)
			   {
				   $prev = Senders::where('current',"yes")->first();
				   if($prev != null) $prev->update(['current' => "no"]);
				   $s->update(['current' => "yes"]);
			   }
		   }
		   
		   
	   	function createFAQ($data)
	              {
	   			   #dd($data);
	   			 $ret = null;
			 
			 
	   				 $ret = Faqs::create(['tag' => $data['tag'], 
	                                                         'question' => $data['question'], 
	                                                         'answer' => $data['answer']
	                                                         ]);
	   			  return $ret;
	              }

	      function getFAQs()
	      {
	   	   $ret = [];
	   
	   	   $faqs = Faqs::where('id','>',"0")->get();
	   
	   	   if(!is_null($faqs))
	   	   {
	   		   foreach($faqs as $f)
	   		   {
	   		     $temp = $this->getFAQ($f->id);
	   		     array_push($ret,$temp);
	   	       }
	   	   }
	   
	   	   return $ret;
	      }
		  
	 	 function getFAQ($id)
	            {
	            	$ret = [];
	                $f = Faqs::where('id',$id)->first();
 
	               if($f != null)
	                {
                                $temp['id'] = $f->id; 
	                    	$temp['tag'] = $f->tag; 
	                        $temp['question'] = $f->question; 
	                        $temp['answer'] = $f->answer;
	                        $temp['date'] = $f->created_at->format("jS F, Y"); 
	                        $ret = $temp; 
	                }                          
                                                      
	                 return $ret;
	            }
   
  
		   
		   
	   		  function updateFAQ($data)
	              {
	   			   #dd($data);
	   			 $ret = "error";
                 $f = Faqs::where('id',$data['xf'])->first();
			 
			 
	   			 if(!is_null($f))
	   			 {
	   				 $s->update(['tag' => $data['tag'], 
	                                                         'question' => $data['question'], 
	                                                         'answer' => $data['answer']
	                                                         ]);
	   			   $ret = "ok";
	   			 }
           	
                                                      
	                   return $ret;
	              }

	   		   function removeFAQ($xf)
	              {
	   			    #dd($data);
	   			    $ret = "error";
	   			    $f = Faqs::where('id',$data['xf'])->first();
			 
			 
	   			    if(!is_null($f))
	   			    {
	   				  $f->delete();
	   			      $ret = "ok";
	   			    }
           
	              }
				  
		  	   	function createFAQTag($data)
		  	              {
		  	   			   #dd($data);
		  	   			 $ret = null;
			 
			 
		  	   				 $ret = FaqTags::create(['tag' => $data['tag'], 
		  	                                                         'name' => $data['name']
		  	                                                         ]);
		  	   			  return $ret;
		  	              }

		  	      function getFAQTags()
		  	      {
		  	   	   $ret = [];
	   
		  	   	   $tags = FaqTags::where('id','>',"0")->get();
	   
		  	   	   if(!is_null($tags))
		  	   	   {
		  	   		   foreach($tags as $t)
		  	   		   {
		  	   		     $temp = $this->getFAQTag($t->id);
		  	   		     array_push($ret,$temp);
		  	   	       }
		  	   	   }
	   
		  	   	   return $ret;
		  	      }
				  
		 	 	 function getFAQTag($id)
		 	            {
		 	            	$ret = [];
		 	                $t = FaqTags::where('id',$id)->first();
 
		 	               if($t != null)
		 	                {
		 	                    	$temp['tag'] = $t->tag; 
                                                $temp['id'] = $t->id; 
		 	                        $temp['name'] = $t->name; 
		 	                        $temp['date'] = $t->created_at->format("jS F, Y"); 
		 	                        $ret = $temp; 
		 	                }                          
                                                      
		 	                 return $ret;
		 	            }
   
  
		   
		   
		 	   		  function updateFAQTag($data)
		 	              {
		 	   			   #dd($data);
		 	   			 $ret = "error";
		                  $t = FaqTags::where('id',$id)->first();
			 
			 
		 	   			 if(!is_null($t))
		 	   			 {
		 	   				 $t->update(['tag' => $data['tag'], 
		 	                                                         'name' => $data['name']
		 	                                                         ]);
		 	   			   $ret = "ok";
		 	   			 }
           	
                                                      
		 	                   return $ret;
		 	              }

		 	   		   function removeFAQTag($xf)
		 	              {
		 	   			    #dd($data);
		 	   			    $ret = "error";
		 	   			    $t = FaqTags::where('id',$data['xf'])->first();
			 
			 
		 	   			    if(!is_null($f))
		 	   			    {
		 	   				  $t->delete();
		 	   			      $ret = "ok";
		 	   			    }
           
		 	              }
						  
						  function getSiteStats()
		          {
			   $tu = User::where('id','>','0')->count();
			   $tm = Messages::where('id','>','0')->count();
			   
			   $ret = [
			     'total_users' => $tu,
			     'total_messages' => $tm
			   ];
			   
			   return $ret;
		   }
		
		function apiLogin($dt)
        {
        	$ret = ['status' => "error",'msg' => "nothing"];
            $u = User::where([
                      'username' => $dt['u'],
                      'password' => bcrypt($dt['p']),
                      'status'=> "enabled"
                  ])->first();
                  
            if($u != null)
            {
            	$tk = $u->tk;
                if($tk == null || $tk ==  "")
                {
              	$tk = $this->getRandomString(7);
                  $u->update(['tk' => $tk]);
                }
                $ret = ['status' => "ok",'tk' => $tk];
           }
            
           return $ret;       
       }
		
		function apiAuth($dt)
		 	              {
		 	   			    #dd($dt);
		 	   			    $ret = false;
		                    $tk = isset($dt['tk']) ? $req['tk'] : "";
		$u = isset($req['u']) ? $req['u'] : "";
		 	   			    $u = User::where([
                                                'username' => $u,
                                                'tk' => $tk
                                             ])->first(); 
			 
		 	   			    if($u != null)
		 	   			    {
		 	   				  $ret = true;
		 	   			    }   
                             return $ret;       
		 	              }
}
?>
