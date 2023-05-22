<?php

    include '../../conexao.php';

    //COLETANDO VALORES COM GET

    $var_dt_ini = $_GET['dtini'];
    $var_dt_fin = $_GET['dtfin'];

    echo '</br>Dt Inicio: ' . $var_dt_ini . ' | Dt Fim: '. $var_dt_fin;

?>