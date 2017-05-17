<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	
	
    public function indexAction()
    {
		 /**
		  * This would mormally be in a config or in your dataase
		  */  
         private $_certString = '';
         
         
         // regular merchant
         $data = [
            "SourceEmail" => "damonhogan2@icloud.com",
            "FirstName" => "John",
            "MiddleInitial"=> "Q",
            "LastName"=> "Test",
            "BusinessLegalName"=> "ProPay Partner",
            "DoingBusinessAs"=> "PPA",
            "DateOfBirth"=> "1/19/1997",
            "DayPhone"=> "8601233421",
            "EveningPhone"=> "8601233421",
            "SocialSecurityNumber"=> "111111111",
            "ExternalId"=> "2212157",
            "Tier"=> "", // "Merchant"
            "PhonePIN"=> "1234",
            "Address"=> [
                "ApartmentNumber"=> null,
                "Address1"=> "100 Main Street",
                "Address2"=> null,
                "City"=> "Rocky Hill",
                "State"=> "CT",
                "Country"=> "USA",
                "Zip"=> "06067"
            ],
            "BankAccount" => [
                "AccountCountryCode"=>"USA",
                "AccountOwnershipType"=>"Personal",
                "AccountType"=>"C",
                "BankAccountNumber"=>"123456789",
                "BankName"=>"Wells Fargo",
                "RoutingNumber"=>"102000076"
            ],
            "BusinessAddress"=> [
                "Address1"=> "101 Main Street",
                "Address2"=> "Ste. 200",
                "City"=> "Rocky Hill",
                "State"=> "CT",
                "Country"=> "USA",
                "Zip"=> "06067"
            ]
        ];
        
        //TODO: business merchant. EIN....

       

        $authCode = 'TXlUZXJtSWQ6TXlDZXJ0U3Ry';
        $data_string = json_encode($data);

        $ch = curl_init('https://xmltestapi.propay.com/ProPayAPI/signup');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getCert()....  'TiAuNrNwEjRnScCaE9RcTcS7ReI9NG:ReI9NG');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
        ));

        $result = curl_exec($ch);
        return new ViewModel(['result'=>$result]);


        //current response
        //'{"AccountNumber":32291150,"Password":"!#GD$ADXv2","SourceEmail":"damonhogan2@icloud.com","Status":"00","Tier":"Platinum"}'
    }
    
    public function getCert() {
	  return $this->_certString;	
    }
