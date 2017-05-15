<?php
    require_once('Soap.php');
    //phpinfo();
// ------------------------------------------
//  ABSTRACT EXAMPLE
// ------------------------------------------

class PersonList extends SOAPable {
    protected $ArrayOfPerson; // variable MUST be protected or public!
}

class Person extends SOAPable {
    //any data
}

//$client=new SoapClient("test.wsdl", array( 'soap_version'=>SOAP_1_2, 'trace'=>1, 'classmap' => array('Person' => "Person", 'PersonList' => "PersonList")  ));

//$PersonList=new PersonList;

// some actions

//$PersonList->getAsSOAP();

//$client->someMethod($PersonList);
$soapClient = new SoapClient("https://soapserver.example.com/blahblah.asmx?wsdl");

// Prepare SoapHeader parameters
$sh_param = array(
    'Username'    =>    'username',
    'Password'    =>    'password');
$headers = new SoapHeader('http://soapserver.example.com/webservices', 'UserCredentials', $sh_param);

// Prepare Soap Client
$soapClient->__setSoapHeaders(array($headers));

// Setup the RemoteFunction parameters
$ap_param = array(
    'amount'     =>    $irow['total_price']);

// Call RemoteFunction ()
$error = 0;
try {
    $info = $soapClient->__call("RemoteFunction", array($ap_param));
} catch (SoapFault $fault) {
    $error = 1;
    print(" 
            alert('Sorry, blah returned the following ERROR: ".$fault->faultcode."-".$fault->faultstring.". We will now take you back to our home page.'); 
            window.location = 'main.php'; 
            ");
}

if ($error == 0) {
    $auth_num = $info->RemoteFunctionResult;

    if ($auth_num < 0) {
        //....

        // Setup the OtherRemoteFunction() parameters
        $at_param = array(
            'amount'        => $irow['total_price'],
            'description'    => $description);

        // Call OtherRemoteFunction()
        $trans = $soapClient->__call("OtherRemoteFunction", array($at_param));
        $trans_result = $trans->OtherRemoteFunctionResult;
        //....
    } else {
        // Record the transaction error in the database

        // Kill the link to Soap
        unset($soapClient);
    }
}

?>