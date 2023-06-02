<?php

    session_start();

    //CHAMANDO A CONEXAO    
    include '../../conexao.php';
    
    //COLETANDO AS VARIAVEIS POST
    $usuario_login = $_SESSION['usuarioLogin'];
    $var_cd_conta = $_GET['cdconta'];
    $var_qtd_msg = $_GET['qtdmsg'];

    //EXECUTANDO COMANDOS NO ORACLE
    $consulta_obs = "SELECT msg.CD_MENSAGEM, msg.CD_CONTA, msg.TP_MENSAGEM,
                     conta_fat.FNC_RETORNA_TXT_LIMITE_CARACT(msg.DS_MENSAGEM, 2000) AS DS_MENSAGEM                     
                     FROM conta_fat.MENSAGEM msg
                     WHERE msg.TP_MENSAGEM = 'O'
                     AND msg.CD_CONTA = $var_cd_conta
                     AND msg.CD_MENSAGEM IN (SELECT MAX(CD_MENSAGEM) AS MSGMAX 
                                             FROM conta_fat.MENSAGEM
                                             WHERE TP_MENSAGEM = 'O'
                                             AND CD_CONTA = $var_cd_conta)";

    $result = oci_parse($conn_ora, $consulta_obs);

    oci_execute($result);

    $row = oci_fetch_array($result);

    echo '<textarea class="form-control" id="txt_obs_fat" rows="7">' . @$row['DS_MENSAGEM'] . '</textarea>';

?>