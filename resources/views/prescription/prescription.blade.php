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
            padding-left: 20px;
        }
        .title{
            align-items: center;
            justify-content: center;
            margin-top: 10px;
        }
        .title p{
            transform: translateX(60mm);
        }
        .body p{
            font-size: 12px;
        }
        .footer{
            margin-top: 50px;
            margin-bottom: 50px;
            display: flex;
            justify-content:space-between;
        }
        .linha-horizontal{
        width: 300px;
        border: 0.1px solid #000;
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
                <p class=uppercase>Receituário</p>
            </div>
        </div>
        <div class="body">
            <div>
                <p class="uppercase">
                    Paciente:
                </p>
                <p>
                    CPF: 
                </p>
            </div>
            <div>
                <p>
                    Prescrição:
                </p>
                <p>

                </p>
            </div>
        </div>
        <div class="footer">
            <div class="linha-horizontal">
            </div>
            <div class="linha-horizontal" style="transform: translateX(50px)">
            </div>
        </div>
    </div>
</body>