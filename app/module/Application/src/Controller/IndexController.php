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
        $authCode = 'TXlUZXJtSWQ6TXlDZXJ0U3Ry';
        //$data = array("name" => "Hagrid", "age" => "36");
        $data = [];
        $data_string = json_encode($data);

        $ch = curl_init('https://xmltestapi.propay.com/ProPayAPI');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string),
                'Authorization: ' . 'Basic ' . $authCode)
        );

        $result = curl_exec($ch);
        return new ViewModel(['result'=>$result]);
    }
}
