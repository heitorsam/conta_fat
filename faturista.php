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

    <h11><i class="fa-solid fa-clipboard-user"></i> Faturista</h11>
    <div class='espaco_pequeno'></div>
    <h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply efeito-zoom" aria-hidden="true"></i> Voltar</a></h27>


    <div class="div_br"> </div>

    <div class="row">

        <div class="col-6 col-md-3" style="background-color: rgba(1,1,1,0) !important;">

            Crachá:
            <input id="inpt_cracha" type="text" class="form-control">

        </div>

        <div class="col-6 col-md-4" style="background-color: rgba(1,1,1,0) !important;">

            <div id="div_usu_resumido"></div>

        </div>        

    </div>

    <div id="div_cad_faturista"></div>
    
<script>

    var timeoutId;

    function fnc_busca_usu_mv_resumido(){

        var js_cracha = document.getElementById('inpt_cracha').value;

        $('#div_usu_resumido').load('funcoes/usuario/ajax_exibe_nm_resumido.php?varcracha='+js_cracha, function() {

            var js_nm_resumido = document.getElementById('id_nm_resumido');

            if(js_nm_resumido !== null){

            $('#div_cad_faturista').load('funcoes/usuario/ajax_exibe_cad_faturista.php?varcracha='+js_cracha);

            }else{

                $("#div_cad_faturista").empty();
            }

        });
     

    }

    document.getElementById('inpt_cracha').addEventListener('keydown', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(fnc_busca_usu_mv_resumido, 1000); //1 seg
    });

</script>

<?php
    //RODAPE
    include 'rodape.php';
?>
