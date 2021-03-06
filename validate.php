<?php
session_start();
require_once 'config/conn.php';
include_once "token.php";

$error = false;
$time = date("H:i:s");
$today = date("Y-m-d");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //DEBUG
    #var_dump($data);

    $remoteAddress = "127.0.0.1";//$_SERVER['REMOTE_ADDR'];
    $sqlRemoteAddress = "SELECT address_id FROM allowed_remote_addresses WHERE ip_address =:remote_address";
    $resRemoteAddress = $conn->prepare($sqlRemoteAddress);
    $resRemoteAddress->bindValue(":remote_address", $remoteAddress, PDO::PARAM_STR);
    $resRemoteAddress->execute();
    $rowRemoteAddress = $resRemoteAddress->fetch(PDO::FETCH_ASSOC);
    //DEBUG
    #$resRemoteAddress->debugDumpParams();

    //Check if the IP address you tried to log in to is in the list of allowed IP's
    $sqlEmployee = "SELECT employee_id FROM employees WHERE pwd =:pwd";
    $resEmployee = $conn->prepare($sqlEmployee);
    $resEmployee->bindValue(":pwd", $data["registro"], PDO::PARAM_INT);
    $resEmployee->execute();
    $rowEmployee = $resEmployee->fetch(PDO::FETCH_ASSOC);
    //DEBUG
    #$resEmployee->debugDumpParams();
    if($resEmployee->rowCount()>0 && $resRemoteAddress->rowCount()>0)
    {
        //
        $sqlPermission = "SELECT permission_id FROM permissions_for_registration WHERE employee_id =:employee_id AND remote_address_id =:addressId";
        $resPermission = $conn->prepare($sqlPermission);
        $resPermission->bindValue(":employee_id", $rowEmployee["employee_id"], PDO::PARAM_INT);
        $resPermission->bindValue(":addressId", $rowRemoteAddress["address_id"], PDO::PARAM_INT);
        $resPermission->execute();
        $rowPermission = $resPermission->fetch(PDO::FETCH_ASSOC);
        //DEBUG
        #$resPermission->debugDumpParams();
        if($resPermission->rowCount()>0)
        {
            $sqlDailyLog = "SELECT log_id, record_a, record_b, record_c, record_d, record_e, record_f FROM daily_log WHERE created LIKE '$today%' AND employee_id = ".$rowEmployee["employee_id"];
            $resDailyLog = $conn->prepare($sqlDailyLog);
            $resDailyLog->execute();
            $rowDailylog = $resDailyLog->fetch(PDO::FETCH_ASSOC);
            //DEBUG
            #$resDailyLog->debugDumpParams();

            if($resDailyLog->rowCount()>0)
            {
                if (is_null($rowDailylog["record_b"]))
                {
                    $sqlUpdateLog = "UPDATE daily_log SET record_b = '$time', modified = NOW() WHERE log_id =".$rowDailylog["log_id"];
                    $resUpdateLog = $conn->prepare($sqlUpdateLog);
                    $resUpdateLog->execute();

                    //DEBUG
                    #$resUpdateLog->debugDumpParams();

                    $_SESSION ['msg'] = "<div class='alert alert-success alert-dismissible text-center'> "
                        . "<button type='button' class='close' data-dismiss='alert'>"
                        . "<span aria-hidden='true'>&times;</span>"
                        . "</button>Registro realizado com sucesso</div>";
                    header("Location: index.php");
                }
                elseif (is_null($rowDailylog["record_c"]))
                {

                    $sqlUpdateLog = "UPDATE daily_log SET record_c = '$time', modified = NOW() WHERE log_id =".$rowDailylog["log_id"];
                    $resUpdateLog = $conn->prepare($sqlUpdateLog);
                    $resUpdateLog->execute();

                    //DEBUG
                    #$resUpdateLog->debugDumpParams();

                    $_SESSION ['msg'] = "<div class='alert alert-success alert-dismissible text-center'> "
                        . "<button type='button' class='close' data-dismiss='alert'>"
                        . "<span aria-hidden='true'>&times;</span>"
                        . "</button>Registro realizado com sucesso</div>";
                    header("Location: index.php");
                }
                elseif (is_null($rowDailylog["record_d"]))
                {

                    $sqlUpdateLog = "UPDATE daily_log SET record_d = '$time', modified = NOW() WHERE log_id =".$rowDailylog["log_id"];
                    $resUpdateLog = $conn->prepare($sqlUpdateLog);
                    $resUpdateLog->execute();

                    //DEBUG
                    #$resUpdateLog->debugDumpParams();

                    $_SESSION ['msg'] = "<div class='alert alert-success alert-dismissible text-center'> "
                        . "<button type='button' class='close' data-dismiss='alert'>"
                        . "<span aria-hidden='true'>&times;</span>"
                        . "</button>Registro realizado com sucesso</div>";
                    header("Location: index.php");
                }
                elseif (is_null($rowDailylog["record_e"]))
                {

                    $sqlUpdateLog = "UPDATE daily_log SET record_e = '$time', modified = NOW() WHERE log_id =".$rowDailylog["log_id"];
                    $resUpdateLog = $conn->prepare($sqlUpdateLog);
                    $resUpdateLog->execute();

                    //DEBUG
                    #$resUpdateLog->debugDumpParams();

                    $_SESSION ['msg'] = "<div class='alert alert-success alert-dismissible text-center'> "
                        . "<button type='button' class='close' data-dismiss='alert'>"
                        . "<span aria-hidden='true'>&times;</span>"
                        . "</button>Registro realizado com sucesso</div>";
                    header("Location: index.php");
                }
                elseif (is_null($rowDailylog["record_f"]))
                {

                    $sqlUpdateLog = "UPDATE daily_log SET record_f = '$time', modified = NOW() WHERE log_id =".$rowDailylog["log_id"];
                    $resUpdateLog = $conn->prepare($sqlUpdateLog);
                    $resUpdateLog->execute();

                    //DEBUG
                    #$resUpdateLog->debugDumpParams();

                    $_SESSION ['msg'] = "<div class='alert alert-success alert-dismissible text-center'> "
                        . "<button type='button' class='close' data-dismiss='alert'>"
                        . "<span aria-hidden='true'>&times;</span>"
                        . "</button>Registro realizado com sucesso</div>";
                    header("Location: index.php");
                }
            } else {
                $sqlInsertLog = "INSERT INTO daily_log (employee_id, record_a, record_b, record_c, record_d, record_e, record_f, created, modified) VALUES(:employee_id, :record_a, null, null, null, null, null, current_timestamp, null)";
                $resInsertLog = $conn->prepare($sqlInsertLog);
                $resInsertLog->bindValue(":employee_id", $rowEmployee["employee_id"], PDO::PARAM_INT);
                $resInsertLog->bindValue(":record_a", $time, PDO::PARAM_STR);
                $resInsertLog->execute();

                //DEBUG
                #$resInsertLog->debugDumpParams();

                //Realizar o envio so SMS
                /*$nomeUsuario = $rowEmployee["name"];
                $dataHora = date('d/m/Y H:i:s');
                $celular = $rowEmployee["phone_number"];
                $message = "SIGRPO: $nomeUsuario, PONTO REGISTRADO COM SUCESSO $dataHora";
                //Enviar alerta por SMS ao gestor de temperatura
                $urlSms = "https://api.directcallsoft.com/sms/send";
                $origem = "5583994074278";
                $destino = $celular;
                $tipo = "texto";
                //$texto = $message;
                $format = "JSON";

                // Dados em formato QUERY_STRING
                $data = http_build_query(array('origem'=>$origem, 'destino'=>$destino, 'tipo'=>$tipo, 'access_token'=>$access_token,
                    'texto'=>$message));
                $ch = 	curl_init();
                curl_setopt($ch, CURLOPT_URL, $urlSms);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $return = curl_exec($ch);
                curl_close($ch);*/

                $_SESSION ['msg'] = "<div class='alert alert-success alert-dismissible text-center'> "
                    . "<button type='button' class='close' data-dismiss='alert'>"
                    . "<span aria-hidden='true'>&times;</span>"
                    . "</button>Registro realizado com sucesso</div>";
                header("Location: index.php");
            }
        }
        else{
            $error = true;
            $_SESSION ['msg'] = "<div class='alert alert-danger alert-dismissible text-center'> "
                . "<button type='button' class='close' data-dismiss='alert'>"
                . "<span aria-hidden='true'>&times;</span>"
                . "</button>Permiss??o para marca????o n??o encontrada</div>";
        }
    }
    else{
        $error = true;
        $sqlRecordsDenied = "INSERT INTO records_denied (ip_address, created) VALUES(:ip_address, current_timestamp())";
        $resRecordsDenied = $conn->prepare($sqlRecordsDenied);
        $resRecordsDenied->bindValue(":ip_address", $remoteAddress, PDO::PARAM_STR);
        $resRecordsDenied->execute();
        //DEBUG
        $resRecordsDenied->debugDumpParams();

        $_SESSION ['msg'] = "<div class='alert alert-danger alert-dismissible text-center'> "
            . "<button type='button' class='close' data-dismiss='alert'>"
            . "<span aria-hidden='true'>&times;</span>"
            . "</button>Marca????o n??o permitida a partir deste endere??o IP ou senha incorreta</div>";
    }
} else {
    $error = true;
    $_SESSION ['msg'] = "<div class='alert alert-danger alert-dismissible text-center'> "
        . "<button type='button' class='close' data-dismiss='alert'>"
        . "<span aria-hidden='true'>&times;</span>"
        . "</button>Erro ao realizar marca????o</div>";
}
if($error){
    //Shipping type error
    header("Location: index.php");
}