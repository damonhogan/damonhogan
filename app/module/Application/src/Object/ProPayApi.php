<?php

namespace Application\Object;

class ProPayApi {

    private $_certStr;
    private $_termId;
    private $_signupData;
    private $_signupInfo;

    /**
     * @param $certStr
     * @return $this
     */
    public function setCertStr($certStr) {
        $this->_certStr = $certStr;
        return $this;
    }

    /**
     * @param $signupData
     * @return $this
     */
    public function setSignupData($signupData) {
        $this->_signupData = $signupData;
        return $this;
    }

    /**
     * @param $termId
     * @return $this
     */
    public function setTermId($termId) {
        $this->_termId = $termId;
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
     * Gets a json string of the signupInfo of the tier that was just signed up.  A signed up response
     * looks like
     * {"AccountNumber":32299999,"Password":"$#GD!ADXv2","SourceEmail":"someuser@somedomain.com","Status":"00","Tier":"Platinum"}
     * @return mixed
     */
    public function getSignupInfo() {
        return $this->_signupInfo;
    }
}