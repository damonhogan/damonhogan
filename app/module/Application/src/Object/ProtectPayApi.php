<?php

namespace Application\Object;

class ProtectPayApi {

    /* credentials that would normally be set from database values or a config value */
    private $_certStr;
    private $_termId;

    /* for creating hosted transactions */
    private $_createHostedTransactionData;
    private $_createdHostedTransactionInfo;

    /**
     * @param string $certStr
     * @return $this
     */
    public function setCertStr($certStr) {
        $this->_certStr = $certStr;
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
     * @return string
     */
    private function _getAuth() {
        return $this->_certStr . ':' . $this->_termId;
    }

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

}