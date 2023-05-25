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


</br>
Pega aqui
<div  ondrop="drop(event)" ondragover="allowDrop(event)"
style="width: 300px; height: 200px; border: solid 1px black; padding: 4px;">


    <div id="id_teste_div_pink" ondragstart="drag(event)" draggable="true"
    style="width: 100px; height: 100px; border: solid 5px pink;" >

    </div>


</div>

</br>
Joga aqui:

<div ondrop="drop(event)" ondragover="allowDrop(event)"
style="width: 300px; height: 200px; border: solid 1px black; padding: 4px;">




</div>



<script defer>

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
  ev.target.appendChild(document.getElementById(js_drag_id_objeto));
  //alert('aqui abre model com o id ' + js_drag_id_objeto);
  alert('arrastou!');

}


</script>

<?php
    //RODAPE
    include 'rodape.php';
?>
