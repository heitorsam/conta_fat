<!--ATUALIZA A PAGINA (SEGUNDOS)-->
<meta http-equiv="refresh" content="300">

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

    <div id="mensagem_acoes"></div>

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
        <input id="ck_convenio" onchange="ajax_carrega_painel_geral()" type="checkbox" style="margin-left: 5px;"> <label>Convênio</label>
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

    <!--MODAL EDITAR COR-->
    <div class="modal fade" id="modalselfat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content"  style="width: 600px !important; margin: 0 auto;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Selecione o faturista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="div_sel_fat"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> Fechar</button>
                <button id="id_btn_salvar_sel_fat" onclick="ajax_delega_faturista()" type="button" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
            </div>
            </div>
        </div>
    </div>

    <!--MODAL OBSERVACAO-->
    <div class="modal fade" id="modalobsfat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content"  style="width: 600px !important; margin: 0 auto;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Observação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="div_obs_fat"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> Fechar</button>
                <button id="id_btn_salvar_obs_fat" onclick="ajax_salva_obs_fat()" type="button" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
            </div>
            </div>
        </div>
    </div>    

<script defer>

    window.onload = function(){

        //VERIFICANDO SE EXISTE SESSAO
        var js_ss_dt_ini = sessionStorage.getItem("sessao_dt_ini"); 
        var js_ss_dt_fin = sessionStorage.getItem("sessao_dt_fin"); 
        var js_ss_ck_dt_alta = sessionStorage.getItem("sessao_ck_dt_alta");
        var js_ss_ck_unid_int = sessionStorage.getItem("sessao_ck_unid_int"); 
        var js_ss_ck_paciente = sessionStorage.getItem("sessao_ck_paciente");   
        var js_ss_ck_convenio = sessionStorage.getItem("sessao_ck_convenio");           

        if(js_ss_dt_ini == null || js_ss_dt_ini == ''){

            //SE NAO HOUVER SESSAO
            var data_ontem = new Date();
            data_ontem.setDate(data_ontem.getDate() -1);

            document.getElementById('dt_ini').valueAsDate = data_ontem;
            document.getElementById('dt_fin').valueAsDate = data_ontem;

            document.getElementById('ck_dt_alta').checked = true;
            document.getElementById('ck_unid_int').checked = true;
            document.getElementById('ck_paciente').checked = true;
            document.getElementById('ck_convenio').checked = true;
            

        }else{

            //HAVENDO SESSAO
            document.getElementById('dt_ini').value = js_ss_dt_ini;
            document.getElementById('dt_fin').value = js_ss_dt_fin;

            if(js_ss_ck_dt_alta === 'true'){ document.getElementById('ck_dt_alta').checked = true; }else{ document.getElementById('ck_dt_alta').checked = false; }
            if(js_ss_ck_unid_int === 'true'){ document.getElementById('ck_unid_int').checked = true; }else{ document.getElementById('ck_unid_int').checked = false; }
            if(js_ss_ck_paciente === 'true'){ document.getElementById('ck_paciente').checked = true; }else{ document.getElementById('ck_paciente').checked = false; }
            if(js_ss_ck_convenio === 'true'){ document.getElementById('ck_convenio').checked = true; }else{ document.getElementById('ck_convenio').checked = false; }
        
        }

        ajax_carrega_painel_geral();

    }

    function ajax_carrega_painel_geral(){

        //PAGINA NO TOPO
        document.body.scrollTop = document.documentElement.scrollTop = 0;

        document.getElementById('carregando').style.display = 'block';
        document.getElementById('div_painel_geral').style.display = 'none';
        
        var js_dt_ini = document.getElementById('dt_ini').value;
        var js_dt_fin = document.getElementById('dt_fin').value;
        var js_ck_dt_alta = document.getElementById('ck_dt_alta').checked; 
        var js_ck_unid_int = document.getElementById('ck_unid_int').checked;
        var js_ck_paciente = document.getElementById('ck_paciente').checked;
        var js_ck_convenio = document.getElementById('ck_convenio').checked;     

        //DEFINE SESSOES
        sessionStorage.setItem("sessao_dt_ini",js_dt_ini); 
        sessionStorage.setItem("sessao_dt_fin",js_dt_fin);
        sessionStorage.setItem("sessao_ck_dt_alta",js_ck_dt_alta); 
        sessionStorage.setItem("sessao_ck_unid_int",js_ck_unid_int);
        sessionStorage.setItem("sessao_ck_paciente",js_ck_paciente);
        sessionStorage.setItem("sessao_ck_convenio",js_ck_convenio);

        $('#div_painel_geral').load('funcoes/painel/ajax_painel_geral.php?dtini='+js_dt_ini+'&dtfin='+js_dt_fin+'&ckdtalta='+js_ck_dt_alta+'&ckunidint='+js_ck_unid_int+'&ckpaciente='+js_ck_paciente+'&ckconvenio='+js_ck_convenio, function() {
            // definir o estilo CSS para ocultar o ícone após a conclusão da solicitação AJAX
            document.getElementById('carregando').style.display = 'none';
            document.getElementById('div_painel_geral').style.display = 'block';

        });    
  
    }

    ///////////////
    //DRAG E DROP//
    ///////////////

    function allowDrop(ev) {
        ev.preventDefault();
    }


    function drag(ev) {
        //alert(ev);
        ev.dataTransfer.setData("drag_id_objeto", ev.target.id);
    }

    function drop(ev) {

        ev.preventDefault();
        var js_drag_id_objeto = ev.dataTransfer.getData("drag_id_objeto");
        
        //esse comentario deixa o objeto na nova caixa
        //ev.target.appendChild(document.getElementById(js_drag_id_objeto));
        //alert('aqui abre model com o id ' + js_drag_id_objeto);
        //alert('arrastou! o protocolo: ' + js_drag_id_objeto);

        //alert(js_drag_id_objeto);

        //SALVANDO SESSAO PROTOCOLO
        sessionStorage.setItem("sessao_protocolo_atual",js_drag_id_objeto);

        //LIMPANDO A SESSAO
        sessionStorage.setItem("sessao_sel_fat",0);

        //BLOQUEANDO BOTAO
        document.getElementById("id_btn_salvar_sel_fat").disabled = true;

        $('#modalselfat').modal('show');  

        $('#div_sel_fat').load('funcoes/usuario/ajax_lista_fat.php');

    }

    function ajax_seleciona_faturista_opcao(js_cd_fat){

        //PEGA O VALOR DO ULTIMO SELECIONADO
        var js_ult_fat_sel = sessionStorage.getItem("sessao_sel_fat");

        //alert(js_ult_fat_sel);

        if(js_ult_fat_sel != null && js_ult_fat_sel != 0){

        //LIMPA O ULTIMO SELECIONADO
        var divfat = document.getElementById("div_fat_nome_"+js_ult_fat_sel);
            
        divfat.classList.remove("selecionado");       
        
        }

        //ADICIONA SELECIONADO ATUAL
        var divfat = document.getElementById("div_fat_nome_"+js_cd_fat);
            
        divfat.classList.add("selecionado");

        //INSERE O ATUAL PARA SER O ULTIMO NA PROXIMA
        sessionStorage.setItem("sessao_sel_fat",js_cd_fat);

        //LIBERANDO BOTAO
        document.getElementById("id_btn_salvar_sel_fat").disabled = false;

    }

    function ajax_delega_faturista(){

        //PEGANDO VALORES DA SESSAO
        var js_ult_fat_sel = sessionStorage.getItem("sessao_sel_fat");
        var js_protocolo_atual = sessionStorage.getItem("sessao_protocolo_atual");

        //alert(js_ult_fat_sel + ' | ' + js_protocolo_atual);

        //alert(js_cd_faturista_editar + ' | ' + js_cor_fundo_editar + ' | ' + js_cor_fonte_editar);

        $.ajax({
            url: "funcoes/painel/ajax_delega_faturista.php",
            type: "POST",
            data: {

                cdfat: js_ult_fat_sel,
                cdprotocolo: js_protocolo_atual

                },
            cache: false,
            success: function(dataResult){

                console.log(dataResult);

                if(dataResult == 'Sucesso'){

                    ajax_carrega_painel_geral();
                    $('#modalselfat').modal('hide');  

                    //MENSAGEM            
                    var_ds_msg = 'Faturista%20selecionado%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                    //var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);
                    
                }else{               

                    ajax_carrega_painel_geral();
                    $('#modalselfat').modal('hide');  

                    //MENSAGEM            
                    var_ds_msg = 'Erro%20ao%20selecionar%20o%20faturista!';
                    //var_tp_msg = 'alert-success';
                    var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);                
                
                }  

            }

        });       

    }

</script>

<?php
    //RODAPE
    include 'rodape.php';
?>
