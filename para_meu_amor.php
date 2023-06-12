<?php

    session_start();	
    
    //PHP GERAL

    //PAGINA ATUAL
    $_SESSION['pagina_acesso'] = substr($_SERVER["PHP_SELF"],1,30);

    //CORRIGE PROBLEMAS DE HEADER (LIMPAR O BUFFER)
    ob_start();

    //VARIAVEIS NOME
    @$nome = $_SESSION['usuarioNome'];
    @$pri_nome = substr($nome, 0, strpos($nome, ' '));

    //ACESSO RESTRITO
    //include 'acesso_restrito.php';    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="img/logo/icone_santa_casa_sjc_colorido.png">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Para meu Amor</title>
    <!--CSS-->
    <?php 
        include 'css/style.php';
        include 'css/style_mobile.php';
    ?>

    </script>
    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <!--<script src="https://kit.fontawesome.com/302b2cb8e2.js" crossorigin="anonymous"></script>-->
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">

    <!--GRAFICOS CHART JS -->
    <script src="js/chartjs_3_7_1.min.js"> </script>

    <!--JQUERY-->    
    <script src="js/jquery_3_6_4.min.js"></script>

</head>
<body>
    <header>    

    <div id="id_cabecalho_topo">
        <nav class="navbar navbar-expand-md navbar-dark bg-color">
            <a class="navbar-brand" href="home.php">
                <img src="img/logo/icone_santa_casa_sjc_branco.png" height="28px" width="28px" class="d-inline-block align-top efeito-zoom" alt="Santa Casa de São José dos Campos">
                <h10>Conta Fat</h10>
            </a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample06" aria-controls="navbarsExample06" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarsExample06">
                <ul class="navbar-nav">          
                <li class="nav-item active">
                    <a class="nav-link" href="#"> <span class="sr-only">(current)</span></a>
                </li>
                <div class="menu_azul_claro">
                    <li class="nav-item" style="cursor: pointer;">

                        <h10> 
                            <a style="float:left; padding: 16px 8px 16px 16px !important;" class="nav-link" onclick="ajax_oculta_cabecalho_rodape()"> <i class="fa-solid fa-expand efeito-zoom"></i></a>
                            <a style="float:left; padding: 16px 16px 16px 8px !important;" class="nav-link" onclick="ajax_redireciona_easter_egg('1')"><i class="fa-regular fa-circle-question efeito-zoom" aria-hidden="true"></i> Faq</a>
                        </h10>

                    </li>
                </div>         
                
                <div class="menu_preto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown06" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="conta_click('2')">
                        <i class="fa fa-bars" aria-hidden="true"></i> Menu</a></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown06">

                        <!--MENU-->     

                            <a class="dropdown-item" style="background-color: #f5f5f5;" href="javascript:void(0)"><i class="fa-solid fa-user"></i> Conta Fat</a> 
                            <a class="dropdown-item" href="home.php"><i class="fa-solid fa-table-columns"></i> Painel</a>

                            <?php if($_SESSION['SN_USUARIO_ADM_FATURAMENTO'] == 'S'){ ?>

                                <a class="dropdown-item" style="background-color: #f5f5f5;" href="javascript:void(0)"><i class="fa-solid fa-user-gear"></i> Administrador</a> 
                                <a class="dropdown-item" href="faturista.php"><i class="fa-solid fa-clipboard-user"></i> Faturista</a>

                            <?php } ?>

                        </div>
                    </li>
                </div>
                </li>
                <div class="menu_perfil">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown06" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-regular fa-circle-user" aria-hidden="true"></i> <?php echo $pri_nome ?></a></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown06">
                        <a class="dropdown-item" href="sair.php"> <i class="fa fa-sign-out" aria-hidden="true"></i> Sair</a>
                        </div>
                    </li>
                <div class="menu_vermelho">
                </ul>
            </div>
        </nav>

    </div>

    </header>
    <main>

        <div class="conteudo" style="background-image: url('img/coracao.png');
                background-repeat: repeat;
                background-size: auto;"
>
            <div class="container" >


