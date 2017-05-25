<?php

namespace Application\Object;

class ProPayApi {

    private $_certStr;
    private $_termId;

    /* for signups */
    private $_signupData;
    private $_signupInfo;

    /* for transfers */
    private $_propayToPropayTransferData;
    private $_propayToPropayTransferInfo;

    /** for timed pull */
    private $_timedPullData;
    private $_timedPullInfo;

    /* for xml */

    /** @var  \SimpleXMLElement */
    private $_xmlRequestObject;
    /** @var  \SimpleXMLElement */
    private $_xmlResponseObject;

    /**
     * @param string $certStr
     * @return $this
     */
    public function setCertStr($certStr) {
        $this->_certStr = $certStr;
        return $this;
    }

    /**
     * @param array $signupData
     * @return $this
     */
    public function setSignupData($signupData) {
        $this->_signupData = $signupData;
        return $this;
    }

    /**
     * @param array $transferData
     * @return $this
     */
    public function setPropayToPropayTransferData($transferData) {
        $this->_propayToPropayTransferData = $transferData;
        return $this;
    }

    /**
     * @param string $termId
     * @return $this
     */
    public function setTermId($termId) {
        $this->_termId = $termId;
        return $this;
    }

    /**
     * @param array $timedPullData
     * @return $this
     */
    public function setTimedPullData($timedPullData) {
        $this->_timedPullData = $timedPullData;
        return $this;
    }

    /**
     * @return string
     */
    private function _getAuth() {
        return $this->_certStr . ':' . $this->_termId;
    }

    /**
     * Processes the signup process through the rest api
     * @return $this
     */
    public function processSignup() {
        $data_string = json_encode($this->_signupData);

        $ch = curl_init('https://xmltestapi.propay.com/ProPayAPI/signup');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->_getAuth());
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));

        $this->_signupInfo = curl_exec($ch);
        return $this;
    }

    /**
     * @return $this
     */
    public function processProPayToProPay() {
        $data_string = json_encode($this->_propayToPropayTransferData);

        $ch = curl_init('https://xmltestapi.propay.com/ProPayAPI/ProPayToProPay');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->_getAuth());
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));

        $this->_propayToPropayTransferInfo = curl_exec($ch);
        return $this;
    }

    /**
     * Processes the timed pull with the provided data
     * @return $this
     */
    public function processTimedPull() {
        $data_string = json_encode($this->_timedPullData);

        $ch = curl_init('https://xmltestapi.propay.com/ProPayAPI/timedPull');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->_getAuth());
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));

        $this->_timedPullInfo = curl_exec($ch);
        return $this;
    }

    /**
     * @return mixed
     * returns a json string that looks like
     * {"AccountNumber":32291226,"Status":"00","TransactionNumber":3249572035}
     */
    public function getProPayToPropayTransferInfo() {
       return $this->_propayToPropayTransferInfo;
    }

    /**
     * Gets a json string of the signupInfo of the tier that was just signed up.  A signed up response
     * looks like
     * {"AccountNumber":32299999,"Password":"$#GD!ADXv2","SourceEmail":"someuser@somedomain.com","Status":"00","Tier":"Platinum"}
     * @return mixed
     */
    public function getSignupInfo() {
        return $this->_signupInfo;
    }

    /**
     * gets the timed pull info after processing, looks something like...
     * @return mixed
     * {
           "AccountNumber": 987654,
           "Status": "00",
           "TransactionNumber": 1
       }
     */
    public function getTimedPullInfo() {
        return $this->_timedPullInfo;
    }

    /**
     * sets the xml request object
     * @param string $xmlData - containing XML
     * @return $this
     */
    public function setXMLRequestData($xmlData) {
        $this->_xmlRequestObject = simplexml_load_string($xmlData);
        return $this;
    }

    /**
     * @param string $xmlData - containing XML
     * @return $this
     */
    public function setXMLResponseData($xmlData) {
        $this->_xmlResponseObject = simplexml_load_string($xmlData);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getXMLRequestObject() {
        return $this->_xmlRequestObject;
    }

    /**
     * @return mixed
     */
    public function getXMLResponseObject() {
        return $this->_xmlResponseObject;
    }

    /**
     * @param \SimpleXMLElement $xmlObject
     * @return $this
     */
    public function setXMLRequestObject(\SimpleXMLElement $xmlObject) {
        $this->_xmlRequestObject = $xmlObject;
        return $this;
    }

    /**
     * @param \SimpleXMLElement $xmlObject
     * @return $this
     */
    public function setXMLResponseObject(\SimpleXMLElement $xmlObject) {
        $this->_xmlResponseObject = $xmlObject;
        return $this;
    }


}