<?php

    session_start();

    //CHAMANDO A CONEXAO    
    include '../../conexao.php';

    //COLETANDO AS VARIAVEIS POST
    $usuario_login = $_SESSION['usuarioLogin'];
    $var_codigo = $_POST['codigo'];
    
    if($_POST['status'] == 1){

        $var_status = 'N';

    }else{

        $var_status = 'S';
    }

    //EXECUTANDO COMANDOS NO ORACLE
    $consulta_update = "UPDATE conta_fat.FATURISTA fat
                        SET fat.SN_ATIVO = '$var_status',
                        fat.CD_USUARIO_ULT_ALT = '$usuario_login',
                        fat.HR_ULT_ALT = SYSDATE
                        WHERE fat.CD_FATURISTA = '$var_codigo'";

    $result_update = oci_parse($conn_ora, $consulta_update);

    $valida = oci_execute($result_update);

    if(!$valida){

        $erro = oci_error($result_update);																							
        $msg_erro = htmlentities($erro['message']);
        echo $msg_erro;

    }else{

        echo 'Sucesso';
    }

?>