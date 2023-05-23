</div>  <!-- FIM CLASS CONTAINER -->
    
    </div> <!-- FIM CLASS CONTEUDO -->
    
    </main>

    <!--RODAPE -->
    <footer id="id_rodape" class="footer-bs">
        <div class="row">
        	<div class="col-md-5 footer-brand animated fadeInLeft">
            
            	<h2> <img src="img/logo/icone_santa_casa_sjc_branco.png" height="28px" width="28px"  alt="Santa Casa de São José dos Campos">
                Santa Casa de </br>
                    São José dos Campos
                </h2>
                <p>Temos toda estrutura para o seu tratamento médico, análise de exames, exames de alta complexabilidade e internações. 
                   Atendemos todas as idades com nosso corpo de médicos e especialistas. Nossas instalações estão prontas para lhe atender e proporcionar o máximo de conforto.</p>
                <p>Projeto desenvolvido pela equipe de Tecnologia.</p>
            </div>
        	<div class="col-md-4 footer-nav animated fadeInUp">
            	<h4>Menu</h4>
            	<div class="col-md-10">
                
                    <ul class="pages">
                        <li><a href="home.php">Home</a></li>                           
                    </ul>

                </div>
            	<div class="col-md-10">
                    <ul class="list">
                        <li><a href="sair.php">Sair</a></li>
                    </ul>
                </div>
            </div>
        	<div class="col-md-3 footer-social animated fadeInDown">
            	<h4>Outros Projetos</h4>
            	<ul>
                	<li><a target="_blank" href="http://10.200.0.50:8080/portal_projetos/portfolio_att.php">Conheça nosso portfólio</a></li>
                </ul>
            </div>
        </div>


    <!--SUBIR AO TOPO-->
    <a id="subirTopo">
        <i class="fa fa-chevron-circle-up" aria-hidden="true"></i>
    </a>

     <!--SUBIR AO TOPO-->
     <a id="subirTopo">
        <i class="fa fa-chevron-circle-up" aria-hidden="true"></i>
    </a>

    </footer>
    
    <!--BOOTSTRAP JAVASCRIPT-->  
    <script src="bootstrap/js/bootstrap.min.js"></script> 

    <!--JAVASCRIPTS-->
    <script src="js/scripts.js"></script>  

</body>
</html>

<script>

    function ajax_oculta_cabecalho_rodape(){

        var navcabecalho = document.getElementById("id_cabecalho_topo");

        if (navcabecalho.style.display === "none") {

            navcabecalho.style.display = "block";

        } else {

            navcabecalho.style.display = "none";

        }     

        var divrodape = document.getElementById("id_rodape");

        if (divrodape.style.display === "none") {

            divrodape.style.display = "block";

        } else {

            divrodape.style.display = "none";

        }  

    }

    document.onkeydown = function(evt) {
        evt = evt || window.event;
        var isEscape = false;
        if ("key" in evt) {
            isEscape = (evt.key === "Escape" || evt.key === "Esc");
        } else {
            isEscape = (evt.keyCode === 27);
        }
        if (isEscape) {
            ajax_oculta_cabecalho_rodape();
        }
    };

    if(navigator.userAgent.match(/Android/i)){
        window.scrollTo(0,1);
    }

</script>