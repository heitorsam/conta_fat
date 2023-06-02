<?php

    session_start();

    //CHAMANDO A CONEXAO    
    include '../../conexao.php';
    
    //COLETANDO AS VARIAVEIS POST
    $usuario_login = $_SESSION['usuarioLogin'];
    $var_cd_fat = $_POST['cdfat'];
    $var_cd_protocolo = $_POST['cdprotocolo'];

    //GERANDO ID DA CONTA 
    $cons_id_conta = "SELECT conta_fat.SEQ_CONTA.NEXTVAL AS CD_CONTA FROM DUAL";

    $result_conta = oci_parse($conn_ora, $cons_id_conta);
    oci_execute($result_conta);

    $row_conta = oci_fetch_array($result_conta);

    $var_cd_conta = $row_conta['CD_CONTA'];

    //EXECUTANDO COMANDOS NO ORACLE
    $consulta_insert = "INSERT INTO conta_fat.CONTA 
                        SELECT 
                        $var_cd_conta AS CD_CONTA,
                        '$var_cd_protocolo' AS CD_PROTOCOLO,
                        'A' TP_STATUS,
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

        //EXECUTANDO COMANDOS NO ORACLE
        $consulta_insert = "INSERT INTO conta_fat.MOVIMENTACAO 
                            SELECT
                            conta_fat.SEQ_MOVIMENTACAO.NEXTVAL CD_MOVIMENTACAO,
                            $var_cd_conta AS CD_CONTA,
                            'F' AS TP_ORIGEM,
                            '$usuario_login' AS CD_USUARIO_ORIGEM,
                            'A' TP_DESTINO,
                            $var_cd_fat AS CD_USUARIO_DESTINO,
                            'N' AS SN_RETROCEDE,
                            NULL AS DS_OBSERVACAO,
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
    }

?>