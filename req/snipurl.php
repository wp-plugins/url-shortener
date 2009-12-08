<?php
/*
*The following code in this file was obtained from the SnipURL API Documentation page.
*/

// REQUIRED FIELDS
$sniplink  = $url;  			// THE URL TO BE SNIPPED
$snipuser  = $user;            	// YOUR USER ID REQUIRED
$snipapi   = $key;               	// FIND IN YOUR "SETTINGS" PAGE

// OPTIONAL FIELDS
$snipnick   = '';            			// MEANINGFUL NICKNAME FOR SNIPURL
$sniptitle  = '';  					// TITLE IF ANY
$snippk     = '';                      	// PRIVATE KEY IF ANY
$snipowner  = '';                      	// IF THE SNIP OWNER IS SOMEONE ELSE
$snipformat = 'simple';                	// DEFAULT RESPONSE IS IN XML, SEND "simple"
                                       	// FOR JUST THE SNIPURL 
$snipformat_includepk = "";            	// SET TO "Y" IF YOU WANT THE PRIVATE KEY
                                       	// RETURNED IN THE SNIPURL ALONG WITH THE ALIAS                                      

//----------------------------------
// NO NEED TO EDIT BEYOND THIS POINT
//----------------------------------
$URL        = $urltoget;
$sniplink   = rawurlencode($sniplink);
$snipnick   = rawurlencode($snipnick);
$sniptitle  = rawurlencode($sniptitle);

// POSTFIELD
$postfield =  'sniplink='  . $sniplink  . '&' .
              'snipnick='  . $snipnick  . '&' .
              'snipuser='  . $snipuser  . '&' .
              'snipapi='   . $snipapi   . '&' .
              'sniptitle=' . $sniptitle . '&' .
              'snipowner=' . $snipowner . '&' .
              'snipformat='. $snipformat. '&' .
              'snippk='    . $snippk   
  ;
       
$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_URL, $URL);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfield);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);
?>