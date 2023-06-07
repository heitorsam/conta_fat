<?php

    session_start();

    //CHAMANDO A CONEXAO    
    include '../../conexao.php';
    
    //COLETANDO AS VARIAVEIS POST
    $usuario_login = $_SESSION['usuarioLogin'];
    $var_cd_unid_int = $_GET['unidint'];

    if($var_cd_unid_int == null || $var_cd_unid_int == 'null' || !isset($var_cd_unid_int)) {
        $var_cd_unid_int = 0;
    }

    $cons_unid_int = "SELECT unid.CD_UNID_INT, unid.DS_UNID_INT
                      FROM dbamv.UNID_INT unid
                      WHERE unid.SN_ATIVO = 'S'
                      AND unid.CD_UNID_INT = $var_cd_unid_int
                       
                       UNION ALL

                       SELECT *
                       FROM(SELECT unid.CD_UNID_INT, unid.DS_UNID_INT
                            FROM dbamv.UNID_INT unid
                            WHERE unid.SN_ATIVO = 'S'
                            AND unid.CD_UNID_INT <> $var_cd_unid_int
                            ORDER BY unid.DS_UNID_INT)";

    $res_unid_int = oci_parse($conn_ora,$cons_unid_int);

    oci_execute($res_unid_int);

    echo '<select onchange="ajax_carrega_painel_geral()" id="sel_unid_int" class="form-control">';
    
    if($var_cd_unid_int == 0){
        echo '<option value="0">TODOS</option>';
    }

    while($row_unid_int = oci_fetch_array($res_unid_int)){

        echo '<option value=' . $row_unid_int['CD_UNID_INT'] . '>' . $row_unid_int['DS_UNID_INT'] . '</option>';

    }

    if($var_cd_unid_int <> 0){
        echo '<option value="0">TODOS</option>';
    }

    echo '</select>';

?>