<?php
    // AQUI VAI SER NOSSA APLICAÇÃO
    require_once __DIR__ . '../../../api/config.php';
    require_once __DIR__ . '../../../api/response.php';

    if(API_IS_ACTIVE){
        echo Response::resposta(200,'success',[
            'version' => API_VERSION,
            'status' => 'ATIVA'
        ]);
    } else{
        echo Response::resposta(200,'success',[
            'version' => API_VERSION,
            'status' => 'MANUTENÇÃO'
        ]);
    }


?>