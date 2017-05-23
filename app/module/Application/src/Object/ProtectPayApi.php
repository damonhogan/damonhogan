<?php

namespace Application\Object;

class ProtectPayApi {

    /* credentials that would normally be set from database values or a config value */
    private $_billerId;
    private $_authToken;

    /* for creating hosted transactions */
    private $_createHostedTransactionData;
    private $_createdHostedTransactionInfo;

    /* for getting a hosted transaction */
    private $_getHostedTransactionData;
    private $_getHostedTransactionInfo;

    /* for creating payer ID */
    private $_createPayerIdData;
    private $_createPayerIdInfo;

    /* for processing a payment method transaction */
    private $_paymentMethodTransactionData;
    private $_paymentMethodTransactionInfo;

    /* for processing a payment method transaction void */
    private $_paymentMethodTransactionVoidData;
    private $_paymentMethodTransactionVoidInfo;




    /**
     * @param string $billerId
     * @return $this
     */
    public function setBillerId($billerId) {
        $this->_billerId = $billerId;
        return $this;
    }

    /**
     * @param string $authToken
     * @return $this
     */
    public function setAuthToken($authToken) {
        $this->_authToken = $authToken;
        return $this;
    }


    /**
     * @return string
     */
    private function _getAuth() {
        return $this->_billerId . ':' . $this->_authToken;
    }

