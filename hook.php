<?php
/*
  ESTE PLUGIN É COMPATÍVEL COM A API WHATSAPP "EVOLUTION".
*/

define("URL_API_WHATSAPP", "http://192.168.0.236:8080/message/sendText/aaaa");
define("WHATSAPP_TOKEN", "B6D711FCDE4D4FD5936544120E713976");


function alertaNovoChamadoWhatsApp($remoteJid, $message){
    $headers = array(
        'Content-Type: application/json',
        'apikey: ' . WHATSAPP_TOKEN
    );

    $message["number"] = $remoteJid;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, URL_API_WHATSAPP);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
    $response = curl_exec($ch);
    curl_close($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}


function plugin_whatsappnotification_item_add(CommonDBTM $item){
    // define quem vai receber os alertas
    $WhatsappAlertDestinations = array("595985624358", "595985757630");
    
    // carrega a entidade
    $entity_id = $item->fields["entities_id"];
    $entity = new Entity();
    $entity->getFromDb($entity_id);
    
    // carrega o usuario
    $user_id = $item->getActorsForType(CommonITILActor::REQUESTER)[0]["items_id"];
    $user = new User();
    $user->getFromDB($user_id);
    $user_mobile_phone = $user->fields["mobile"];
    $data = array(
        "number" => $user_mobile_phone,
        "textMessage" => array("text" => "Nuevo Ticket Generado\n" .
        "Usuario: {$user->fields['realname']}\n" .
        "Cliente: {$entity->fields['name']}\n" .
        "Motivo: {$item->fields['name']}.\n" .
        "Numero Ticker: *{$item->fields['id']}.*")
    );
    foreach($WhatsappAlertDestinations as $remoteJid){
        alertaNovoChamadoWhatsApp($remoteJid, $data);
    
    }


}


function plugin_whatsappnotification_install() {
   return true;
}


function plugin_whatsappnotification_uninstall() {
   return true;
}
