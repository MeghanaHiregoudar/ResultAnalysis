<?php
  function test_input($data)
  {
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);

     return $data;
  }
  /**
 * This function is used to encrypt/decrypt data
 */

 function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
/**
 * This function is used to get Client IP
 */

 function get_client_ip()
 {
      /*-----------------------Client IP------------------------------------*/

      if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
      {
        return  $ip=$_SERVER['HTTP_CLIENT_IP'];
      }
       elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
      {
        return  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
      }
       else
      {
        return $ip=$_SERVER['REMOTE_ADDR'];
      }
 }

 function age_calculation($date)
 {
  $bday = new DateTime($date); // Your date of birth
  $today = new Datetime(date('y-m-d'));
  $diff = $today->diff($bday);
  return $diff->y;
 }

 /*---------------Function is used for Number converting to Words-----------------*/

 function convert_number_to_words($number) 
 {
   
   $no = round($number);
  $point = round($number - $no, 2) * 100;
  $hundred = null;
  $digits_1 = strlen($no);
  $i = 0;
  $str = array();
  $words = array('0' => '', '1' => 'One', '2' => 'Two',
   '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
   '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
   '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
   '13' => 'Thirteen', '14' => 'Fourteen',
   '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
   '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
   '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
   '60' => 'Sixty', '70' => 'Seventy',
   '80' => 'Eighty', '90' => 'Ninety');
  $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
  while ($i < $digits_1) {
    $divider = ($i == 2) ? 10 : 100;
    $number = floor($no % $divider);
    $no = floor($no / $divider);
    $i += ($divider == 10) ? 1 : 2;
    if ($number) {
       $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
       $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
       $str [] = ($number < 21) ? $words[$number] .
           " " . $digits[$counter] . $plural . " " . $hundred
           :
           $words[floor($number / 10) * 10]
           . " " . $words[$number % 10] . " "
           . $digits[$counter] . $plural . " " . $hundred;
    } else $str[] = null;
 }
 $str = array_reverse($str);
 $result = implode('', $str);
 $points = ($point) ?
   "." . $words[$point / 10] . " " . 
         $words[$point = $point % 10] : '';
 $string=$result; //. "Rupees  " . $points . " Paise";
   return $string;
}
?>