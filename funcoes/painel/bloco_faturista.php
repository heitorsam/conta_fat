<?php

    //TOTAL
    $cons_total = "SELECT LPAD(NVL(COUNT(dc.CD_ATENDIMENTO),0),2,0) AS QTD_TOTAL
                   FROM conta_fat.VDIC_DETALHE_CONTA_FAT dc
                   WHERE dc.CD_PROTOCOLO || '_' || dc.CD_ATENDIMENTO IN (SELECT CD_PROTOCOLO FROM conta_fat.CONTA WHERE TP_STATUS IN ('A'))";

    $res_total = oci_parse($conn_ora,$cons_total);

    oci_execute($res_total);

    $row_tot = oci_fetch_array($res_total);

    $var_total_atd = $row_tot['QTD_TOTAL'];

    //DETALHE

    $cons_detalhe = "SELECT dc.*, 
                    ct.CD_CONTA,
                    fat.CD_USUARIO,
                    fat.RGB_FUNDO,
                    fat.RGB_FONTE,                
                    CASE 
                      WHEN TO_DATE(SYSDATE,'DD/MM/YYYY HH24:MI:SS') > TO_DATE(ult_mov.HR_CADASTRO + 2,'DD/MM/YYYY HH24:MI:SS') THEN 'S'
                      ELSE 'N'
                    END AS SN_ATRASO,
                    INITCAP(LOWER(REGEXP_SUBSTR (usu.NM_USUARIO, '^\w+') || ' ' ||
                            REGEXP_SUBSTR (usu.NM_USUARIO, '\w+$'))) AS NM_USUARIO_RESUMIDO,
                    (SELECT COUNT(msg.CD_MENSAGEM) AS QTD
                     FROM conta_fat.MENSAGEM msg
                     WHERE msg.TP_MENSAGEM = 'O'
                     AND msg.CD_CONTA = ct.CD_CONTA) AS QTD_MSG
                    FROM conta_fat.VDIC_DETALHE_CONTA_FAT dc
                    INNER JOIN conta_fat.CONTA ct
                    ON ct.CD_PROTOCOLO = dc.CD_PROTOCOLO || '_' || dc.CD_ATENDIMENTO
                    INNER JOIN (SELECT *
                    FROM conta_fat.MOVIMENTACAO
                    WHERE CD_MOVIMENTACAO IN (SELECT MAX_MOV FROM (SELECT CD_CONTA, MAX(CD_MOVIMENTACAO) AS MAX_MOV 
                                            FROM conta_fat.MOVIMENTACAO GROUP BY CD_CONTA))) ult_mov
                    ON ult_mov.CD_CONTA = ct.CD_CONTA
                    INNER JOIN conta_fat.FATURISTA fat
                    ON fat.CD_FATURISTA = ult_mov.CD_USUARIO_DESTINO
                    INNER JOIN dbasgu.USUARIOS usu
                    ON usu.CD_USUARIO = fat.CD_USUARIO
                    WHERE dc.CD_PROTOCOLO || '_' || dc.CD_ATENDIMENTO IN (SELECT CD_PROTOCOLO FROM conta_fat.CONTA WHERE TP_STATUS IN ('A'))
                    ORDER BY INITCAP(LOWER(REGEXP_SUBSTR (usu.NM_USUARIO, '^\w+') || ' ' ||
                            REGEXP_SUBSTR (usu.NM_USUARIO, '\w+$'))) ASC, dc.DT_ALTA ASC";

    $res_detalhe = oci_parse($conn_ora,$cons_detalhe);

    oci_execute($res_detalhe);

    echo '<div class="bloco_painel">';

        echo '<div class="titulo_painel" >';

            echo '<div class="divtitulo">';

                echo 'Faturista';

            echo '</div>';

            echo '<div class="divciruculo">';

                echo '<span class="numerocomcirculo"><span>' . $var_total_atd . '</span></span>';

            echo '</div>';                       

        echo '</div>';

        echo '<div id="div_drop" ondrop="drop(event)" ondragover="allowDrop(event)"
               style="min-width: 100%; min-height: 250px; background-color: rgba(1,1,1,0);">';

            while($row_det = oci_fetch_array($res_detalhe)){

                if($row_det['SN_ATRASO'] == 'N'){

                    $var_tp_itens_painel = 'itens_painel_comum';

                }else{

                    $var_tp_itens_painel = 'itens_painel_alerta';

                }

                if($row_det['CD_USUARIO'] == $_SESSION['usuarioLogin']){

                    //SO PODE ARRASTAR QUEM FOR DONO DA CAIXA
                    echo '<div id="' . $row_det['CD_CONTA'] . '" class="' . $var_tp_itens_painel . '" ondragstart="drag_faturista(event)" draggable="true">';

                }else{

                    echo '<div id="' . $row_det['CD_CONTA'] . '" class="' . $var_tp_itens_painel . '">';

                }
                    echo "<div class='mini_caixa_painel' style='width: max-content; 
                                                        background-color:" . $row_det['RGB_FUNDO'] . "; 
                                                        color: " . $row_det['RGB_FONTE'] . ";'>" . 
                        $row_det['NM_USUARIO_RESUMIDO']; 
                    
                    echo "</div>";

                    if($row_det['CD_USUARIO'] == $_SESSION['usuarioLogin']){
                        
                        $var_sn_autoriza = 1;

                        $var_style_fundo_obs = "mini_caixa_painel_icone";

                        if($row_det['QTD_MSG'] <> 0){
                            
                            $var_style_fundo_obs = "mini_caixa_painel_icone_dado";
                        
                        }

                        echo '<div onclick="ajax_abre_modal_obs(' . $row_det['CD_CONTA'] . ',' . $row_det['QTD_MSG'] . ',' . $var_sn_autoriza . ')" class="' . $var_style_fundo_obs . '" style="word-wrap: break-word !important; ">' 
                        . ' <i class="fa-solid fa-book"></i> </div>';

                    }else{

                        $var_sn_autoriza = 0;

                        $var_style_fundo_obs = "mini_caixa_painel_icone";

                        echo '<div onclick="ajax_abre_modal_obs(' . $row_det['CD_CONTA'] . ',' . $row_det['QTD_MSG'] . ',' . $var_sn_autoriza . ')" class="' . $var_style_fundo_obs . '" style="word-wrap: break-word !important; ">' 
                        . ' <i class="fa-solid fa-book"></i> </div>';

                    }

                    echo "<div style='clear: both;'></div>";

                    echo '<div class="mini_caixa_painel" style="word-wrap: break-word !important;">' . $row_det['CD_ATENDIMENTO'] . '</div>';  
                    if($var_ck_dt_alta == 'true'){ echo '<div class="mini_caixa_painel">' . $row_det['DT_ALTA'] . '</div>'; }
                    if($var_ck_paciente == 'true'){ echo '<div class="mini_caixa_painel">' . $row_det['NM_PACIENTE'] . '</div>'; }
                    if($var_ck_convenio == 'true'){ echo '<div class="mini_caixa_painel">' . $row_det['NM_CONVENIO'] . '</div>'; }
                    if($var_ck_unid_int == 'true'){ echo '<div class="mini_caixa_painel">' . $row_det['DS_UNID_INT'] . '</div>'; }                
                    echo '<div style="clear: both;"></div>';

                echo '</div>';   
            
            }            

        echo '</div>';

    echo '</div>';

?>