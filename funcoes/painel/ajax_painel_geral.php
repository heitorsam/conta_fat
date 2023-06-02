<?php

    session_start();
    include '../../conexao.php';

    //COLETANDO VALORES COM GET

    $var_dt_ini = $_GET['dtini'];
    $var_dt_fin = $_GET['dtfin'];
    $var_ck_dt_alta = $_GET['ckdtalta'];
    $var_ck_unid_int = $_GET['ckunidint'];
    $var_ck_paciente = $_GET['ckpaciente'];
    $var_ck_convenio = $_GET['ckconvenio'];

    //echo '</br>Dt Inicio: ' . $var_dt_ini . ' | Dt Fim: '. $var_dt_fin;

    echo '<div class="row">';

        echo '<div class="col-2" style="padding: 0px !important; margin: 0px !important; background-color: rgba(1,1,1,0) !important;">';

            include 'bloco_37_secretaria.php';

        echo '</div>';

        echo '<div class="col-2" style="padding: 0px !important; margin: 0px !important; background-color: rgba(1,1,1,0) !important;">';

            include 'bloco_8_auditoria.php';

        echo '</div>';

        echo '<div class="col-2" style="padding: 0px !important; margin: 0px !important; background-color: rgba(1,1,1,0) !important;">';

            include 'bloco_7_autorizacao.php';

        echo '</div>';

        echo '<div class="col-2" style="padding: 0px !important; margin: 0px !important; background-color: rgba(1,1,1,0) !important;">';

            include 'bloco_2_faturamento.php';

        echo '</div>';


        echo '<div class="col-2" style="padding: 0px !important; margin: 0px !important; background-color: rgba(1,1,1,0) !important;">';

            include 'bloco_faturista.php';

        echo '</div>';


    echo '</div>';

?>

<script>

    //OBSERVACAO

    function ajax_abre_modal_obs(js_cd_conta, js_qtd_msg){

        $('#modalobsfat').modal('show');  

        console.log(js_cd_conta + ' | ' + js_qtd_msg);

        $('#div_obs_fat').load('funcoes/painel/ajax_exibe_obs_faturista.php?cdconta='+js_cd_conta+'&qtdmsg='+js_qtd_msg);  

    }

</script>