    /**
     * Created the hosted transaction
     * @return $this
     * _createdHostedTransactionInfo contains a json string like this
     * {
           "HostedTransactionIdentifier":"f1549c53-e499-476d-84cc-93f99586505d",
          "Result":
          {
              "ResultValue":"SUCCESS",
              "ResultCode":"00",
              "ResultMessage":""
          }
       }
     */
    public function createHostedTransaction() {
        $data_string = json_encode($this->_createHostedTransactionData);

        $ch = curl_init('https://xmltestapi.propay.com/protectpay/hostedtransactions');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->_getAuth());
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));

        $this->_createdHostedTransactionInfo = curl_exec($ch);
        return $this;
    }

    /**
     * Creates a payer id
     * @return $this
     */
    public function createPayerId() {
        $data_string = json_encode($this->_createPayerIdData);

        $ch = curl_init('https://xmltestapi.propay.com/ProtectPay/Payers');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->_getAuth());
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));

        $this->_createPayerIdInfo = curl_exec($ch);
        return $this;
    }

    /**
     * @return $this
     */
    public function processPaymentMethodTransaction($payerExternalAccountId) {
        $data_string = json_encode($this->_paymentMethodTransactionData);

        $ch = curl_init('https://xmltestapi.propay.com/protectpay/Payers/' . $payerExternalAccountId . '/PaymentMethods/AuthorizedTransactions');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->_getAuth());
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));

        $this->_paymentMethodTransactionInfo = curl_exec($ch);
        return $this;

    }

    /**
     * @param array $paymentMethodTransactionData
     * @return $this
     */
    public function setPaymentMethodTransactionData($paymentMethodTransactionData) {
        $this->_paymentMethodTransactionData = $paymentMethodTransactionData;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethodTransactionInfo() {
        return $this->_paymentMethodTransactionInfo;
    }

    /**
     * @return $this
     * success result is something like
     * {"Transaction":{"AVSCode":"NotPresent","AuthorizationCode":null,"CurrencyConversionRate":1.0,"CurrencyConvertedAmount":0,"CurrencyConvertedCurrencyCode":"Unsupported","ResultCode":{"ResultValue":"SUCCESS","ResultCode":"00","ResultMessage":""},"TransactionHistoryId":"0","TransactionId":"603","TransactionResult":"Success","CVVResponseCode":"NotPresent","GrossAmt":null,"NetAmt":null,"PerTransFee":null,"Rate":null,"GrossAmtLessNetAmt":null},"RequestResult":{"ResultValue":"SUCCESS","ResultCode":"00","ResultMessage":""}}
     */
    public function processPaymentMethodTransactionVoid() {
        $data_string = json_encode($this->_paymentMethodTransactionVoidData);

        $ch = curl_init('https://xmltestapi.propay.com/ProtectPay/VoidedTransactions');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->_getAuth());
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));

        $this->_paymentMethodTransactionVoidInfo = curl_exec($ch);
        return $this;
    }

    /**
     * @param array $paymentMethodTransactionVoidData
     * @return $this
     */
    public function setPaymentMethodTransactionVoidData($paymentMethodTransactionVoidData) {
        $this->_paymentMethodTransactionVoidData = $paymentMethodTransactionVoidData;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethodTransactionVoidInfo() {
        return $this->_paymentMethodTransactionVoidInfo;
    }



    /**
     * @param array $payerIdData
     * @return $this\
     */
    public function setCreatePayerIdData($payerIdData) {
        $this->_createPayerIdData = $payerIdData;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatePayerIdInfo() {
        return $this->_createPayerIdInfo;
    }

    /**
     * @return $this
     * $this->_getHostedTransactionInfo contains something like
     * {
           "HostedTransaction":
           {
               "CreationDate": "2016-02-01T16:32:57.9970565",
               "HostedTransactionIdentifier": "3c2d361a-23a7-4ca1-9c4d-4c18e1af7ad1",
               "PayerId": 1045899410011966,
               "TransactionResultMessage": "",
               "AuthCode": "A11111",
               "TransactionHistoryId": 8299869,
               "TransactionId": "338",
               "TransactionResult": "00",
               "AvsResponse": "T",
               "PaymentMethodInfo":
               {
                   "PaymentMethodID": "48a5bf91-a076-4719-9615-d1dc630e39ca",
                   "PaymentMethodType": "Visa",
                   "ObfuscatedAccountNumber": "474747******4747",
                   "ExpirationDate": "0117",
                   "AccountName": "John Smith",
                   "BillingInformation":
                   {
                       "Address1": "3400 N. Ashton Blvd",
                       "Address2": "Suite 200",
                       "Address3": "",
                       "City": "Lehi",
                       "State": "UT",
                       "ZipCode": "84043",
                       "Country": "USA",
                       "TelephoneNumber": "",
                       "Email": ""
                   },
                   "Description": "",
                   "Priority": 55,
                   "DateCreated": "2016-02-01T16:32:56.307",
                   "Protected": true
               },
               "GrossAmt": 1000,
               "NetAmt": 948,
               "PerTransFee": 25,
               "Rate": 2.69,
               "GrossAmtLessNetAmt": 52,
               "CVVResponseCode": "M",
               "CurrencyConversionRate": 1,
               "CurrencyConvertedAmount": 1000,
               "CurrencyConvertedCurrencyCode": 840
           },
          "Result":
          {
              "ResultValue": "SUCCESS",
              "ResultCode": "00",
              "ResultMessage": ""
          }
       }
     */
    public function getHostedTransaction() {
        $ch = curl_init('https://xmltestapi.propay.com/protectpay/HostedTransactionResults/' . $this->_getHostedTransactionData);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->_getAuth());
        $this->_getHostedTransactionInfo = curl_exec($ch);
        return $this;
    }

    /**
     * Returns the hosted transaction information in json or false if the id does not exist.
     * @return mixed
     */
    public function getHostedTransactionInfo() {
        return $this->_getHostedTransactionInfo;
    }

    /**
     * @return mixed
     */
    public function getCreatedHostedTransactionInfo() {
      return $this->_createdHostedTransactionInfo;
    }

    /**
     * @param array $hostedTransactionData
     * @return $this
     */
    public function setHostedTransactionData($hostedTransactionData) {
        $this->_createHostedTransactionData = $hostedTransactionData;
        return $this;
    }

    /**
     * @param string $getHostedTransactionData
     * This is the hosted transaction id such as "3c2d361a-23a7-4ca1-9c4d-4c18e1af7ad1"
     * @return $this
     */
    public function setGetHostedTransactionData($getHostedTransactionData) {
        $this->_getHostedTransactionData = $getHostedTransactionData;
        return $this;
    }

}