<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela Mental Binária</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #eef2f7;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        h1 { color: #2c3e50; margin-bottom: 10px; }
        p { color: #666; margin-bottom: 30px; text-align: center; max-width: 600px; }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 1000px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            text-align: center;
            transition: transform 0.2s;
            cursor: help;
            position: relative;
            overflow: hidden;
            border-left: 5px solid #007bff;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        /* Estilo especial para a "chatinha" 2^0 */
        .card.special { border-left-color: #ffc107; }
        /* Estilo para as memórias de celular (2^6 pra cima) */
        .card.memory { border-left-color: #28a745; }

        .potencia {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        /* O segredo: Resposta borrada inicialmente */
        .resposta-container {
            filter: blur(5px);
            opacity: 0.5;
            transition: all 0.3s ease;
        }

        /* Quando passa o mouse, revela tudo */
        .card:hover .resposta-container {
            filter: blur(0);
            opacity: 1;
        }

        .numero-grande {
            font-size: 42px;
            color: #007bff;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        
        .card.memory .numero-grande { color: #28a745; }
        .card.special .numero-grande { color: #ffc107; }

        .dica {
            font-size: 14px;
            color: #666;
            font-style: italic;
            background: #f8f9fa;
            padding: 5px 10px;
            border-radius: 20px;
            display: inline-block;
        }

        .instrucao {
            font-size: 0.9rem;
            color: #999;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h1>Sua Tabela Mental 🧠</h1>
    <p>Passe o mouse (ou toque) nos cartões para revelar a resposta. Tente adivinhar antes de olhar!</p>

    <div class="grid-container">
        <?php
        // Aqui é o seu "Banco de Dados" da memória
        $dados = [
            ['p' => 0, 'r' => 1,   'dica' => 'O início de tudo (Ligar)', 'tipo' => 'special'],
            ['p' => 1, 'r' => 2,   'dica' => 'Um par de meias', 'tipo' => 'normal'],
            ['p' => 2, 'r' => 4,   'dica' => 'Rodas do carro', 'tipo' => 'normal'],
            ['p' => 3, 'r' => 8,   'dica' => 'Pense no Polvo', 'tipo' => 'normal'],
            ['p' => 4, 'r' => 16,  'dica' => 'Idade Jovem Adulto', 'tipo' => 'normal'],
            ['p' => 5, 'r' => 32,  'dica' => 'Dentes na boca', 'tipo' => 'normal'],
            ['p' => 6, 'r' => 64,  'dica' => 'Memória de cel barato', 'tipo' => 'memory'],
            ['p' => 7, 'r' => 128, 'dica' => 'Memória de cel médio', 'tipo' => 'memory'],
            ['p' => 8, 'r' => 256, 'dica' => 'Memória Top', 'tipo' => 'memory'],
        ];

        foreach ($dados as $item) {
            echo "
            <div class='card {$item['tipo']}'>
                <div class='potencia'>2<sup>{$item['p']}</sup></div>
                
                <div class='resposta-container'>
                    <span class='numero-grande'>{$item['r']}</span>
                    <span class='dica'>💡 {$item['dica']}</span>
                </div>
                
                <div class='instrucao'>Revelar</div>
            </div>";
        }
        ?>
    </div>

</body>
</html>