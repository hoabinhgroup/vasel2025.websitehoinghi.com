<?php namespace Modules\Payment\Libraries;
class Onepay
{
  protected $_paymentCardInfo;
  protected $_config;
  
  public function __construct($paymentCardInfo)
  {

    $this->_paymentCardInfo = $paymentCardInfo;
    $this->_config = config("payment.info")[$paymentCardInfo];
  }


  public function buildPaymentLink($orderInfo, $merchTxnRef, $amount, $returnUrl) 
  {
    $params = [
      'Title' => 'VPC 3-Party',
      'secure_secret' => $this->_config['vpc_SecureHash'],
      'virtualPaymentClientURL' => $this->_config['vpc_url'],
      'vpc_Merchant' => $this->_config['vpc_Merchant'],
      'vpc_AccessCode' => $this->_config['vpc_AccessCode'],
      'vpc_MerchTxnRef' =>  $merchTxnRef,
      'vpc_OrderInfo' => $orderInfo,
      'vpc_Amount' => $amount * 100,
      'vpc_ReturnURL' => $returnUrl,
      'vpc_Version' => '2',
      'vpc_Command' => 'pay',
      'vpc_Locale' => 'vn',
    ];
    
     $SECURE_SECRET = $params['secure_secret'];
      
      // add the start of the vpcURL querystring parameters
      $vpcURL = $params["virtualPaymentClientURL"] . "?";
      

      unset($params["virtualPaymentClientURL"]); 
      
  
      $params['AgainLink']=urlencode($_SERVER['HTTP_REFERER']);
     
      $md5HashData = "";
      
      ksort ($params);
      
      // set a parameter to show the first pair in the URL
      $appendAmp = 0;
      
      foreach($params as $key => $value) {
      
        // create the md5 input and URL leaving out any fields that have no value
        if (strlen($value) > 0) {
          
          // this ensures the first paramter of the URL is preceded by the '?' char
          if ($appendAmp == 0) {
            $vpcURL .= urlencode($key) . '=' . urlencode($value);
            $appendAmp = 1;
          } else {
            $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
          }
          //$md5HashData .= $value; sử dụng cả tên và giá trị tham số để mã hóa
          if ((strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
            $md5HashData .= $key . "=" . $value . "&";
          }
        }
      }
      //xóa ký tự & ở thừa ở cuối chuỗi dữ liệu mã hóa
      $md5HashData = rtrim($md5HashData, "&");
      // Create the secure hash and append it to the Virtual Payment Client Data if
      // the merchant secret has been provided.
      if (strlen($SECURE_SECRET) > 0) {
        //$vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
        // Thay hàm mã hóa dữ liệu
        $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',$SECURE_SECRET)));
      }
    
 
     return $vpcURL;
  }
  
  public function buildCustomLink($params = array()) {
    $SECURE_SECRET = $params['secure_secret'];
    
    // add the start of the vpcURL querystring parameters
    $vpcURL = $params["virtualPaymentClientURL"] . "?";
    
    // Remove the Virtual Payment Client URL from the parameter hash as we 
    // do not want to send these fields to the Virtual Payment Client.
    unset($params["virtualPaymentClientURL"]); 
    
    // The URL link for the receipt to do another transaction.
    // Note: This is ONLY used for this example and is not required for 
    // production code. You would hard code your own URL into your application.
    
    // Get and URL Encode the AgainLink. Add the AgainLink to the array
    // Shows how a user field (such as application SessionIDs) could be added
    $params['AgainLink']=urlencode($_SERVER['HTTP_REFERER']);
    //$params['AgainLink']=urlencode($_SERVER['HTTP_REFERER']);
    // Create the request to the Virtual Payment Client which is a URL encoded GET
    // request. Since we are looping through all the data we may as well sort it in
    // case we want to create a secure hash and add it to the VPC data if the
    // merchant secret has been provided.
    //$md5HashData = $SECURE_SECRET; Khởi tạo chuỗi dữ liệu mã hóa trống
    $md5HashData = "";
    
    ksort ($params);
    
    // set a parameter to show the first pair in the URL
    $appendAmp = 0;
    
    foreach($params as $key => $value) {
    
      // create the md5 input and URL leaving out any fields that have no value
      if (strlen($value) > 0) {
        
        // this ensures the first paramter of the URL is preceded by the '?' char
        if ($appendAmp == 0) {
          $vpcURL .= urlencode($key) . '=' . urlencode($value);
          $appendAmp = 1;
        } else {
          $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
        }
        //$md5HashData .= $value; sử dụng cả tên và giá trị tham số để mã hóa
        if ((strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
          $md5HashData .= $key . "=" . $value . "&";
        }
      }
    }
    //xóa ký tự & ở thừa ở cuối chuỗi dữ liệu mã hóa
    $md5HashData = rtrim($md5HashData, "&");
    // Create the secure hash and append it to the Virtual Payment Client Data if
    // the merchant secret has been provided.
    if (strlen($SECURE_SECRET) > 0) {
      //$vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
      // Thay hàm mã hóa dữ liệu
      $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',$SECURE_SECRET)));
    }


    // FINISH TRANSACTION - Redirect the customers using the Digital Order
    // ===================================================================
   // header("Location: ".$vpcURL);
   return $vpcURL;
  }
    
  public function getResponseCode($request)
  {
    
    $SECURE_SECRET = $this->_config['vpc_SecureHash'];
    // get and remove the vpc_TxnResponseCode code from the response fields as we
    // do not want to include this field in the hash calculation
    $vpc_Txn_Secure_Hash = $request["vpc_SecureHash"];
    $vpc_MerchTxnRef = $request["vpc_MerchTxnRef"];
    //$vpc_AcqResponseCode = $request["vpc_AcqResponseCode"];
    unset($request["vpc_SecureHash"]);
    // set a flag to indicate if hash has been validated
    $errorExists = false;
    
    if (strlen($SECURE_SECRET) > 0 && $request["vpc_TxnResponseCode"] != "7" && $request["vpc_TxnResponseCode"] != "No Value Returned") {
    
        ksort($request);
        //$md5HashData = $SECURE_SECRET;
        //khởi tạo chuỗi mã hóa rỗng
        $md5HashData = "";
        // sort all the incoming vpc response fields and leave out any with no value
        foreach ($request as $key => $value) {
    //        if ($key != "vpc_SecureHash" or strlen($value) > 0) {
    //            $md5HashData .= $value;
    //        }
    //      chỉ lấy các tham số bắt đầu bằng "vpc_" hoặc "user_" và khác trống và không phải chuỗi hash code trả về
            if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
            $md5HashData .= $key . "=" . $value . "&";
        }
        }
    //  Xóa dấu & thừa cuối chuỗi dữ liệu
        $md5HashData = rtrim($md5HashData, "&");
    
    //    if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper ( md5 ( $md5HashData ) )) {
    //    Thay hàm tạo chuỗi mã hóa
      if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',$SECURE_SECRET)))) {
            // Secure Hash validation succeeded, add a data field to be displayed
            // later.
            $hashValidated = "CORRECT";
        } else {
            // Secure Hash validation failed, add a data field to be displayed
            // later.
            $hashValidated = "INVALID HASH";
        }
    } else {
        // Secure Hash was not validated, add a data field to be displayed later.
        $hashValidated = "INVALID HASH";
    }
    
    // Define Variables
    // ----------------
    // Extract the available receipt fields from the VPC Response
    // If not present then let the value be equal to 'No Value Returned'
    
    // Standard Receipt Data
    $amount = $this->null2unknown($request["vpc_Amount"]);
    $locale = $this->null2unknown($request["vpc_Locale"]);
    $batchNo = $request["vpc_BatchNo"] ?? null;
    $command = $this->null2unknown($request["vpc_Command"]);
    $message = $this->null2unknown($request["vpc_Message"]);
    $version = $this->null2unknown($request["vpc_Version"]);
    $cardType = $request["vpc_Card"] ?? null;
    $orderInfo = $this->null2unknown($request["vpc_OrderInfo"]);
    $receiptNo = $request["vpc_ReceiptNo"] ?? null;
    $merchantID = $this->null2unknown($request["vpc_Merchant"]);
    //$authorizeID = $this->null2unknown($request["vpc_AuthorizeId"]);
    $merchTxnRef = $this->null2unknown($request["vpc_MerchTxnRef"]);
    $transactionNo = $request["vpc_TransactionNo"] ?? null;
    $acqResponseCode = $request["vpc_AcqResponseCode"] ?? null;
    $txnResponseCode = $this->null2unknown($request["vpc_TxnResponseCode"]);
    // 3-D Secure Data
    $verType = array_key_exists("vpc_VerType", $request) ? $request["vpc_VerType"] : "No Value Returned";
    $verStatus = array_key_exists("vpc_VerStatus", $request) ? $request["vpc_VerStatus"] : "No Value Returned";
    $token = array_key_exists("vpc_VerToken", $request) ? $request["vpc_VerToken"] : "No Value Returned";
    $verSecurLevel = array_key_exists("vpc_VerSecurityLevel", $request) ? $request["vpc_VerSecurityLevel"] : "No Value Returned";
    $enrolled = array_key_exists("vpc_3DSenrolled", $request) ? $request["vpc_3DSenrolled"] : "No Value Returned";
    $xid = array_key_exists("vpc_3DSXID", $request) ? $request["vpc_3DSXID"] : "No Value Returned";
    $acqECI = array_key_exists("vpc_3DSECI", $request) ? $request["vpc_3DSECI"] : "No Value Returned";
    $authStatus = array_key_exists("vpc_3DSstatus", $request) ? $request["vpc_3DSstatus"] : "No Value Returned";
    
    // *******************
    // END OF MAIN PROGRAM
    // *******************
    
    // FINISH TRANSACTION - Process the VPC Response Data
    // =====================================================
    // For the purposes of demonstration, we simply display the Result fields on a
    // web page.
    
    // Show 'Error' in title if an error condition
    $errorTxt = "";
    
    // Show this page as an error page if vpc_TxnResponseCode equals '7'
    if ($txnResponseCode == "7" || $txnResponseCode == "No Value Returned" || $errorExists) {
        $errorTxt = "Error ";
    }
    
    // This is the display title for 'Receipt' page 
    $title = $request["Title"];
    
    // The URL link for the receipt to do another transaction.
    // Note: This is ONLY used for this example and is not required for 
    // production code. You would hard code your own URL into your application
    // to allow customers to try another transaction.
    //TK//$againLink = URLDecode($request["AgainLink"]);
    
    
    $transStatus = "";
    if($hashValidated=="CORRECT" && $txnResponseCode=="0"){
      $transStatus = "Giao dịch thành công";
      return 0;
    }elseif ($hashValidated=="INVALID HASH" && $txnResponseCode=="0"){
      $transStatus = "Giao dịch Pendding";
      return 2;
    }else {
      $transStatus = "Giao dịch thất bại";
      return $txnResponseCode;
    }
    
    return $txnResponseCode;
  }
  
