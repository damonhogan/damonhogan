<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Object\ProPayApi;
use Application\Object\ProtectPayApi;

class IndexController extends AbstractActionController
{


    public function indexAction()
    {

        // regular merchant
        /*
        $data = [
            "SourceEmail" => "damonhogan@juno.com",
            "FirstName" => "John",
            "MiddleInitial" => "Q",
            "LastName" => "Test",
            "BusinessLegalName" => "ProPay Partner",
            "DoingBusinessAs" => "PPA",
            "DateOfBirth" => "1/19/1997",
            "DayPhone" => "8601233421",
            "EveningPhone" => "8601233421",
            "SocialSecurityNumber" => "111111111",
            "ExternalId" => "3212157",
            "Tier" => "", // "Merchant"
            "PhonePIN" => "1234",
            "Address" => [
                "ApartmentNumber" => null,
                "Address1" => "100 Main Street",
                "Address2" => null,
                "City" => "Rocky Hill",
                "State" => "CT",
                "Country" => "USA",
                "Zip" => "06067"
            ],
            "BankAccount" => [
                "AccountCountryCode" => "USA",
                "AccountOwnershipType" => "Personal",
                "AccountType" => "C",
                "BankAccountNumber" => "123456789",
                "BankName" => "Wells Fargo",
                "RoutingNumber" => "102000076"
            ],
            "BusinessAddress" => [
                "Address1" => "101 Main Street",
                "Address2" => "Ste. 200",
                "City" => "Rocky Hill",
                "State" => "CT",
                "Country" => "USA",
                "Zip" => "06067"
            ]
        ];

        */

        /**
         * The cert string and setTermId would normally be in a config or in your database
         *  This call normally yields return json data for the account created like so
         * {"AccountNumber" => 32299999,"Password" => "$#GD!ADXv2","SourceEmail" => "someuser@somedomain.com","Status":"00","Tier":"Platinum"}
         */

        /*
        $proPayAPI = new ProPayApi();
        $result = $proPayAPI->setCertStr('TiAuNrNwEjRnScCaE9RcTcS7ReI9NG')
            ->setTermId('ReI9NG')
            ->setSignupData($data)
            ->processSignup()
            ->getSignupInfo();
        */

        //TODO: business merchant. EIN....

        /*
        $data = ["SourceEmail" => "damonhogan@juno.com",
            "BusinessLegalName" => "D ProPay Partner",
            "DoingBusinessAs" => "FPPA",
            "DayPhone" => "8601233421",
            "Tier" => "Business",
            "EIN" => "723456",
            "CurrencyCode" => "USD",
            "BankAccount" => [
                "AccountCountryCode" => "USA",
                "AccountOwnershipType" => "Personal",
                "AccountType" => "C",
                "BankAccountNumber" => "023456789",
                "BankName" => "Wells Fargo",
                "RoutingNumber" => "102000076"
            ],
            "BusinessAddress" => [
                "Address1" => "101 Main Street",
                "Address2" => "Ste. 200",
                "City" => "Rocky Hill",
                "State" => "CT",
                "Country" => "USA",
                "Zip" => "06067"]
        ];

        */


        /**
         * Business signup example
         * The cert string and setTermId would normally be in a config or in your database
         *  This call normally yields return json data for the account created like so
         */

        /*
        $proPayAPI = new ProPayApi();
        $result = $proPayAPI->setCertStr('TiAuNrNwEjRnScCaE9RcTcS7ReI9NG')
            ->setTermId('ReI9NG')
            ->setSignupData($data)
            ->processSignup()
            ->getSignupInfo();
        */

        /*
        $data = [
            "amount" => 100,
            "invNum" => "",
            "recAccntNum" => "32291226"
        ];

        $proPayAPI = new ProPayApi();
        $result = $proPayAPI->setCertStr('TiAuNrNwEjRnScCaE9RcTcS7ReI9NG')
            ->setTermId('ReI9NG')
            ->setPropayToPropayTransferData($data)
            ->processProPayToProPay()
            ->getProPayToPropayTransferInfo();

        */
        //current response
        //'{"AccountNumber":32291150,"Password":"!#GD$ADXv2","SourceEmail":"damonhogan2@icloud.com","Status":"00","Tier":"Platinum"}'
        //{"AccountNumber":32291226,"Password":"LMv%QPL!n8","SourceEmail":"damonhogan@juno.com","Status":"00","Tier":"Platinum"}'

        /* protectPay Api hosted transactions */

        /*

         $data = [
            "PayerAccountId" => 2498355927655035,
            "MerchantProfileId" => null,
            "Amount" => 100,
            "CurrencyCode" => "USD",
            "InvoiceNumber" => "Test Invoice",
            "Comment1" => "Test Comment 1",
            "Comment2" => "Test comment 2",
            "CardHolderNameRequirementType" => 1,
            "SecurityCodeRequirementType" => 1,
            "AvsRequirementType" => 1,
            "AuthOnly" => true,
            "ProcessCard" => true,
            "StoreCard" => true,
            "OnlyStoreCardOnSuccessfulProcess" => true,
            "CssUrl" => "https://protectpaytest.propay.com/hpp/css/pmi.css",
            "Address1" => "123 ABC St",
            "Address2" => "Apt A",
            "City" => "Faloola",
            "Country" => "USA",
            "Description" => "My Visa",
            "Name" => "John Smith",
            "State" => "UT",
            "ZipCode" => "12345",
            "BillerIdentityId" => null,
            "CreationDate" => null,
            "HostedTransactionIdentifier" => null,
            "PaymentTypeId" => "0",
            "Protected" => false
        ];

        $protectPayAPI = new ProtectPayApi();
        $result = $protectPayAPI->setCertStr('TiAuNrNwEjRnScCaE9RcTcS7ReI9NG')
            ->setTermId('ReI9NG')
            ->setHostedTransactionData($data)
            ->createHostedTransaction()
            ->getCreatedHostedTransactionInfo();
        */

        /*
        $protectPayAPI = new ProtectPayApi();
        $result = $protectPayAPI->setCertStr('TiAuNrNwEjRnScCaE9RcTcS7ReI9NG')
            ->setTermId('ReI9NG')
            ->setGetHostedTransactionData("3c2d361a-23a7-4ca1-9c4d-4c18e1af7ad1")
            ->getHostedTransaction()
            ->getHostedTransactionInfo();
        */

        /*
        $data = [
            "accountNum" => 123456,
            "recAccntNum" => 987654,
            "amount" => 100,
            "transNum" => 2,
            "invNum" => "Invoice",
            "comment1" => "Test Comments",
            "comment2" => "Test Comments2"
        ];

        $proPayAPI = new ProPayApi();
        $result = $proPayAPI->setCertStr('TiAuNrNwEjRnScCaE9RcTcS7ReI9NG')
            ->setTermId('ReI9NG')
            ->setTimedPullData($data)
            ->processTimedPull()
            ->getTimedPullInfo();

        */

        /*

        $data = [
            "Name" => "John Smith",
            "EmailAddress" => "email@email.com",
            "ExternalId1" => "CustomerNumber12",
            "ExternalId2" => "234567"
        ];

        $protectPayAPI = new ProtectPayApi();

        $result = $protectPayAPI->setBillerId('2781086379225246')
            ->setAuthToken('16dfe8d7-889b-4380-925f-9c2c6ea4d930')
            ->setCreatePayerIdData($data)
            ->createPayerId()
            ->getCreatePayerIdInfo();

        $payerExternalAccountId = '8924157370851397';

        $paymentMethodId ='06f97670-48c2-4679-93fc-d61771d410f9';

        $merchantProfileId = '3391';

        $protectPayAPI = new ProtectPayApi();

        $result = $protectPayAPI->setBillerId('2781086379225246')
            ->setAuthToken('16dfe8d7-889b-4380-925f-9c2c6ea4d930')
            ->setCreatePayerIdData($data)
            ->createPayerId()
            ->getCreatePayerIdInfo();
        */

        /*

        $data = [
            "PaymentMethodId" => "06f97670-48c2-4679-93fc-d61771d410f9",
            "IsRecurringPayment" => false,

            "CreditCardOverrides" =>
                [
                    "FullName" => "Test User",
                    "ExpirationDate" => "1014",
                    "CVV" => "999",
                    "Billing" =>
                        [
                            "Address1" => "3400 N Ashton Blvd",
                            "Address2" => "Suite 200",
                            "Address3" => "",
                            "City" => "Lehi",
                            "State" => "UT",
                            "ZipCode" => "84043",
                            "Country" => "USA",
                            "TelephoneNumber" => "8012223333",
                            "Email" => "test@user.com"
                        ]
                ],
            "AchOverrides" => null,
            "PayerOverrides" =>
                [
                    "IpAddress" => "127.0.0.1"
                ],
            "MerchantProfileId" => "3351",
            "PayerAccountId" => "8924157370851397",
            "Amount" => 300,
            "CurrencyCode" => "USD",
            "Invoice" => "Test Invoice",
            "Comment1" => "Authorize Comment 1",
            "Comment2" => "Authorize Comment 2",
            "IsDebtRepayment" => "true"
        ];

        $protectPayAPI = new ProtectPayApi();

        $result = $protectPayAPI->setBillerId('2781086379225246')
            ->setAuthToken('16dfe8d7-889b-4380-925f-9c2c6ea4d930')
            ->setPaymentMethodTransactionData($data)
            ->processPaymentMethodTransaction('8924157370851397')
            ->getPaymentMethodTransactionInfo();

        */

        $data = [
            "OriginalTransactionId" => "2",
            "TransactionHistoryId" => 0,
            "MerchantProfileId" => null,
            "Comment1" => "Void Comment 1",
            "Comment2" => "Void Comment 2"
        ];

        $protectPayAPI = new ProtectPayApi();

        $result = $protectPayAPI->setBillerId('2781086379225246')
            ->setAuthToken('16dfe8d7-889b-4380-925f-9c2c6ea4d930')
            ->setPaymentMethodTransactionVoidData($data)
            ->processPaymentMethodTransactionVoid()
            ->getPaymentMethodTransactionVoidInfo();

        return new ViewModel(['result' => $result]);



    }

}