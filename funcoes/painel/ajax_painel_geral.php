<?php

    include '../../conexao.php';

    //COLETANDO VALORES COM GET

    $var_dt_ini = $_GET['dtini'];
    $var_dt_fin = $_GET['dtfin'];

    //echo '</br>Dt Inicio: ' . $var_dt_ini . ' | Dt Fim: '. $var_dt_fin;

    echo '<div class="div_br"> </div>';

    echo '<div class="row">';

        echo '<div class="col-2" style="padding: 0px !important; margin: 0px; !important">';

            include 'bloco_37_secretaria.php';

        echo '</div>';

        echo '<div class="col-2" style="padding: 0px !important; margin: 0px; !important">';

            include 'bloco_8_auditoria.php';

        echo '</div>';

        echo '<div class="col-2" style="padding: 0px !important; margin: 0px; !important">';

            include 'bloco_7_autorizacao.php';

        echo '</div>';

        echo '<div class="col-2" style="padding: 0px !important; margin: 0px; !important">';

            include 'bloco_2_faturamento.php';

        echo '</div>';


    echo '</div>';

?>