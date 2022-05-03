<?php
ob_start();
if (!isset($_SESSION["check"])) {
    $_SESSION ["msg"] = "<div class='alert alert-danger alert-dismissible text-center'> "
            . "<button type='button' class='close' data-dismiss='alert'>"
            . "<span aria-hidden='true'>&times;</span>"
            . "</button><strong>Aviso!&nbsp;</stron>"
            . "Área restrita, faça login para acessar.</div>";
    header("Location: ../../index.php");
}
?>
<div class="well content">
    <?php

        if (isset($_SESSION["msg"])) {
            echo $_SESSION["msg"];
            unset($_SESSION["msg"]);
        }
    ?>
    <h1 class="text-center text-capitalize">Bem Vindo(a), <?php echo $_SESSION["credentials"]["name"]."!"; ?></h1>
</div>
<div class="well content col-sm-12">
    <?php
        var_dump(
                $_SESSION
        );
    ?>
<div class="col-sm-4">
    <h4 class="text-center">Novidades da Versão 1.0.9</h4>
    <ul>
        <li>Módulo de mensagens entre usuários.</li>
    </ul> 
</div>
<div class="col-sm-4">
    <h4 class="text-center">Novidades da Versão 1.0.8</h4>
    <ul>
        <li>Módulo de agenda para usuários.</li>
    </ul>
    
</div>
<div class="col-sm-4">
    <h4 class="text-center">Novidades da Versão 1.0.7</h4>
    <ul>
        <li>Logoff automático após 30 minutos de inatividade.</li>
    </ul> 
</div>
</div>