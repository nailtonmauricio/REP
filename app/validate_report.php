<?php
ob_start();
require_once 'config/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //DEBUG
    #var_dump($data);

    //Performing the search to fill the file header
    $sqlReportInformation = "SELECT employees.name, employees.ctps, employees.pis, positions.name AS position_name, departments.name AS department_name,branches.business_name AS branche_name, branches.cnpj, branches.address FROM employees JOIN branches ON employees.branch_id = branches.branch_id JOIN positions ON employees.position_id = positions.position_id JOIN departments ON positions.department_id = departments.department_id WHERE employee_id =:employee_id";
    $resReportInformation = $conn->prepare($sqlReportInformation);
    $resReportInformation->bindParam(":employee_id", $data["employee_id"], PDO::PARAM_INT);
    $resReportInformation->execute();
    $rowReportInformation = $resReportInformation->fetch(PDO::FETCH_ASSOC);
    //DEBUG
    #$resReportInformation->debugDumpParams();
    var_dump($rowReportInformation);

    //Checking number of days for the selected month
    $totalMonthDays = cal_days_in_month(CAL_GREGORIAN, $data["month"], $data["year"]);
    $year = $data["year"];
    $month = $data["month"];
    $anyDate = $year-$month;

    for ($i = 1; $i <= $totalMonthDays; $i++) {
        switch ($dayEn = date("D", strtotime("$anyDate-$i"))) {
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
        $sqlReportLog = "SELECT CAST(created AS date) AS created, record_a, record_b, record_c, record_d, record_e, record_f FROM daily_log WHERE employee_id =:employee_id AND CAST(created AS date) =:anyDay";
        $resReportLog = $conn->prepare($sqlReportLog);
        $resReportLog->bindParam(":employee_id", $data["employee_id"], PDO::PARAM_INT);
        $resReportLog->bindValue(":anyDay", $anyDay);
        $resReportLog->execute();
        $rowReportLog = $resReportLog->fetch(PDO::FETCH_ASSOC);
        //DEBUG
        #$resReportLog->debugDumpParams();
        #var_dump($rowReportLog);
    }
}