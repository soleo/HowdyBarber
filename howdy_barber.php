<?php


function getAvailablityByDate($date = '2015-11-25', $barberId = 3613, $serviceId = '9837'){
    // Get cURL resource
    $curl = curl_init();
    $reqUri = "https://handcraftedbarbershop.resurva.com/index/availability?roomId=$barberId&date=$date&serviceId=$serviceId&format=json";
    // Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $reqUri,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36'
    ));
    // Send the request & save response to $resp
    $resp = curl_exec($curl);
    // Close request to clear up some resources
    curl_close($curl);
    return $resp;
}

date_default_timezone_set('America/Chicago'); 
// query next 20 - 30 day range
$startDate = strtotime('+ 20 days');
$endDate  = strtotime('+ 30 days');
$barberId = 3613;
$text_message = ''; 
$notify = 'shaoxinjiang@gmail.com'; 
$availableArray = array();
while($startDate < $endDate) {
    $currentDate = new DateTime();
    $currentDate->setTimestamp($startDate);
    //echo $currentDate->format('Y-m-d');
    
    $json = getAvailablityByDate($currentDate->format('Y-m-d'));
    
   
    $ret = json_decode($json, true);
    if(!empty($ret['startTimes'][$barberId]['startTime'])){
        //print_r($ret);
        foreach ($ret['startTimes'][$barberId]['startTime'] as $time => $details) {
            $availableArray[] = $currentDate->format('Y-m-d') .' '. $time;  
        }
        

    }
    
    sleep(1);
    $startDate = strtotime('+ 1 day', $startDate);
}
$today = new DateTime();
$text_message = implode(', ', $availableArray);
$text_message .= "\r\nCrawled at ";
$text_message .= $today->format('m-d h:m');
echo $text_message;
mail($notify, 'HairCut Note', $text_message);


