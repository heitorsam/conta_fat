<?php

    $var_cd_cracha = $_GET['varcracha'];

    include '../../conexao.php';

    $cons_nm_resumido = "SELECT 
                         REGEXP_SUBSTR (usu.NM_USUARIO, '^\w+') || ' ' ||
                         REGEXP_SUBSTR (usu.NM_USUARIO, '\w+$') AS NM_RESUMIDO,
                         LENGTH(usu.NM_USUARIO) AS TAMANHO
                         FROM dbasgu.USUARIOS usu
                         WHERE usu.CD_USUARIO = '$var_cd_cracha'
                         AND usu.CD_USUARIO NOT IN (SELECT CD_USUARIO
                                                    FROM conta_fat.FATURISTA) ";

    $res = oci_parse($conn_ora, $cons_nm_resumido);
    oci_execute($res);

    $row = oci_fetch_array($res);

    $tamanho_nm_final_resumido =  @$row['TAMANHO'];
    $nm_final_resumido =  @$row['NM_RESUMIDO'];


    if($tamanho_nm_final_resumido > 5){

        echo 'Usuário:';
        echo '<input id="id_nm_resumido" type="text" value="' . $nm_final_resumido . '" class="form form-control" readonly>';

    }
?>