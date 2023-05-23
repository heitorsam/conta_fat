<!--ATUALIZA A PAGINA (SEGUNDOS)-->
<meta http-equiv="refresh" content="120">

<?php 
    //CABECALHO
    include 'cabecalho.php';

    //ACESSO ADM
    //include 'acesso_restrito_adm.php';
?>

    <!--MENSAGENS-->
    <?php
        include 'js/mensagens.php';
        include 'js/mensagens_usuario.php';
    ?>

    <!--
    <h11 style="margin-left: 10px;"><i class="fa-regular fa-clipboard efeito-zoom"></i> Conta Fat</h11>
    <div class="div_br"> </div> -->

    <div class="row" style="padding-top: 0px !important;">

        <div class="col-6 col-md-3" style="text-align: left; padding: 0px; background-color: rgba(1,1,1,0) !important;"> 
            Alta Início:
            <input id="dt_ini" onchange="ajax_carrega_painel_geral()" type="date" class="form-control">
        </div>

        <div class="col-6 col-md-3" style="text-align: left; padding: 0px; padding-left: 20px; background-color: rgba(1,1,1,0) !important;"> 
            Alta Fim:
            <input id="dt_fin" onchange="ajax_carrega_painel_geral()" type="date" class="form-control">
        </div>

    </div>

    <div class="div_br"> </div> 

    
        <input id="ck_dt_alta" onchange="ajax_carrega_painel_geral()" type="checkbox"> <label>Alta</label>
        <input id="ck_paciente" onchange="ajax_carrega_painel_geral()" type="checkbox" style="margin-left: 5px;"> <label>Paciente</label>
        <input id="ck_unid_int" onchange="ajax_carrega_painel_geral()" type="checkbox" style="margin-left: 5px;"> <label>Unidade Internação</label>

    
    <div id="carregando" style="width: 100%; text-align: center; font-size: 40px; display:none;
         animation-name: example;  animation-duration: 4s; animation-delay: -2s; 
         animation-iteration-count: infinite;"> <i class="fa-solid fa-spinner fa-spin-pulse"></i> </div>


    <div id="div_painel_geral"></div>


    <!--
    <a href="inspecao.php" class="botao_home" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Geral</a>
    <span class="espaco_pequeno"></span>


    <?php //if($_SESSION['SN_USUARIO_ADM_FATURAMENTO'] == 'S'){ ?>

        <a href="ficha.php" class="botao_home_adm" type="submit"><i class="fa-regular fa-clipboard"></i> Faturamento</a>
        <span class="espaco_pequeno"></span>
        
    <?php //} ?>
    

    -->
    

<script defer>

    window.onload = function(){

        //VERIFICANDO SE EXISTE SESSAO
        var js_ss_dt_ini = sessionStorage.getItem("sessao_dt_ini"); 
        var js_ss_dt_fin = sessionStorage.getItem("sessao_dt_fin"); 
        var js_ss_ck_dt_alta = sessionStorage.getItem("sessao_ck_dt_alta");
        var js_ss_ck_unid_int = sessionStorage.getItem("sessao_ck_unid_int"); 
        var js_ss_ck_paciente = sessionStorage.getItem("sessao_ck_paciente");           

        if(js_ss_dt_ini == null || js_ss_dt_ini == ''){

            //SE NAO HOUVER SESSAO
            var data_ontem = new Date();
            data_ontem.setDate(data_ontem.getDate() -1);

            document.getElementById('dt_ini').valueAsDate = data_ontem;
            document.getElementById('dt_fin').valueAsDate = data_ontem;

            document.getElementById('ck_dt_alta').checked = true;
            document.getElementById('ck_unid_int').checked = true;
            document.getElementById('ck_paciente').checked = true;
            

        }else{

            //HAVENDO SESSAO
            document.getElementById('dt_ini').value = js_ss_dt_ini;
            document.getElementById('dt_fin').value = js_ss_dt_fin;

            if(js_ss_ck_dt_alta === 'true'){ document.getElementById('ck_dt_alta').checked = true; }else{ document.getElementById('ck_dt_alta').checked = false; }
            if(js_ss_ck_unid_int === 'true'){ document.getElementById('ck_unid_int').checked = true; }else{ document.getElementById('ck_unid_int').checked = false; }
            if(js_ss_ck_paciente === 'true'){ document.getElementById('ck_paciente').checked = true; }else{ document.getElementById('ck_paciente').checked = false; }
        }

        ajax_carrega_painel_geral();

    }

    function ajax_carrega_painel_geral(){

        document.getElementById('carregando').style.display = 'block';
        document.getElementById('div_painel_geral').style.display = 'none';
        
        var js_dt_ini = document.getElementById('dt_ini').value;
        var js_dt_fin = document.getElementById('dt_fin').value;
        var js_ck_dt_alta = document.getElementById('ck_dt_alta').checked; 
        var js_ck_unid_int = document.getElementById('ck_unid_int').checked;
        var js_ck_paciente = document.getElementById('ck_paciente').checked;    

        //DEFINE SESSOES
        sessionStorage.setItem("sessao_dt_ini",js_dt_ini); 
        sessionStorage.setItem("sessao_dt_fin",js_dt_fin);
        sessionStorage.setItem("sessao_ck_dt_alta",js_ck_dt_alta); 
        sessionStorage.setItem("sessao_ck_unid_int",js_ck_unid_int);
        sessionStorage.setItem("sessao_ck_paciente",js_ck_paciente);

        $('#div_painel_geral').load('funcoes/painel/ajax_painel_geral.php?dtini='+js_dt_ini+'&dtfin='+js_dt_fin+'&ckdtalta='+js_ck_dt_alta+'&ckunidint='+js_ck_unid_int+'&ckpaciente='+js_ck_paciente, function() {
            // definir o estilo CSS para ocultar o ícone após a conclusão da solicitação AJAX
            document.getElementById('carregando').style.display = 'none';
            document.getElementById('div_painel_geral').style.display = 'block';

        });    

    

    }

</script>

<?php
    //RODAPE
    include 'rodape.php';
?>
