<?php

    session_start();

    //CHAMANDO A CONEXAO    
    include '../../conexao.php';
    
    //COLETANDO AS VARIAVEIS POST
    $usuario_login = $_SESSION['usuarioLogin'];
    $var_usuario = $_POST['usuario'];
    $var_fundo = $_POST['fundo'];
    $var_fonte = $_POST['fonte'];

    //EXECUTANDO COMANDOS NO ORACLE
    $consulta_insert = "INSERT INTO conta_fat.FATURISTA fat
                        SELECT conta_fat.SEQ_FATURISTA.NEXTVAL AS CD_FATURISTA,
                        '$var_usuario' AS CD_USUARIO,    
                        '$var_fundo' AS RGB_FUNDO,   
                        '$var_fonte' AS RGB_FONTE,   
                        'S' AS SN_ATIVO,    
                        '$usuario_login' AS CD_USUARIO_CADASTRO,
                        SYSDATE AS HR_CADASTRO,   
                        NULL AS CD_USUARIO_ULT_ALT,    
                        NULL AS HR_ULT_ALT 
                        FROM DUAL";

    $result_insert = oci_parse($conn_ora, $consulta_insert);

    $valida = oci_execute($result_insert);

    if(!$valida){

        $erro = oci_error($result_insert);																							
        $msg_erro = htmlentities($erro['message']);
        echo $msg_erro;

    }else{

        echo 'Sucesso';
    }

?>