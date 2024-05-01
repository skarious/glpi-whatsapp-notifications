<?php
/*
  ESTE PLUGIN É COMPATÍVEL COM A API DE WHATSAPP "WASERVICE"
*/

define("URL_API_WHATSAPP", "https://api.waservice.com.br/api/messages/send");
define("WHATSAPP_TOKEN", "token-goes-here");

function plugin_whatsappnotification_item_add(CommonDBTM $item){
    $entity_id = $item->fields['entities_id'];
    $entity = new Entity();
    $entity->getFromDb($entity_id);
    print_r($entity->fields['name']);
    die();

        $user_id = $item->getActorsForType(CommonITILActor::REQUESTER)[0]["items_id"];
        $user = new User();
        $user->getFromDB($user_id);
        $user_mobile_phone = $user->fields["mobile"];
        if($user_mobile_phone != ""){
                $data = array(
                    'number' => $user_mobile_phone,
                    'body' => "Olá {$user->fields['name']}\n" .
                "Esta é uma mensagem automática de que sua solicitação sobre \"{$item->fields['name']}\" foi registrada com número de protocolo " .
                "{$item->fields['id']}\nConte sempre conosco.",
                    'userId' => '',
                    'queueId' => '',
                    'sendSignature' => true,
                    'closeTicket' => false
                );

        $headers = array(
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . WHATSAPP_TOKEN
        );

                $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, URL_API_WHATSAPP);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $response = curl_exec($ch);
        curl_close($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        }else{
        // TODO: adicionar logica para notificar caso nao seja encontrado o telefone do usuario.
        }

}


function plugin_whatsappnotification_install() {
   return true;
}


function plugin_whatsappnotification_uninstall() {
   return true;
}
