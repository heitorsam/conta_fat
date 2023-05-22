<!--ATUALIZA A PAGINA (SEGUNDOS)-->
<meta http-equiv="refresh" content="60">

<?php 
    //CABECALHO
    include 'cabecalho.php';

    //ACESSO ADM
    //include 'acesso_restrito_adm.php';
?>

    <div class="div_br"> </div>

    <!--MENSAGENS-->
    <?php
        include 'js/mensagens.php';
        include 'js/mensagens_usuario.php';
    ?>

    <h11 style="margin-left: 10px;"><i class="fa-regular fa-clipboard efeito-zoom"></i> Conta Fat</h11>
    <div class="div_br"> </div>

    <div class="row">

        <div class="col-6 col-md-3" style="text-align: left; padding: 0px; background-color: rgba(1,1,1,0) !important;"> 
            Alta Início:
            <input id="dt_ini" onchange="ajax_carrega_painel_geral()" type="date" class="form-control">
        </div>

        <div class="col-6 col-md-3" style="text-align: left; padding: 0px; padding-left: 20px; background-color: rgba(1,1,1,0) !important;"> 
            Alta Fim:
            <input id="dt_fin" onchange="ajax_carrega_painel_geral()" type="date" class="form-control">
        </div>

    </div>


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

        var data_ontem = new Date();
        data_ontem.setDate(data_ontem.getDate() -1);

        document.getElementById('dt_ini').valueAsDate = data_ontem;
        document.getElementById('dt_fin').valueAsDate = data_ontem;

        ajax_carrega_painel_geral();

    }

    function ajax_carrega_painel_geral(){

        var js_dt_ini = document.getElementById('dt_ini').value;
        var js_dt_fin = document.getElementById('dt_fin').value;

        $('#div_painel_geral').load('funcoes/painel/ajax_painel_geral.php?dtini='+js_dt_ini+'&dtfin='+js_dt_fin);

    }

</script>

<?php
    //RODAPE
    include 'rodape.php';
?>
