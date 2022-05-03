<?php
require_once __DIR__.'/config/conn.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Buscar Colaborador</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <form name="fetchReport" method="post" action="report.php">
            <div class="mb-3">
                <label for="employee_pwd" class="form-label">Colaborador</label>
                <input type="password" name="employee_pwd" id="employee_pwd" class="form-control" required/>
                <div class="form-text">Informe a senha de acesso</div>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Ano</label>
                <input type="text" name="year" id="year" class="form-control"/>
                <div class="form-text">Selecione o ano para realizar a consulta</div>
            </div>
            <div class="mb-3">
                <label for="month" class="form-label">Período</label>
                <select name="month" id="month" class="form-control">
                    <option>[Selecione]</option>
                    <option value="01">Janeiro</option>
                    <option value="02">Fevereiro</option>
                    <option value="03">Março</option>
                    <option value="04">Abril</option>
                    <option value="05">Maio</option>
                    <option value="06">Junho</option>
                    <option value="07">Julho</option>
                    <option value="08">Agosto</option>
                    <option value="09">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>
                <div class="form-text">Selecione o mês para realizar a consulta</div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>
    </div>
</body>
</html>
