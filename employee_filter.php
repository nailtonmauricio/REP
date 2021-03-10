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
    <form name="fetchReport" method="post" action="validate_report.php">
        <div class="mb-3">
            <label for="employee" class="form-label">Colaborador</label>
            <select name="employee_id" id="employee" class="form-control">
                <option>[Selecione]</option>
                <?php
                    $sqlEmployee = "SELECT employee_id, UPPER(name) AS name FROM rpo.employees";
                    $resEmployee = $conn->prepare($sqlEmployee);
                    $resEmployee->execute();
                    $rowEmployee = $resEmployee->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rowEmployee as $item):
                ?>
                <option value="<?=$item['employee_id'];?>"><?=$item["name"];?></option>
                <?php endforeach;?>
            </select>
            <div class="form-text">Selecione um colaborador para realizar consulta de histórico de marcações</div>
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
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
