<?php

    //CHAMANDO A CONEXAO    
    include '../../conexao.php';

    //EXECUTANDO COMANDOS NO ORACLE
    $consulta_select = "SELECT fat.*, 
                        (SELECT INITCAP(LOWER(REGEXP_SUBSTR (usu.NM_USUARIO, '^\w+') || ' ' ||
                                      REGEXP_SUBSTR (usu.NM_USUARIO, '\w+$'))) AS NM_RESUMIDO
                        FROM dbasgu.USUARIOS usu
                        WHERE usu.CD_USUARIO = fat.CD_USUARIO) AS NM_USUARIO_RESUMIDO,
                        (SELECT COUNT(mv.CD_MOVIMENTACAO) AS QTD
                        FROM conta_fat.MOVIMENTACAO mv
                        WHERE mv.CD_USUARIO_ORIGEM = fat.CD_USUARIO
                        OR mv.CD_USUARIO_DESTINO = fat.CD_USUARIO
                        ) AS QTD_ACOES
                        FROM conta_fat.FATURISTA fat
                        ORDER BY fat.CD_FATURISTA DESC";

    $result_select = oci_parse($conn_ora, $consulta_select);

    oci_execute($result_select);


    echo '<table class="table table-striped" style="text-align: center;">';

        echo '<thead>';
            
            echo '<th style="text-align: center;"> Código</th>';
            echo '<th style="text-align: center;"> Usuário</th>';
            echo '<th style="text-align: center;"> Nome</th>';
            echo '<th style="text-align: center;"> Exemplo</th>';  
            echo '<th style="text-align: center;"> Status</th>';                      
            echo '<th style="text-align: center;"> Ações</th>';
            
        echo '</thead>';

        echo '<tbody>';           

            while($row_ficha = oci_fetch_array($result_select)){

                echo '<tr>';
                
                    echo '<td class="align-middle" style="text-align: center;">' . $row_ficha['CD_FATURISTA'] . '</td>';
                    echo '<td class="align-middle" style="text-align: center;">' . $row_ficha['CD_USUARIO'] . '</td>';
                    echo '<td class="align-middle" style="text-align: center;">' . $row_ficha['NM_USUARIO_RESUMIDO'] . '</td>';
                    echo '<td class="align-middle" style="text-align: center;">' 
                    . "<div class='mini_caixa_painel' style='float: none !important; margin: 0 auto !important; width: max-content; background-color:" . $row_ficha['RGB_FUNDO'] . "; color: " . $row_ficha['RGB_FONTE'] . ";'>" . $row_ficha['NM_USUARIO_RESUMIDO'] . "</div>"
                    . '</td>';

                    if($row_ficha['SN_ATIVO'] == 'A'){

                        echo '<td class="align-middle" style="text-align: center;">' . '<i style=" color: #79c332; cursor: pointer; font-size: 20px;" class="fa-solid fa-toggle-on"' ;
    
                        ?>
    
                            onclick="ajax_alert('Deseja alterar o status?','ajax_inativa(<?php echo $row_ficha['CD_FICHA_INSPECAO']; ?>,1)')"
    
                        <?php
    
                       echo '></i>' . '</td>';                   
                    
                    }else{
    
                        echo '<td class="align-middle" style="text-align: center;">' . '<i style=" color: #dd9696; cursor: pointer; font-size: 20px; "class="fa-solid fa-toggle-off"' ;
    
                        ?>
    
                            onclick="ajax_alert('Deseja alterar o status?','ajax_inativa(<?php echo $row_ficha['CD_FICHA_INSPECAO']; ?>,2)')"
    
                        <?php
    
                       echo '></i></button>' . '</td>';
    
                    }                       
                    

                    echo '<td class="align-middle" style="text-align: center;">';

                    if($row_ficha['QTD_ACOES'] == 0){

                        echo '  <a class="btn btn-adm"';

                        ?>
    
                            onclick="ajax_alert('Deseja excluir a ficha?','ajax_exclui_cad_ficha(<?php echo $row_ficha['CD_FICHA_INSPECAO']; ?>,2)')"
    
                        <?php
                                        
                        echo ')"> <i class="fa-solid fa-trash"></i> </a>';

                    }else{

                        echo '  <a class="btn btn-secondary" > <i class="fa-solid fa-trash"></i> </a>';
                    
                    }
                  
                    echo '</td>';


                echo '</tr>';

            }           

        echo '</tbody>';

    echo '</table>';

?>