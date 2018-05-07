<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Paypal_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function payment(){
        $req   =  'cmd=_notify-validate'  ;
        $log = "";
        date_default_timezone_set('Asia/Hong_Kong');
        $time = date('Y-m-d H:m:s');
        $timenow = $time." -Paypal";

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode ('=', $keyval);
            if (count($keyval) == 2)
            { $myPost[$keyval[0]] = urldecode($keyval[1]); }
        }
// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
        $req = 'cmd=_notify-validate';
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }
// Step 2: POST IPN data back to PayPal to validate
        $ch = curl_init('https://ipnpb.sandbox.paypal.com/cgi-bin/webscr'); //https://ipnpb.paypal.com/cgi-bin/webscr
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //sandbox =0;  paypal =1 but need ssl
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
// In wamp-like environments that do not come bundled with root authority certificates,
// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set
// the directory path of the certificate as shown below:
        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
        if ( !($res = curl_exec($ch)) ) {
            // error_log("Got " . curl_error($ch) . " when processing IPN data");
            $log = curl_error($ch);
            curl_close($ch);
            exit;
        }
        curl_close($ch);
// inspect IPN validation result and act accordingly
        if (strcmp ($res, "VERIFIED") == 0) {
            // The IPN is verified, process it:
            // check whether the payment_status is Completed
            // check that txn_id has not been previously processed
            // check that receiver_email is your Primary PayPal email
            // check that payment_amount/payment_currency are correct
            // process the notification
            // assign posted variables to local variables
            $item_name = $_POST['item_name'];
            $payment_status = $_POST['payment_status'];
            $payment_amount = $_POST['mc_gross'];
            $payment_currency = $_POST['mc_currency'];
            $txn_id = $_POST['txn_id'];
            $receiver_email = $_POST['receiver_email'];
            $payer_email = $_POST['payer_email'];
            $custom = $_POST['custom'];
            $custom_data = (explode("dfo31@!)#83lv=1-23",$custom)); // 0=email,1=username,2=idcard,3=password
            $custom_name = $custom_data[1];
            $custom_idcard = $custom_data[2];
            $custom_psw = $custom_data[3];
            // IPN message values depend upon the type of notification sent.
            // To loop through the &_POST array and print the NV pairs to the screen:
            foreach ($_POST as $key => $value) {
                echo $key . " = " . $value . "<br>";
            }
            if ($payment_status == 'Completed') {
                $txn_data = array(
                    'txn_id'=> $txn_id,
                    'item_name'=> $item_name,
                    'payment_status'=> $payment_status,
                    'payment_amount'=> $payment_amount,
                    'payment_currency'=>$payment_currency,
                    'payer_email'=> $payer_email,
                    'payer_name'=> $custom_name,
                    'pay_time'=> $time
                );

                $sign = array(
                    "username" => $custom_name,
                    "email" => $payer_email,
                    "idcard" => $custom_idcard,
                    "password" => $custom_psw
                );

                //CI事务
                $this->db->trans_start();
                $this->db->set($sign);
                $this->db->insert('medical');
                $this->db->set($txn_data);
                $this->db->insert('paypal_list');
                $this->db->trans_complete();

                $log = "$item_name" .  " ". "$custom_data[1]" . " " . "$payment_status" . " " . "$payment_amount" . " " . "$payment_currency". " " . "$txn_id" . " " . "$receiver_email" . " " . "$payer_email";

            }
            else
            {
                $log ='TransactionID has been previously processed';
            }
        }

        else if (strcmp ($res, "INVALID") == 0) {
            // IPN invalid, log for manual investigation
            echo "The response from IPN was: <b>" .$res ."</b>";
            $log = "The response from IPN was: <b>" .$res;
        }
        write_file("application/logs/paypal_log.txt",$log." ".$timenow."\r\n","a+");
        header("HTTP/1.1 200 OK");
    }
}