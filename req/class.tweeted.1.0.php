<?php 
/*
 * Simple Status Update Class for Twitter
 * Available at 
 * @author Gerald Yeo <contact@fusedthought.com>
 * @version 1.0
 * @package class.Tweeted
 */
if (!class_exists('tweeted')){
	class tweeted {
		public $user, $pass, $msg, $url;
		protected $headers, $useragent;
		
		public function validstatus($link, $themsg){
			$urlcount = strlen($link);
			$limit = 139 - $urlcount;
			if (strlen($themsg) > $limit){
				$themsg = substr($themsg, 0, $limit - 3);
				$postfield = 'status='.$themsg.'... '.$link;
			}else{
				$postfield = 'status='.$themsg.' '.$link;
			}
			return $postfield;
		}
		
		public function updatestatus(){
			$headers = array('X-Twitter-Client:','X-Twitter-Client-Version: 1.0','X-Twitter-Client-URL:');
			$useragent='tweeted-class/1.0 - To report abuse, contact ' . $_SERVER["SERVER_ADMIN"];
			$api = "http://twitter.com/statuses/update.xml";
			
			$link = $this->url;
			$themsg = $this->msg;
			
			$postfield = $this->validstatus($link, $themsg);
			
			$result = $this->openurl($api, $postfield, $useragent);
			return $result;
		}//end update
	
		protected function openurl($api, $postfield, $useragent = false, $headers = false) {
			if (function_exists('curl_init')) {
				$ch = curl_init($api);
				curl_setopt($ch, CURLOPT_URL, $api);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
				//curl_setopt($ch, CURLOPT_HEADER, $headers);	
				curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_USERPWD, $this->user.':'.$this->pass );
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postfield);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
				$result = curl_exec($ch);
				curl_close($ch);
				return $result;	
			}			
		}//end fx open url		
	}
} //end check

?>
