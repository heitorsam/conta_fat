<?php 
    //CABECALHO
    include 'cabecalho.php';

    //ACESSO ADM
    //include 'acesso_restrito_adm.php';

    //AJAX ALERTA
    include 'config/mensagem/ajax_mensagem_alert.php';

?>

    <!--MENSAGENS-->
    <?php
        include 'js/mensagens.php';
        include 'js/mensagens_usuario.php';
    ?>

    <h11><i class="fa-solid fa-clipboard-user"></i> Faturista</h11>
    <div class='espaco_pequeno'></div>
    <h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply efeito-zoom" aria-hidden="true"></i> Voltar</a></h27>

    <div id="mensagem_acoes"></div>

    <div class="row">

        <div class="col-6 col-md-3" style="background-color: rgba(1,1,1,0) !important;">

            Cadastrar:
            <input id="inpt_cracha" type="text" placeholder="ex. 000001249800"class="form-control">

        </div>

        <div class="col-6 col-md-4" style="background-color: rgba(1,1,1,0) !important;">

            <div id="div_usu_resumido"></div>

        </div>        

    </div>

    <div id="div_cad_faturista"></div>

    <div id="div_lista_faturista"></div>
    
<script>

    var timeoutId;

    $('#div_lista_faturista').load('funcoes/usuario/ajax_exibe_lista_faturista.php');

    function fnc_busca_usu_mv_resumido(){

        $("#div_cad_faturista").empty();

        var js_cracha = document.getElementById('inpt_cracha').value;

        $('#div_usu_resumido').load('funcoes/usuario/ajax_exibe_nm_resumido.php?varcracha='+js_cracha, function() {

            var js_nm_resumido = document.getElementById('id_nm_resumido');

            var nomeresum = js_nm_resumido.value.toLowerCase();
            var partesNome = nomeresum.split(" ");
            var capitalizedParts = partesNome.map(function(part) {
            return part.charAt(0).toUpperCase() + part.slice(1);
            });
            var capnomeresum = capitalizedParts.join(" ");

            if(js_nm_resumido !== null){

            $('#div_cad_faturista').load('funcoes/usuario/ajax_exibe_cad_faturista.php?varcracha='+js_cracha, function(){
                
                $("#div_simula_cores").append("<div class='mini_caixa_painel'>"+capnomeresum+"</div>");
                console.log("Conteúdo adicionado à #div_simula_cores");

            });

            }else{

                $("#div_cad_faturista").empty();

            }

        });     

    }

    function ajax_atualiza_cores(){

        $("#div_simula_cores").empty();

        var js_nm_resumido = document.getElementById('id_nm_resumido');
        var js_cor_fundo = document.getElementById('rgb_fundo');
        var js_cor_fonte = document.getElementById('rgb_fonte');

        var nomeresum = js_nm_resumido.value.toLowerCase();
        var partesNome = nomeresum.split(" ");
        var capitalizedParts = partesNome.map(function(part) {
        return part.charAt(0).toUpperCase() + part.slice(1);
        });
        var capnomeresum = capitalizedParts.join(" ");

        $("#div_simula_cores").append("<div class='mini_caixa_painel' style='background-color:"+js_cor_fundo.value+"; color: "+js_cor_fonte.value+";'>"+capnomeresum+"</div>");
    }

    document.getElementById('inpt_cracha').addEventListener('keydown', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(fnc_busca_usu_mv_resumido, 1000); //1 seg
    });


    function ajax_cad_faturista(){

        var js_cracha = document.getElementById('inpt_cracha').value;
        var js_cor_fundo = document.getElementById('rgb_fundo').value;
        var js_cor_fonte = document.getElementById('rgb_fonte').value;

        //alert(js_cracha + ' | ' + js_cor_fundo + ' | ' + js_cor_fonte);

        $.ajax({
            url: "funcoes/usuario/ajax_insert_faturista.php",
            type: "POST",
            data: {

                usuario: js_cracha,
                fundo: js_cor_fundo,
                fonte: js_cor_fonte

                },
            cache: false,
            success: function(dataResult){

                console.log(dataResult);

                if(dataResult == 'Sucesso'){

                    ajax_atualiza_lista_faturista();

                    //MENSAGEM            
                    var_ds_msg = 'Faturista%20cadastrado%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                    //var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);
                    

                }else{
                  
                    //LIMPA A TELA
                    document.getElementById('inpt_cracha').value = '';
                    $('#div_usu_resumido').empty();
                    $("#div_cad_faturista").empty();     
                    
                    //ATUALIZA LISTA
                    $('#div_lista_faturista').load('funcoes/usuario/ajax_exibe_lista_faturista.php');

                    //MENSAGEM            
                    var_ds_msg = 'Erro%20ao%20cadastrar%20a%20faturista!';
                    //var_tp_msg = 'alert-success';
                    var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);
                
                
                }  

            }

        }); 
        
    }   
    
    
    function ajax_exclui_faturista(js_cd_faturista){

        $.ajax({
            url: "funcoes/usuario/ajax_exclui_faturista.php",
            type: "POST",
            data: {

                cd_faturista: js_cd_faturista

                },
            cache: false,
            success: function(dataResult){

                console.log(dataResult);

                if(dataResult == 'Sucesso'){
                    
                    ajax_atualiza_lista_faturista();

                    //MENSAGEM            
                    var_ds_msg = 'Faturista%20excluído%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                    //var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);
                    

                }else{
                
                    ajax_atualiza_lista_faturista();

                    //MENSAGEM            
                    var_ds_msg = 'Erro%20ao%20cadastrar%20a%20faturista!';
                    //var_tp_msg = 'alert-success';
                    var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);
                
                
                }  

            }

        }); 

    }


    function ajax_atualiza_lista_faturista(){

        //LIMPA A TELA
        document.getElementById('inpt_cracha').value = '';

        $('#div_usu_resumido').empty();
        $("#div_cad_faturista").empty();     
        
        //ATUALIZA LISTA
        $('#div_lista_faturista').load('funcoes/usuario/ajax_exibe_lista_faturista.php');

    }

    function ajax_inativa(js_cd_faturista, js_status){

        $.ajax({

            url: "funcoes/usuario/ajax_inativa_faturista.php",
            type: "POST",
            data: {
                
                codigo : js_cd_faturista,
                status: js_status
                
            },

            cache: false,
            success: function(dataResult){

            console.log(dataResult);

                if(dataResult == 'Sucesso'){

                    //alert(var_beep);
                    //MENSAGEM            
                    var_ds_msg = 'Status%20alterado%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                    //var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

                    ajax_atualiza_lista_faturista();

                }else {

                    //alert(var_beep);
                    //MENSAGEM            
                    var_ds_msg = 'Ocorreu%20um%20erro%20ao%20alterar%20o%20status!';
                    //var_tp_msg = 'alert-success';
                    var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

                    ajax_atualiza_lista_faturista();
                }

            }

        }); 

    }

</script>

<?php
    //RODAPE
    include 'rodape.php';
?>
