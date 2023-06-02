<?php

    include '../../conexao.php';

    $cons_lista_fat = "SELECT fat.*,
                       (SELECT INITCAP(LOWER(REGEXP_SUBSTR (usu.NM_USUARIO, '^\w+') || ' ' ||
                       REGEXP_SUBSTR (usu.NM_USUARIO, '\w+$')))
                       FROM dbasgu.USUARIOS usu
                       WHERE usu.CD_USUARIO = fat.CD_USUARIO) AS NM_USUARIO_RESUMIDO
                       FROM conta_fat.FATURISTA fat
                       WHERE fat.SN_ATIVO = 'S'";

    $res = oci_parse($conn_ora, $cons_lista_fat);
    oci_execute($res);

    echo '<div class="row">';

    while($row = oci_fetch_array($res)){

            echo '<div class="col-6 col-md-3">' 
            . "<div class='mini_caixa_painel' id='div_fat_nome_" . $row['CD_FATURISTA'] . "' ";                    

            ?>

            onclick="ajax_seleciona_faturista_opcao('<?php echo $row['CD_FATURISTA']; ?>')"
            
            <?php

            echo " style='cursor: pointer; float: none !important; margin: 0 auto !important; width: max-content; background-color:" . $row['RGB_FUNDO'] . "; color: " . $row['RGB_FONTE'] . ";'>" . $row['NM_USUARIO_RESUMIDO'] . "</div> </div>";
        
    }

    echo '</div>';

?>