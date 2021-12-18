<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contrato de Prestação</title>
    <style type="text/css">
        body, html {
            /* margin: 0; */
            margin: 50x, 20px, 10px, 10px;
            font-family: Arial, Helvetica, sans-serif;
        };
        div{
            margin: 0;
            padding: 0;
        };
        #header p{
            font-size: 40px;
            text-align: center;
        }
        #dados{
            font-size: 12pt;
            text-align: justify;
            line-height: 1.5;
        }
        #dados p{
            line-height: 1.5;
        }
        #body{
            text-align: justify;
            line-height: 1.5;
        }
        #body p{
            font-size: 12pt;
        }
    </style>
</head>
<body>
    <header id="header">
            <h3>CONTRATO DE PRESTAÇÃO DE SERVIÇOS MÉDICOS CONTRATANTE:</h3>
    </header>
    <div id="dados">
        <p>Nome: {{$patient->nome}}</p>
        <p>Nacionalidade: {{$patient->nationality}}; Estado Civil: {{$patient->marital_status}}; Profissão: {{$patient->profession}}</p>
        <p>RG: {{$patient->rg}},   Órgão Expedidor: {{$patient->dispatcher}};</p>
        <p>CPF/MF: {{$patient_cpf_formatted}}</p>
        <p>Endereço: Rua {{$patient->rua}}, nº {{$patient->numero}}</p> <p>Complemento: {{$patient->complemento}}, Bairro: {{$patient->bairro}}, Cidade: {{$patient->cidade}},</p>
        <p>Estado: {{$patient->estado}}, CEP: {{$patient->cep}}, E-mail: {{$patient->email}}</p>
        <p>Plano Contratado: {{ $plan->description }}</p>
    </div>
    <div style="text-align: justify">
        <p>
            <strong>CONTRATADO</strong>: {{ $doctor->name}}, empresário individual, com endereço para prestação de serviços na Av. República do Líbano, 251 – Pina, Recife – PE, 51110-190 e inscrito no CNPJ/MF sob nº 24.623.109/0001-43.
        </p>
        <p>
            As partes acima identificadas – doravante identificadas como CONTRATANTE e o CONTRATADO – têm, entre si, justo e acertado o presente Contrato de prestação de serviços médicos, que se regerá pelas cláusulas seguintes e pelas condições descritas no presente.
        </p>
    </div>
    <div id="body">
        <x-chapter-one/>
        <x-chapter-two/>
        <x-chapter-three/>
        <x-chapter-four/>
        <x-chapter-fifth/>
    </div>
    @yield('content')
</body>