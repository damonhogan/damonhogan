<?php

namespace Application\Object;

class ProtectPayApi {

    /* change this to the production url for going live after testing https://api.propay.com */
    private $_apiBaseUrl = 'https://xmltestapi.propay.com';

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

    /* for refunding a settled transaction */
    private $_transactionRefundData;
    private $_transactionRefundInfo;

    /* for temp tokens */
    private $_tempToken;

    /* md5 hash of utf8 encoded temp token */
    private $_md5HashUtf8TempToken;

    private $_encryptedString;
    private $_decryptedString;

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

        $ch = curl_init($this->_apiBaseUrl . '/protectpay/hostedtransactions');
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

        $ch = curl_init($this->_apiBaseUrl . '/ProtectPay/Payers');
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

        $ch = curl_init($this->_apiBaseUrl . '/protectpay/Payers/' . $payerExternalAccountId . '/PaymentMethods/AuthorizedTransactions');
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

        $ch = curl_init($this->_apiBaseUrl . '/ProtectPay/VoidedTransactions');
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
     * @return $this
     * result is something like ...
     * {
     *     "TransactionDetail":{
     *         "AVSCode":"NotPresent",
     *         "AuthorizationCode":null,
     *         "CurrencyConversionRate":1.0,
     *         "CurrencyConvertedAmount":100,
     *         "CurrencyConvertedCurrencyCode":"USD",
     *         "CVVResponseCode":"NotPresent",
     *         "GrossAmt ":null,
     *         "GrossAmtLessNetAmt ":null,
     *         "NetAmt ":null,
     *         "PerTransFee ":null,
     *         "Rate ":null
     *         "ResultCode":{
     *             "ResultValue":"SUCCESS",
     *             "ResultCode":"00",
     *             "ResultMessage":""
     *         },
     *         "TransactionHistoryId":"39560623",
     *         "TransactionId":"3",
     *         "TransactionResult":"Success"
     *     },
     *     "RequestResult":{
     *     "ResultValue":"SUCCESS",
     *     "ResultCode":"00",
     *     "ResultMessage":""
     *     }
     * }
     */
    public function processSettledTransactionRefund() {
        $data_string = json_encode($this->_transactionRefundData);
        $ch = curl_init($this->_apiBaseUrl . '/ProtectPay/RefundTransaction');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->_getAuth());
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));

        $this->_transactionRefundInfo = curl_exec($ch);
        return $this;

    }

    /**
     * @param array $transactionRefundData
     * @return $this
     */
    public function setTransactionRefundData($transactionRefundData) {
        $this->_transactionRefundData = $transactionRefundData;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactionRefundInfo() {
        return $this->_transactionRefundInfo;
    }

    /**
     * gets a temp token for a payer id which lasts the specified duration in seconds
     * @param int $payerId
     * @param int $durationInSeconds
     * @return $this
     * result is something like ...
     * {"TempToken":"e20fe709-26e3-43fb-ad9b-07dc85e8f4acdd256f4c-ebbf-4b39-8174-c4cf7e11f9dd","PayerId":"8924157370851397","RequestResult":{"ResultValue":"SUCCESS","ResultCode":"00","ResultMessage":""},"CredentialId":4086261}
     */
    public function getPayerIdTempToken($payerId, $durationInSeconds) {
        $ch = curl_init($this->_apiBaseUrl . '/ProtectPay/Payers/' .
            $payerId . '/TempTokens/?durationSeconds=' . $durationInSeconds);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->_getAuth());
        $this->_tempToken = curl_exec($ch);
        return $this;
    }

    /**
     * gets a temp token for an unknown payer id by specifying a first and last name separated by a space
     * in payerName, which lasts the specified duration in seconds
     * @param string $payerName
     * @param int $durationInSeconds
     * @return $this
     * result is something like ...
     * {"TempToken":"a6ab35d3-905b-4d1e-a967-169c1aa2dd56d337e8bd-d6ae-4f3b-a4b6-0980dcbeb632","PayerId":"3515879384408403","RequestResult":{"ResultValue":"SUCCESS","ResultCode":"00","ResultMessage":""},"CredentialId":4086263}
     */
    public function getPayerNameTempToken($payerName, $durationInSeconds) {
        $ch = curl_init($this->_apiBaseUrl . '/protectpay/TempTokens/?payerName=' .
            urlencode($payerName). '&durationSeconds=' . $durationInSeconds);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->_getAuth());
        $this->_tempToken = curl_exec($ch);
        return $this;
    }


    /**
     * @return mixed
     */
    public function getTempTokenInfo() {
        return $this->_tempToken;
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
        $ch = curl_init($this->_apiBaseUrl . '/protectpay/HostedTransactionResults/' . $this->_getHostedTransactionData);
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

    /**
     * @param string $tempToken
     * @return $this
     */
    public function setUtf8EncodeMd5HashTempToken($tempToken) {
        $this->_tempToken = $tempToken;
        $this->_md5HashUtf8TempToken = md5(utf8_encode($tempToken));
        return $this;
    }

    /**
     * Encrypts the string using the set $this->_md5HashUtf8TempToken
     * @param string $stringToEncrypt
     * @return $this
     */
    public function encryptString($stringToEncrypt) {
        $this->_encryptedString = openssl_encrypt($stringToEncrypt, 'AES-128-CBC', $this->_md5HashUtf8TempToken, OPENSSL_RAW_DATA, $this->_md5HashUtf8TempToken);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEncryptedString() {
        return $this->_encryptedString;
    }

    /**
     * Decrypts the string using the set $this->_md5HashUtf8TempToken
     * @param string $stringToDecrypt
     * @return $this
     */
    public function decryptString($stringToDecrypt) {
        $this->_encryptedString = $stringToDecrypt;
        $this->_decryptedString = openssl_decrypt($stringToDecrypt, 'AES-128-CBC', $this->_md5HashUtf8TempToken, OPENSSL_RAW_DATA, $this->_md5HashUtf8TempToken);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDecryptedString() {
        return $this->_decryptedString;
    }

}