 public function getResponseDescription($responseCode) {
 
   switch ($responseCode) {
     case "0" :
       $result = "successful";
       break;
     case "1" :
       $result = "Bank Declined";
       break;
     case "2" :
       $result = "pending";
       break;
     case "3" :
       $result = "Mã đơn vị không tồn tại - Merchant not exist";
       break;
     case "4" :
       $result = "Không đúng access code - Invalid access code";
       break;
     case "5" :
       $result = "Số tiền không hợp lệ - Invalid amount";
       break;
     case "6" :
       $result = "Mã tiền tệ không tồn tại - Invalid currency code";
       break;
     case "7" :
       $result = "Lỗi không xác định - Unspecified Failure ";
       break;
     case "8" :
       $result = "Invalid card Number";
       break;
     case "9" :
       $result = "Invalid card name";
       break;
     case "10" :
       $result = "Expired Card";
       break;
     case "11" :
       $result = "Card Not Registed Service(internet banking)";
       break;
     case "12" :
       $result = "Invalid card date";
       break;
     case "13" :
       $result = "Exist Amount";
       break;
     case "21" :
       $result = "Insufficient fund";
       break;
     case "99" :
       $result = "cancelled";
       break;
     default :
       $result = "failed";
   }
   return $result;
 }
  
  //  -----------------------------------------------------------------------------
  // If input is null, returns string "No Value Returned", else returns input
  public function null2unknown($data) {
   // return ($data == "") ? "No Value Returned" : $data;
     if(!isset($data)){
       return null;
     }else{
       return $data;
     }
  }
  //  ----------------------------------------------------------------------------

}
