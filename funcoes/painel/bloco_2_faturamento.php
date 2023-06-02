<?php 

    //TOTAL

    $cons_total = "SELECT LPAD(NVL(COUNT(dc.CD_ATENDIMENTO),0),2,0) AS QTD_TOTAL
                   FROM conta_fat.VDIC_DETALHE_CONTA_FAT dc
                   WHERE TO_CHAR(TO_DATE(dc.DT_ALTA,'DD/MM/YYYY'),'YYYY-MM-DD') BETWEEN '$var_dt_ini' AND '$var_dt_fin'
                   AND dc.CD_PROTOCOLO || '_' || dc.CD_ATENDIMENTO NOT IN (SELECT CD_PROTOCOLO FROM conta_fat.CONTA WHERE TP_STATUS IN ('A','C'))
                   AND dc.CD_PORTADOR_ATUAL = 2";

    $res_total = oci_parse($conn_ora,$cons_total);

    oci_execute($res_total);

    $row_tot = oci_fetch_array($res_total);

    $var_total_atd = $row_tot['QTD_TOTAL'];

    //DETALHE
    $cons_detalhe = "SELECT dc.*
                     FROM conta_fat.VDIC_DETALHE_CONTA_FAT dc
                     WHERE TO_CHAR(TO_DATE(dc.DT_ALTA,'DD/MM/YYYY'),'YYYY-MM-DD') BETWEEN '$var_dt_ini' AND '$var_dt_fin'
                     AND dc.CD_PORTADOR_ATUAL = 2
                     AND dc.CD_PROTOCOLO || '_' || dc.CD_ATENDIMENTO NOT IN (SELECT CD_PROTOCOLO FROM conta_fat.CONTA WHERE TP_STATUS IN ('A','C'))
                     ORDER BY dc.DT_ALTA ASC";

    $res_detalhe = oci_parse($conn_ora,$cons_detalhe);

    oci_execute($res_detalhe);

    echo '<div class="bloco_painel">';

        echo '<div class="titulo_painel" >';

            echo '<div class="divtitulo">';

                echo 'Faturamento';

            echo '</div>';

            echo '<div class="divciruculo">';

                echo '<span class="numerocomcirculo"><span>' . $var_total_atd . '</span></span>';

            echo '</div>';                       

        echo '</div>';

        while($row_det = oci_fetch_array($res_detalhe)){

            if($row_det['SN_ALERTA'] == 'N'){

                $var_tp_itens_painel = 'itens_painel_comum';

            }else{

                $var_tp_itens_painel = 'itens_painel_alerta';

            }

            echo '<div id="' . $row_det['CD_PROTOCOLO'] . '_' . $row_det['CD_ATENDIMENTO'] . '"';

            ?>

            ondragstart="drag(event)" draggable="true"
            
            <?php
            echo 'class="' .$var_tp_itens_painel . '">';

                echo '<div ondragover="allowDrop(event)"  class="mini_caixa_painel" style="word-wrap: break-word !important;">' . $row_det['CD_ATENDIMENTO'] . '</div>';  
                if($var_ck_dt_alta == 'true'){ echo '<div class="mini_caixa_painel">' . $row_det['DT_ALTA'] . '</div>'; }
                if($var_ck_paciente == 'true'){ echo '<div class="mini_caixa_painel">' . $row_det['NM_PACIENTE'] . '</div>'; }
                if($var_ck_convenio == 'true'){ echo '<div class="mini_caixa_painel">' . $row_det['NM_CONVENIO'] . '</div>'; }
                if($var_ck_dt_alta == 'true'){ echo '<div class="mini_caixa_painel">' . $row_det['DS_UNID_INT'] . '</div>'; }                
                echo '<div style="clear: both;"></div>';

            echo '</div>';   
        
        }

    echo '</div>';

?>