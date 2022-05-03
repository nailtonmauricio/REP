<?php
require_once 'config/conn.php';
require_once "assets/functions/functions.php";
/**
 * Esse script está com erro no somatório de horas.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //DEBUG
    #var_dump($data);
    //Checking number of days for the selected month
    $totalMonthDays = cal_days_in_month(CAL_GREGORIAN, $data["month"], $data["year"]);
    $year = $data["year"];
    $month = $data["month"];
   
    if(!empty($data["employee_pwd"])){
        $sqlEmployee = "SELECT employee_id FROM employees WHERE pwd =:pwd";
        $resEmployee = $conn->prepare($sqlEmployee);
        $resEmployee-> bindParam(":pwd", $data["employee_pwd"], PDO::PARAM_STR);
        $resEmployee-> execute();
        $rowEmployee = $resEmployee->fetch(PDO::FETCH_ASSOC);
        $employee_id = $data["employee_id"] = $rowEmployee["employee_id"];
    } else {
        $employee_id = $data["employee_id"];
    }

    //Performing the search to fill the file header
    $sqlReportInformation = "SELECT UPPER(employees.name) AS employee_name, employees.ctps, employees.pis, employees.registration, work_schedule.first_weekly_shift_entry, work_schedule.first_weekly_shift_exit, work_schedule.second_weekly_shift_entry, work_schedule.second_weekly_shift_exit, work_schedule.weekend_shift_entry, work_schedule.weekend_shift_exit,UPPER(positions.name )AS position_name, employees.admission_date,UPPER(branches.business_name) AS branche_name, branches.cnpj, UPPER(branches.address) AS address, branches.cep, UPPER(departments.name) AS department FROM employees JOIN branches ON employees.branch_id = branches.branch_id JOIN positions ON employees.position_id = positions.position_id JOIN departments ON departments.department_id = positions.department_id JOIN work_schedule ON work_schedule.schedule_id = employees.work_schedule_id WHERE employee_id =:employee_id";
    $resReportInformation = $conn->prepare($sqlReportInformation);
    $resReportInformation->bindParam(":employee_id", $data["employee_id"], PDO::PARAM_INT);
    $resReportInformation->execute();
    $rowReportInformation = $resReportInformation->fetch(PDO::FETCH_ASSOC);
    //DEBUG
    #$resReportInformation->debugDumpParams();
    #var_dump($rowReportInformation);

    //FORMATANDO CNPJ/CPF
    function formatar_cpf_cnpj($doc) {

        $doc = preg_replace("/[^0-9]/", "", $doc);
        $qtd = strlen($doc);

        if($qtd >= 8) {
            //FORMATA CEP
            if($qtd === 8)
            {
                $docFormatado = substr($doc, 0, 5) . '-'.
                substr($doc, -3);
            }
            //FORMATA PIS
            elseif($qtd === 11 ) {
                $docFormatado = substr($doc, 0, 3) . '.' .
                substr($doc, 3, 5) . '.' .
                substr($doc, 8, 2) . '-' .
                substr($doc, -1);
            }
            //FORMATA CNPJ 
            else {
                $docFormatado = substr($doc, 0, 2) . '.' .
                substr($doc, 2, 3) . '.' .
                substr($doc, 5, 3) . '/' .
                substr($doc, 8, 4) . '-' .
                substr($doc, -2);
            }

            return $docFormatado;

        } else {
            return false;
        }
    }


    $rowReportInformation["cnpj"] = formatar_cpf_cnpj($rowReportInformation["cnpj"]);
    $rowReportInformation["cep"] = formatar_cpf_cnpj($rowReportInformation["cep"]);
    $rowReportInformation["pis"] = formatar_cpf_cnpj($rowReportInformation["pis"]);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Relatório RPO</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <style>
        table {
            width: 100%;
            font-size: 8pt;
        }

        /*table, td, th {
            border: solid 1px;
            }*/

            td {
                text-align: left;
            }

            tbody td {
                text-align: center;
            }
            .day {
                text-align: left;
            }
            .day {
                text-align: left;
                width: 23px;
            }
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <td colspan="8"><?= $rowReportInformation["branche_name"] ?></td>
                    <td colspan="8">CNPJ: <?= $rowReportInformation["cnpj"] ?></td>
                </tr>
                <tr>
                    <td colspan="8"><?= $rowReportInformation["address"] ?></td>
                    <td colspan="8">CEP: <?= $rowReportInformation["cep"] ?></td>
                </tr>
                <tr>
                    <td colspan="8">FUNCIONÁRIO: <?= $rowReportInformation["employee_name"] ?></td>
                    <td colspan="4">PIS: <?= $rowReportInformation["pis"] ?></td>
                    <!--<td colspan="4">CTPS: <?= $rowReportInformation["ctps"] ?></td>-->
                    <td colspan="4">DATA DE ADMISSÃO: <?= date("d/m/Y", strtotime($rowReportInformation["admission_date"])) ?></td>
                </tr>
                <tr>
                    <td colspan="8">DEPARTAMENTO: <?= $rowReportInformation["department"] ?></td>
                    <td colspan="4">MATRÍCULA: <?= $rowReportInformation["registration"] ?></td>
                    <td colspan="4">CARGO: <?= $rowReportInformation["position_name"] ?></td>
                </tr>
                <tr>
                    <td colspan="8">RELATÓRIO DE BANCO DE HORAS INDIVIDUAL</td>
                    <td colspan="4">PERÍODO: <?= "01/{$month}/{$year} à {$totalMonthDays}/{$month}/{$year}" ?></td>
                    <td colspan="4">EMISSÃO: <?= date("d/m/Y H:i:s") ?></td>
                </tr>
            </thead>
        </table>
        <table>
            <tbody>
                <tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <td></td>
                    <td colspan="6" class="title">TURNO</td>
                    <td colspan="6" class="title">MARCAÇÕES</td>
                    <td colspan="3" class="title">BANCO DE HORAS</td>
                </tr>
                <tr>
                    <td class="day">Dia</td>
                    <td>Ent.1</td>
                    <td>Saí.1</td>
                    <td>Ent.2</td>
                    <td>Saí.2</td>
                    <td>Ent.3</td>
                    <td>Saí.3</td>
                    <td>Ent.1</td>
                    <td>Saí.1</td>
                    <td>Ent.2</td>
                    <td>Saí.2</td>
                    <td>Ent.3</td>
                    <td>Saí.3</td>
                    <td>Crédito</td>
                    <td>Débito</td>
                    <td>Saldo</td>
                </tr>
                <?php
    $sc = 0; //Sum Credit
    $sd = 0; //Sum Debit
    $balance = 0; //Saldo do banco de horas
    for ($i = 1; $i <= $totalMonthDays; $i++) {
        switch ($dayEn = date("D", strtotime("$year-$month-$i"))) {
            case 'Sun':
            $dayPtBr = "Dom";
            break;
            case 'Mon':
            $dayPtBr = "Seg";
            break;
            case 'Tue':
            $dayPtBr = "Ter";
            break;
            case 'Wed':
            $dayPtBr = "Qua";
            break;
            case 'Thu':
            $dayPtBr = "Qui";
            break;
            case 'Fri':
            $dayPtBr = "Sex";
            break;
            case 'Sat':
            $dayPtBr = "Sab";
            break;
        }
        $anyDay = "$year-$month-$i";
        //Searching the markup logs by date
        $sqlReportLog = "SELECT work_schedule.first_weekly_shift_entry, work_schedule.first_weekly_shift_exit, work_schedule.second_weekly_shift_entry, work_schedule.second_weekly_shift_exit, work_schedule.weekend_shift_entry, work_schedule.weekend_shift_exit, CAST(daily_log.created AS date) AS created, daily_log.record_a, daily_log.record_b, daily_log.record_c, daily_log.record_d, daily_log.record_e, daily_log.record_f, TIME_TO_SEC(TIMEDIFF(daily_log.record_b, daily_log.record_a))AS firstTime, TIME_TO_SEC(TIMEDIFF(daily_log.record_d, daily_log.record_c))AS secondTime, TIME_TO_SEC(TIMEDIFF(daily_log.record_f, daily_log.record_e))AS thirdTime, TIME_TO_SEC(workload.weekly_workload) AS weekly_workload, TIME_TO_SEC(workload.weekend_workload) AS weekend_workload FROM daily_log JOIN work_schedule ON daily_log.work_schedule_id = work_schedule.schedule_id JOIN workload ON daily_log.workload_id = workload.workload_id WHERE daily_log.employee_id =:employee_id AND CAST(daily_log.created AS date) =:anyDay";
        $resReportLog = $conn->prepare($sqlReportLog);
        $resReportLog->bindParam(":employee_id", $employee_id, PDO::PARAM_INT);
        $resReportLog->bindValue(":anyDay", $anyDay);
        $resReportLog->execute();
        $rowReportLog = $resReportLog->fetch(PDO::FETCH_ASSOC);
        //DEBUG
        #$resReportLog->debugDumpParams();
        #var_dump($rowReportLog);
        /*
        **
        **Bloco responsável por alimentar informações sobre turno de trabalho quando não há marcações
        */
        if (!$resReportLog->rowCount()):
            ?>
            <tr>
                <td class="day"><?= date("d/m", strtotime($anyDay)) . " $dayPtBr" ?></td>
                    <?php
                if ($dayEn = date("D", strtotime("$year-$month-$i")) == "Sun"):
                ?>
					<td>--:--</td>
                    <td>--:--</td>
                    <td>--:--</td>
                    <td>--:--</td>
                    <td>--:--</td>
                    <td>--:--</td>
                <?php  

                elseif ($dayEn = date("D", strtotime("$year-$month-$i")) == "Sat"):
                    ?>
                    <td><?= isset($rowReportInformation["weekend_shift_entry"]) ? date("H:i", strtotime($rowReportInformation["weekend_shift_entry"])) : "--:--" ?></td>
                    <td><?= isset($rowReportInformation["weekend_shift_exit"]) ? date("H:i", strtotime($rowReportInformation["weekend_shift_exit"])) : "--:--" ?></td>
                    <td>--:--</td>
                    <td>--:--</td>
                    <td>--:--</td>
                    <td>--:--</td>
                    <?php
                else:
                    ?>
                    <td><?= date("H:i", strtotime($rowReportInformation["first_weekly_shift_entry"])) ?></td>
                    <td><?= date("H:i", strtotime($rowReportInformation["first_weekly_shift_exit"])) ?></td>
                    <td><?= isset($rowReportInformation["second_weekly_shift_entry"]) ? date("H:i", strtotime($rowReportInformation["second_weekly_shift_entry"])) : "--:--" ?></td>
                    <td><?= isset($rowReportInformation["second_weekly_shift_exit"]) ? date("H:i", strtotime($rowReportInformation["second_weekly_shift_exit"])) : "--:--" ?></td>
                    <td>--:--</td>
                    <td>--:--</td>
                    <?php
                endif;
                ?>
                <td>--:--</td>
                <td>--:--</td>
                <td>--:--</td>
                <td>--:--</td>
                <td>--:--</td>
                <td>--:--</td>
                <td>--:--</td>
                <td>--:--</td>
                <td>--:--</td>
            </tr>
            <?php
        else:
            ?>
            <tr>
                <td class="day"><?= date("d/m", strtotime($rowReportLog["created"])) . " $dayPtBr" ?></td>
                <?php
                /*
                **
                **Bloco responsável por distriburir as marcações diárias, quando há marcações
                */
                if ($dayEn = date("D", strtotime("$year-$month-$i")) == "Sat"):
                    ?>
                    <td><?= isset($rowReportLog["weekend_shift_entry"]) ? date("H:i", strtotime($rowReportLog["weekend_shift_entry"])) : "--:--" ?></td>
                    <td><?= isset($rowReportLog["weekend_shift_exit"]) ? date("H:i", strtotime($rowReportLog["weekend_shift_exit"])) : "--:--" ?></td>
                    <td>--:--</td>
                    <td>--:--</td>
                    <td>--:--</td>
                    <td>--:--</td>
                    <?php
                else:
                    ?>
                    <td><?= date("H:i", strtotime($rowReportLog["first_weekly_shift_entry"])) ?></td>
                    <td><?= date("H:i", strtotime($rowReportLog["first_weekly_shift_exit"])) ?></td>
                    <td><?= isset($rowReportLog["second_weekly_shift_entry"]) ? date("H:i", strtotime($rowReportLog["second_weekly_shift_entry"])) : "--:--" ?></td>
                    <td><?= isset($rowReportLog["second_weekly_shift_exit"]) ? date("H:i", strtotime($rowReportLog["second_weekly_shift_exit"])) : "--:--" ?></td>
                    <td>--:--</td>
                    <td>--:--</td>
                    <?php
                endif;
                ?>
                <td><?= !is_null($rowReportLog["record_a"]) ? date("H:i", strtotime($rowReportLog["record_a"])) : "--:--" ?></td>
                <td><?= !is_null($rowReportLog["record_b"]) ? date("H:i", strtotime($rowReportLog["record_b"])) : "--:--" ?></td>
                <td><?= !is_null($rowReportLog["record_c"]) ? date("H:i", strtotime($rowReportLog["record_c"])) : "--:--" ?></td>
                <td><?= !is_null($rowReportLog["record_d"]) ? date("H:i", strtotime($rowReportLog["record_d"])) : "--:--" ?></td>
                <td><?= !is_null($rowReportLog["record_e"]) ? date("H:i", strtotime($rowReportLog["record_e"])) : "--:--" ?></td>
                <td><?= !is_null($rowReportLog["record_f"]) ? date("H:i", strtotime($rowReportLog["record_f"])) : "--:--" ?></td>

                <?php
                $totalWorkLoad = $rowReportLog["firstTime"] + $rowReportLog["secondTime"] + $rowReportLog["thirdTime"];
                $totalTime = convertSecToHours($totalWorkLoad);
                ?>

                <td>
                    <?php
                    /*
                    **
                    **Cálculos para banco de horas
                    */

                    if ($dayEn = date("D", strtotime("$year-$month-$i")) == "Sat") {
                        $workLoad = $rowReportLog["weekend_workload"];
                        if ($totalWorkLoad > $workLoad) {
                            $totalCredit = convertSecToHours($credit = $totalWorkLoad - $workLoad);
                            $sc += $credit;
                            echo date("H:i", strtotime($totalCredit));

                        } else {
                            echo "--:--";
                        }
                    } else {
                        $workLoad = $rowReportLog["weekly_workload"];
                        if ($totalWorkLoad > $workLoad) {
                            $totalCredit = convertSecToHours($credit = $totalWorkLoad - $workLoad);
                            $sc += $credit;
                            echo date("H:i", strtotime($totalCredit));
                        } else {
                            echo "--:--";
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($dayEn = date("D", strtotime("$year-$month-$i")) == "Sat") {
                        $workLoad = $rowReportLog["weekend_workload"];
                        if ($totalWorkLoad < $workLoad) {
                            $totalDebit = convertSecToHours($debit = $workLoad - $totalWorkLoad);
                            $sd += $debit;
                            echo date("H:i", strtotime($totalDebit));
                        } else {
                            echo "--:--";
                        }

                    } else {
                        $workLoad = $rowReportLog["weekly_workload"];
                        if ($totalWorkLoad < $workLoad) {
                            $totalDebit = convertSecToHours($debit = $workLoad - $totalWorkLoad);
                            $sd += $debit;
                            echo date("H:i", strtotime($totalDebit));
                        } else {
                            echo "--:--";
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $balance = $sc - $sd;
                    if ($balance < 0) {
                        $negativeBalance = abs($balance);
                        $negativeBalance = convertSecToHours($negativeBalance);
                        echo "(" . date("H:i", strtotime($negativeBalance)) . ")";
                    } else {
                        $positiveBalance = convertSecToHours($balance);
                        echo date("H:i", strtotime($positiveBalance));
                    }
                    ?>
                </td>
            </tr>
            <?php

        endif;
    }
    ?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Totais</td>
        <td>
            <?php
            /**
            **
            **Totais de banco de horas
            */
            if ($sc > 0) {
                $displayCredit = convertSecToHours($sc);
                echo date("H:i", strtotime($displayCredit));
            } else {
                echo "--:--";
            }
            ?>
        </td>
        <td>
            <?php

            if ($sd > 0) {
                $displayDebit = convertSecToHours($sd);
                echo date("H:i", strtotime($displayDebit));
            } else {
                echo "--:--";
            }
            ?>
        </td>
        <td>
            <?php
            if ($balance < 0) {
                $negativeBalance = abs($balance);
                $negativeBalance = convertSecToHours($negativeBalance);
                echo "(" . date("H:i", strtotime($negativeBalance)) . ")";
            } else {
                $positiveBalance = convertSecToHours($balance);
                echo date("H:i", strtotime($positiveBalance));
            }
            ?>
        </td>
    </tr>
    <tr>
        <td class="day">Assinatura:</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="6" style="border-top: solid 1px;"><?= $rowReportInformation["employee_name"] ?></td>
    </tr>
</tbody>
</table>
</body>
</html>