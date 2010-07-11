<?php
//FTShorten Class Adapter
$error = false;
$result = '';
if (array_key_exists($service, $this->supported)){
    $options = $this->my_options();
        
    $ca = new FTShorten();
    $ca->url = $url;
    $ca->pingfmapi = 'f51e33510d3cbe2ff1e16a4a4897f099';
    $ca->service = $service;

    if (!$user && in_array($service, $this->authuser)){
        $ca->name = htmlentities($options['apiuser_'.$service], ENT_QUOTES); 
        if ($ca->name == '' && in_array($service, $this->requser)){
            $error = true;
        }
    }else{
		$ca->name = $user;
	}
    if (!$key && in_array($service, $this->authkey)){
        $ca->apikey = htmlentities($options['apikey_'.$service], ENT_QUOTES);
        if ($ca->apikey == '' && in_array($service, $this->reqkey)){
            $error = true;
        }
    }else{
		$ca->apikey = $key;
	}  
    if ($error){
        $result = '';
    }else{
        $result = $ca->shorturl();
    }
}
return $result;
?>