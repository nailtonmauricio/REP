<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>RPO</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <style type="text/css">
        .py-3 {
            font-size: 65px;
            font-weight: bolder;
        }
    </style>
</head>
<body onload="startTime()">
<div class="well col-*">
    <div class="form-group">
        <div class="header">
            <p class="text-center" style="font-size: 25px; color: #6c757d;">
                <strong>
                    <?php

                    $dia = date('D');
                    $date = date('d/m/Y');
                    switch ($dia) {
                        case 'Sun':
                            $dia = "Dom";
                            break;
                        case 'Mon':
                            $dia = "Seg";
                            break;
                        case 'Tue':
                            $dia = "Ter";
                            break;
                        case 'Wed':
                            $dia = "Qua";
                            break;
                        case 'Thu':
                            $dia = "Qui";
                            break;
                        case 'Fri':
                            $dia = "Sex";
                            break;
                        case 'Sat':
                            $dia = "Sab";
                            break;
                    }
                    echo $dia . ", " . $date;
                    ?>
                </strong>
            </p>
        </div>
        <script>
            function startTime() {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                h = checkTime(h);
                m = checkTime(m);
                s = checkTime(s);
                document.getElementById('clock').innerHTML =
                    h + ":" + m + ":" + s;
                var t = setTimeout(startTime, 500);
            }

            function checkTime(i) {
                // add zero in front of numbers < 10
                if (i < 10) {
                    i = "0" + i
                }
                return i;
            }

            /*
            * Remover alert depois de 5 segundos
            */
            $(document).ready(function () {

                window.setTimeout(function () {
                    $(".alert").fadeTo(1000, 0).slideUp(1000, function () {
                        $(this).remove();
                    });
                }, 5000);

            });
        </script>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div id="clock" class="text-center" style="font-size: 95px; font-weight: bolder; color: #6c757d;"></div>
        <div class="col-*">
            <form name="myHours" method="post" action="validate.php">
                <div class="form-group" role="group" aria-label="Basic example">
                    <div class="row">
                        <div class="btn-group">
                            <label for="registro" class="sr-only"></label>
                            <input type="password" inputmode="numeric" name="registro" id="registro" class="form-control text-center" autofocus="" value="" style="height: 150px; font-size: 100px;"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '1';">
                                1
                            </button>
                            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '2';">
                                2
                            </button>
                            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '3';">
                                3
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '4';">
                                4
                            </button>
                            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '5';">
                                5
                            </button>
                            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '6';">
                                6
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '7';">
                                7
                            </button>
                            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '8';">
                                8
                            </button>
                            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '9';">
                                9
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value.slice(0, -1);" style="color: #ffffff;">0
                            </button>
                            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '0';">
                                0
                            </button>
                            <button type="submit" class="btn btn-outline-secondary py-3" style="color: #ffffff;">0
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>