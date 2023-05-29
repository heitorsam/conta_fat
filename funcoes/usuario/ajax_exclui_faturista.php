<?php

    session_start();

    //CHAMANDO A CONEXAO    
    include '../../conexao.php';
    
    //COLETANDO AS VARIAVEIS POST
    $usuario_login = $_SESSION['usuarioLogin'];
    $varcdfaturista = $_POST['cd_faturista'];

    //EXECUTANDO COMANDOS NO ORACLE
    $consulta_delete = "DELETE FROM conta_fat.FATURISTA fat
                        WHERE fat.CD_FATURISTA = '$varcdfaturista'";

    $result_delete = oci_parse($conn_ora, $consulta_delete);

    $valida = oci_execute($result_delete);

    if(!$valida){

        $erro = oci_error($result_delete);																							
        $msg_erro = htmlentities($erro['message']);
        echo $msg_erro;

    }else{

        echo 'Sucesso';
    }

?>