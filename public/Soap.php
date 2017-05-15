<?php
/**
 * Created by PhpStorm.
 * User: Damon Hogan
 * Date: 05/05/17
 * Time: 17:56
 */

abstract class SOAPable {
    public function getAsSOAP() {
        foreach($this as $key=>&$value) {
            $this->prepareSOAPrecursive($this->$key);
        }
        return $this;
    }

    private function prepareSOAPrecursive(&$element) {
        if(is_array($element)) {
            foreach($element as $key=>&$val) {
                $this->prepareSOAPrecursive($val);
            }
            $element=new SoapVar($element,SOAP_ENC_ARRAY);
        }elseif(is_object($element)) {
            if($element instanceof SOAPable) {
                $element->getAsSOAP();
            }
            $element=new SoapVar($element,SOAP_ENC_OBJECT);
        }
    }
}