<div style="background-color: #f9f9f9; text-align: center; width: max-content; margin: 0 auto; border: dashed 2px red; padding: 6px;">
<h11><i class="far fa-heart" aria-hidden="true"></i> <i class="far fa-heart" aria-hidden="true"></i> <i class="far fa-heart" aria-hidden="true"></i> 
Bruna & Heitor
<i class="far fa-heart" aria-hidden="true"></i> <i class="far fa-heart" aria-hidden="true"></i> <i class="far fa-heart" aria-hidden="true"></i></h11>
</div>
<div class="div_br"></div>
<div class="div_br"></div>


    <div class="row justify-content-md-center" >

        <?php
        
        //CONTADOR
        $contador = 1;

        //BUSCANDO ARQUIVOS DE IMAGENS
        $types = array( 'png', 'jpg', 'jpeg', 'gif', 'webp');
        $path = 'img/bruna';


        $dir = new DirectoryIterator($path);
        foreach ($dir as $fileInfo) {
            if (!$fileInfo->isDot()) {
                /* we need to clone a fileInfo object into array, not just assign it */
                $allFilesInfo[] = clone $fileInfo;
            }

        }

        function cmp($a, $b)
        {
            return strcmp($a->getFilename(), $b->getFilename());
        }    

        /* Alphabetically sorting the array with DirectoryIterator objects, by filename */
        usort($allFilesInfo, 'cmp');

        foreach ($allFilesInfo as $fileInfo) {

            $ext = strtolower( $fileInfo->getExtension() );

            if(strlen($ext) > 1) {
                $imagem = $path . '/' . $fileInfo->getFilename();
                
        ?>

                <div class="col-6 col-md-3 col-lg-2 col-sm-6" style="background-color: #f9f9f9 !important;
                border: dashed 1px red;">

                    <!--IMAGEM 01-->
                    <a style="height: 30px !important; padding: 0px 6px 0px 6px;" 
                    data-toggle="modal" data-target="#detalhejust<?php echo $contador;?>">

                        <img src="<?php echo $imagem;?>" alt="Feng Shui" class="img_foto_pequena">  

                    </a>

                    <div class="modal" tabindex="-1" role="dialog" id="detalhejust<?php echo $contador;?>">
                        <div class="modal-dialog" role="document" style="margin: 0 auto !important;">
                            <div class="modal-content" 
                            style="padding: 0 !important; margin:0 !important; background-color: rgb(0, 0, 0, 0); border: none;">
                                    
                                <div class="modal-body" style="text-align: center !important">                         

                                    <div>
                                        <div style='margin: 0 auto; width: 100%; height: 86vh; 
                                        background-repeat: no-repeat; background-size:contain; 
                                        background-position:center top;
                                        background-image: url("<?php echo $imagem;?>")'>

                                            <div style="margin: 0 auto; width: 100%; line-heigth: 20px;">

                                                <a style="text-decoration: none;" class="botoes_modal anterior<?php echo $contador;?>"> 
                                                    <i class="fas fa-angle-left"></i> Anterior</i>
                                                <a>

                                                <a style="text-decoration: none;" class="botoes_modal fechar<?php echo $contador;?>">
                                                    <i class="far fa-heart"></i>
                                                </a>

                                                <a style="text-decoration: none;" class="botoes_modal proximo<?php echo $contador;?> "> 
                                                    Próximo <i class="fas fa-angle-right"></i></i>
                                                </a>  

                                            </div>

                                        </div>
                                    </div>                                                 

                                </div>
                                                                            
                            </div>

                        </div>
                                
                    </div>

                </div>

                <script>

                $(function () {
                    $(".fechar<?php echo $contador;?>").on('click', function() {
                        $('#detalhejust<?php echo $contador;?>').modal('hide');
                    });
                });

                $(function () {
                    $(".anterior<?php echo $contador;?>").on('click', function() {
                        $('#detalhejust<?php echo $contador - 1;?>').modal('show');
                        $('#detalhejust<?php echo $contador;?>').modal('hide');
                    });
                });

                $(function () {
                    $(".proximo<?php echo $contador;?>").on('click', function() {
                        $('#detalhejust<?php echo $contador + 1;?>').modal('show');
                        $('#detalhejust<?php echo $contador;?>').modal('hide');
                    });
                });

                </script>

        <?php $contador = $contador + 1; } } ?>

    </div>

    <br><br>

    <div style="width: 100%; margin:0 auto; padding: 6px; border: dashed 2px red; text-align: center;
    background-color: #f9f9f9;">

    <br>É triste que palavras jamais irão expressar
    <br>tudo aquilo que sinto por você
    <br>O seu sorriso brilha mais que o sol do meio dia
    <br>Meus olhos eram negros
    <br>Mas clarearam depois que te viram
    <br>E eu fiquei cego...
    <br>Cego de paixão
    <br><br>
    
    </div>

     






<script>

window.addEventListener('load', function() {
        var evento = new KeyboardEvent('keydown', { key: 'Escape' });
        document.dispatchEvent(evento);
    });

</script>


<?php
    //RODAPE
    include 'rodape.php';
?>
