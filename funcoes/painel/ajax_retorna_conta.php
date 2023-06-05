<?php

    session_start();

    //CHAMANDO A CONEXAO    
    include '../../conexao.php';
    
    //COLETANDO AS VARIAVEIS POST
    $usuario_login = $_SESSION['usuarioLogin'];
    $var_cd_conta = $_POST['cdconta'];

    //GERANDO MOV
    $cons_mov = "INSERT INTO conta_fat.MOVIMENTACAO
                      SELECT conta_fat.SEQ_MOVIMENTACAO.NEXTVAL AS CD_MOVIMENTACAO,
                      $var_cd_conta AS CD_CONTA, 
                      'C' AS TP_ORIGEM,
                      '$usuario_login' AS CD_USUARIO_ORIGEM,
                      'A' AS TP_DESTINO,
                      (SELECT CD_FATURISTA FROM conta_fat.FATURISTA WHERE CD_USUARIO = '$usuario_login') AS CD_USUARIO_DESTINO,
                      'S' AS SN_RETROCEDE,
                      NULL AS DS_OBSERVACAO,
                      '$usuario_login' AS CD_USUARIO_CADASTRO,
                      SYSDATE AS HR_CADASTRO,
                      NULL AS CD_USUARIO_ULT_ALT,
                      NULL AS HR_ULT_ALT
                      FROM DUAL";

    $result_mov = oci_parse($conn_ora, $cons_mov);

    $valida = oci_execute($result_mov);

    if(!$valida){

        $erro = oci_error($result_mov);																							
        $msg_erro = htmlentities($erro['message']);
        echo $msg_erro;

    }else{

        //EXECUTANDO COMANDOS NO ORACLE
        $consulta_insert = "UPDATE conta_fat.CONTA ct
                            SET ct.TP_STATUS = 'A',
                                ct.CD_USUARIO_ULT_ALT = '$usuario_login',
                                ct.HR_ULT_ALT = SYSDATE
                            WHERE ct.CD_CONTA = $var_cd_conta";

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