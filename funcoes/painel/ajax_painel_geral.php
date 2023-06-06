<?php

    session_start();
    include '../../conexao.php';

    //COLETANDO VALORES COM GET

    $var_dt_ini = $_GET['dtini'];
    $var_dt_fin = $_GET['dtfin'];
    $var_cd_unid_int = $_GET['cdunidint'];
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

        echo '<div class="col-2" style="padding: 0px !important; margin: 0px !important; background-color: rgba(1,1,1,0) !important;">';

            include 'bloco_concluido.php';

        echo '</div>';

    echo '</div>';

?>

<script>

    //OBSERVACAO
    function ajax_abre_modal_obs(js_cd_conta, js_qtd_msg, js_sn_autoriza){
        
        sessionStorage.setItem("sessao_conta_fat_obs",js_cd_conta);

        $('#modalobsfat').modal('show');  

        //console.log(js_cd_conta + ' | ' + js_qtd_msg);

        $('#div_obs_fat').load('funcoes/painel/ajax_exibe_obs_faturista.php?cdconta='+js_cd_conta+'&qtdmsg='+js_qtd_msg+'&snautoriza='+js_sn_autoriza);  


        if(js_sn_autoriza == 1){

            document.getElementById("id_btn_salvar_obs_fat").disabled = false;          

        }else{

            document.getElementById("id_btn_salvar_obs_fat").disabled = true;  


        }
    }

    function ajax_salva_obs_fat(){

        var js_msg_obs_fat = document.getElementById('txt_obs_fat').value;

        var js_cd_conta_obs = sessionStorage.getItem("sessao_conta_fat_obs");  

        //console.log(js_msg_obs_fat);

        $.ajax({
            url: "funcoes/painel/ajax_insert_obs_faturista.php",
            type: "POST",
            data: {

                cdconta: js_cd_conta_obs,
                msgobs: js_msg_obs_fat

                },
            cache: false,
            success: function(dataResult){

                console.log(dataResult);

                if(dataResult == 'Sucesso'){

                    ajax_carrega_painel_geral();
                    //$('#modalobsfat').modal('hide');  

                    $('#div_obs_fat').load('funcoes/painel/ajax_exibe_obs_faturista.php?cdconta='+js_cd_conta+'&qtdmsg='+js_qtd_msg);  

                    //MENSAGEM            
                    var_ds_msg = 'Observação%20salva%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                    //var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

                }else{               

                    ajax_carrega_painel_geral();
                    //$('#modalobsfat').modal('hide');  

                    //MENSAGEM            
                    var_ds_msg = 'Erro%20ao%20salvar%20a%20observação!';
                    //var_tp_msg = 'alert-success';
                    var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);                
                
                }  

            }

        });       


    }

</script>