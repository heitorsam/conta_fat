<?php

    session_start();

    //CHAMANDO A CONEXAO    
    include '../../conexao.php';
    
    //COLETANDO AS VARIAVEIS POST
    $usuario_login = $_SESSION['usuarioLogin'];
    $var_cd_conta = $_POST['cdconta'];
    $var_obs_msg = $_POST['msgobs'];

    $cons_cad_par = "INSERT INTO conta_fat.MENSAGEM
                     (CD_MENSAGEM,
                     CD_CONTA,
                     TP_MENSAGEM,
                     DS_MENSAGEM,
                     CD_USUARIO_CADASTRO,
                     HR_CADASTRO,
                     CD_USUARIO_ULT_ALT,
                     HR_ULT_ALT)
                     VALUES
                     (conta_fat.SEQ_CONTA.NEXTVAL,
                     $var_cd_conta,
                     'O',
                     EMPTY_CLOB(),
                     '$usuario_login',
                     SYSDATE,
                     NULL,
                     NULL
                     ) RETURNING DS_MENSAGEM
                     INTO :par1";

    $result_cad_par = oci_parse($conn_ora, $cons_cad_par);

    $myLOB1 = oci_new_descriptor($conn_ora, OCI_D_LOB); 

    oci_bind_by_name($result_cad_par, ":par1", $myLOB1, -1, OCI_B_CLOB);

    $resultado = oci_execute($result_cad_par, OCI_NO_AUTO_COMMIT);

    // Now save a value to the LOB
    $myLOB1->save($var_obs_msg);

    oci_commit($conn_ora);

    // Free resources
    oci_free_statement($result_cad_par);

    $myLOB1->free();

    echo 'Sucesso';

?>