    <?php

        $var_cd_fat = $_GET['varcdfaturista'];
        $var_rgb_fundo = $_GET['varfundo'];
        $var_rgb_fonte = $_GET['varfonte'];
        $var_nm_resumido = str_replace("_"," ",$_GET['varresumido']);

    ?>

    <input id="input_faturista_atual" value="<?php echo $var_cd_fat; ?>" hidden>
        
    <div class="row">

        <div class="col-12 col-md-6" style="background-color: rgba(1,1,1,0) !important; padding-top: 0px !important;">

            Fundo:
            <input value="#<?php echo $var_rgb_fundo; ?>" type="color" id="rgb_fundo_editar" class="form form-control" onchange="ajax_atualiza_cores_editar('<?php echo $var_nm_resumido; ?>')">

        </div>

        <div class="col-12 col-md-6" style="background-color: rgba(1,1,1,0) !important; padding-top: 0px !important;">

            Fonte:
            <input value="#<?php echo $var_rgb_fonte; ?>" type="color" id="rgb_fonte_editar" class="form form-control" onchange="ajax_atualiza_cores_editar('<?php echo $var_nm_resumido; ?>')">

        </div>      
        

        <!--
        <div class="col-4 col-md-2" style="background-color: rgba(1,1,1,0) !important; padding-top: 0px !important;">

            </br>
            <button class="btn btn-primary" onclick="ajax_faturista_editar_cor()"><i class="fa-solid fa-plus"></i> Adicionar</button>

        </div>  
        --> 

    </div>

    <div class="row">

        <div class="col-12" style="background-color: rgba(1,1,1,0) !important; padding-top: 0px !important;">

        <div class="bloco_painel" style="min-height: 80px !important; width: 160px; margin: 0 auto;">

        <div class="titulo_painel" >

            <div class="divtitulo">

                Exemplo

            </div>

            <div class="divciruculo">

                <span class="numerocomcirculo"><span>22</span></span>

            </div>                       

        </div>

        <div style="min-width: 100%; min-height: 82px; background-color: rgba(1,1,1,0);">

                <div class="itens_painel_comum">

                    <div id="div_simula_cores_editar">                        
                    </div>       
                    <div style="clear: both;"></div>
                    <div class="mini_caixa_painel">123456</div>  
                    <div class="mini_caixa_painel">Paciente</div>
                    <div class="mini_caixa_painel">Convênio</div> 
                    <div class="mini_caixa_painel">...</div> 
                    <div style="clear: both;"></div>

                </div>            

        <div>

    </div>

        </div>

    </div>