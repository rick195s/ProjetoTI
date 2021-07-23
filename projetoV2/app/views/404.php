<div class="container-fluid bg-danger justify-content-center d-flex" id="container-403">
    <div class="row d-block ">
        <lord-icon alt="danger" class="icon-danger" src="https://cdn.lordicon.com//tdrtiskw.json" trigger="loop"
                   colors="primary:#ffffff,secondary:#ffffff">
        </lord-icon>
        <h4 class="alert-heading">Página não encontrada!</h4>
        <p>Irá ser redirecionado para a página de login em 5 segundos</p>
    </div>

</div>
<?php
$this->title="Página não encontrada";
header("refresh:5;url=". $this->path ."auth"); ?>