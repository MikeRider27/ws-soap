<?php

require_once 'vendor/econea/nusoap/src/nusoap.php';

$namespace = 'mi.mike.com';
$server = new soap_server();
$server->configureWSDL('PincheSOAP', $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
    'ordenDeCompra',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'NumeriOrden' => array('name' => 'NumeriOrden', 'type' => 'xsd:string'),
        'Ordenante' => array('name' => 'Ordenante', 'type' => 'xsd:string'),
        'Moneda' => array('name' => 'Moneda', 'type' => 'xsd:string'),
        'TipoCambio' => array('name' => 'TipoCambio', 'type' => 'xsd:decimal'),
    )
);

$server->wsdl->addComplexType(
    'response',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'NumeroDeAutorizacion' => array('name' => 'NumeroDeAutorizacion', 'type' => 'xsd:string'),
        'Resultado' => array('name' => 'Resultado', 'type' => 'xsd:boolean')
    )
);

$server->register(
    'guardarOrdenDeCompra',
    array('name' => 'tns:ordenDeCompra'),
    array('name' => 'tns:response'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Recibe una orden de compra y regresa un numero de autorizacion'
);

function guardarOrdenDeCompra($request)
{
    $response = array(
        'NumeroDeAutorizacion' => "La orden de compra" . $request['NumeriOrden'] . " ha sido autorizada con el numero" . rand(10000, 1000000),
        'Resultado' => true
    );
    return $response;
}

$POST_DATA = file_get_contents("php://input");
$server->service($POST_DATA);
exit();
