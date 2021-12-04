<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receita Médica</title>
    <style type="text/css">
        body, html {
            margin-top: 40px;
            font-family: Arial, Helvetica, sans-serif;
        };
        div{
            margin: 0;
            padding: 0;
        }
        .uppercase{
            text-transform: uppercase;
        }
        header img{
            transform: translateX(8cm);
            margin: 0, 0, 30px, 0;
        }
        header h2{
            font-size: 14px;
            padding-top: 10px;
            transform: translateX(36mm);
        }
        #quadro{
            border: 2px solid #000;
            margin-top: 30px;
            padding-left: 30px;
        }
        .title{
            align-items: center;
            justify-content: center;
            margin-top: 10px;
        }
        .title p{
            transform: translateX(70mm);
        }
        .body p{
            font-size: 12px;
        }
        .footer{
            margin-top: 200px;
            margin-bottom: 50px;
            display: flex;
            justify-content:space-between;
        }
        .footer p{
            margin-top:20px;
        }
        .date{
            transform: translate(127mm, -25px)
        }
        .linha-horizontal{
        width: 300px;
        border: 0.1px solid #000;
        margin-bottom: 5px;
        }
        .linha-horizontal2{
        width: 180px;
        border: 0.1px solid #000;
        transform: translateX(430px)
        }
    </style>
</head>
<body>
    <div class="header">
        <header>
            <img src="../../../public/img/logomarca.png" alt="">
            <h2>Instituto Coelho – Emagrecimento e Performance Humana</h2>
        </header>
    </div>
    <div id="quadro">
        <div class="title">
            <div>
                <p class=uppercase>
                    <strong>Receituário</strong>
                </p>
            </div>
        </div>
        <div class="body">
            <div>
                <p class="uppercase patient-name">
                    Paciente: {{ $patient_name }}
                </p>
                <p class="uppercase patient_cpf">
                    CPF: {{ $patient_cpf }}
                </p>
            </div>
            <div>
                <p class="uppercase">
                    Prescrição:
                </p>
                <p>

                </p>
            </div>
        </div>
        <div class="footer">
            <div class="linha-horizontal">
            </div>
            <div>
                <p class="doctor-name">
                    {{ $doctor_name }}
                </p>
            </div>
            <div class="date">
                {{$day}}/{{$month}}//{{$yaer}}
            </div>
            <div class="linha-horizontal2">
            </div>
            <div style="transform: translateX(485px)">
                <p class="doctor-name">
                    Recife/PE
                </p>
            </div>
        </div>
    </div>
</body>