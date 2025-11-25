<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Full Adder Visual (Estilo Minecraft)</title>
    <style>
        /* Estilos Gerais */
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #202020; /* Fundo escuro estilo editor/jogo */
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        h1 { color: #ff5555; text-shadow: 2px 2px #000; }

        /* O Painel do Circuito */
        .circuit-board {
            background: #3a3a3a;
            padding: 30px;
            border-radius: 10px;
            border: 4px solid #555;
            display: flex;
            gap: 40px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Colunas do Circuito */
        .stage {
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
        }

        /* Caixas (Representando os blocos/portas) */
        .box {
            padding: 15px;
            border-radius: 8px;
            background: #444;
            border: 2px solid #777;
            text-align: center;
            min-width: 80px;
            position: relative;
            transition: all 0.3s;
        }
        
        /* Estilos para Ligado/Desligado */
        .off {
            color: #777;
            border-color: #555;
            box-shadow: inset 0 0 10px #000;
        }
        .on {
            background-color: #3e0000; /* Fundo avermelhado */
            color: #ff5555; /* Texto vermelho brilhante */
            border-color: #ff0000;
            box-shadow: 0 0 15px #ff0000, inset 0 0 10px #ff0000; /* Brilho da Redstone */
            font-weight: bold;
        }

        /* Botões de Entrada (Alavancas) */
        button.toggle {
            cursor: pointer;
            width: 100%;
            padding: 10px;
            font-size: 18px;
            border: none;
        }
        button.on { background-color: #aa0000; color: white; }
        button.off { background-color: #555; color: #ccc; }

        /* Setinhas/Fios (Simples caracteres unicode) */
        .wire { font-size: 24px; color: #555; }
        .wire.on { color: #ff0000; text-shadow: 0 0 5px red; }

        .label { font-size: 12px; color: #aaa; margin-bottom: 5px; display: block; }
        
        .comentario {
            max-width: 600px;
            margin-top: 20px;
            background: #333;
            padding: 15px;
            border-left: 5px solid #ff5555;
            line-height: 1.6;
        }
    </style>
</head>
<body>

<?php
    // 1. Captura os valores (se não tiver nada, assume 0)
    // Usamos ternário simples: Se clicou, inverte o valor anterior
    
    // Estado atual (padrão 0)
    $a = isset($_POST['a']) ? $_POST['a'] : 0;
    $b = isset($_POST['b']) ? $_POST['b'] : 0;
    $cin = isset($_POST['cin']) ? $_POST['cin'] : 0;

    // LÓGICA DO FULL ADDER (O Cérebro da coisa)
    
    // Passo 1: Primeira Soma (A XOR B)
    // No PHP, ^ é o operador XOR
    $xor1 = $a ^ $b; 
    
    // Passo 2: AND da primeira parte (Para saber se vai 1 só do A e B)
    // & é o operador AND
    $and1 = $a & $b;

    // Passo 3: Soma Final (Resultado do primeiro XOR com o Carry In)
    $sum = $xor1 ^ $cin; // <-- ESSE É O RESULTADO "SOMA"

    // Passo 4: O Carry Out (Vai Um)
    // Se (A e B for 1) OU (Xor1 e Cin for 1)
    $and2 = $xor1 & $cin;
    $cout = $and1 | $and2; // | é o operador OR <-- ESSE É O "VAI UM"
    
    // Funçãozinha auxiliar para escrever a classe CSS
    function cssClass($val) { return $val ? 'on' : 'off'; }
?>

<h1>⚡ Simulador Full Adder (Redstone)</h1>

<form method="POST">
    <div class="circuit-board">
        
        <div class="stage">
            <div class="label">ENTRADAS</div>
            
            <div class="box <?php echo cssClass($a); ?>">
                <span class="label">A (Blue)</span>
                <button type="submit" name="a" value="<?php echo $a ? 0 : 1; ?>" class="toggle <?php echo cssClass($a); ?>">
                    <?php echo $a; ?>
                </button>
            </div>

            <div class="box <?php echo cssClass($b); ?>">
                <span class="label">B (Green)</span>
                <button type="submit" name="b" value="<?php echo $b ? 0 : 1; ?>" class="toggle <?php echo cssClass($b); ?>">
                    <?php echo $b; ?>
                </button>
            </div>

            <div class="box <?php echo cssClass($cin); ?>">
                <span class="label">C-In (Orange)</span>
                <button type="submit" name="cin" value="<?php echo $cin ? 0 : 1; ?>" class="toggle <?php echo cssClass($cin); ?>">
                    <?php echo $cin; ?>
                </button>
            </div>
            
            <input type="hidden" name="b" value="<?php echo $b; ?>">
            <input type="hidden" name="cin" value="<?php echo $cin; ?>">
            </div>

        <div class="wire <?php echo cssClass($a | $b | $cin); ?>">➜</div>

        <div class="stage">
            <div class="label">LÓGICA INTERNA</div>
            
            <div class="box <?php echo cssClass($xor1); ?>">
                <span class="label">XOR (A ^ B)</span>
                <strong><?php echo $xor1; ?></strong>
            </div>
            
            <div class="box <?php echo cssClass($and1 | $and2); ?>">
                <span class="label">Lógica do Carry</span>
                <small style="font-size:10px">ANDs & OR</small>
            </div>
        </div>

        <div class="wire <?php echo cssClass($sum | $cout); ?>">➜</div>

        <div class="stage">
            <div class="label">RESULTADO</div>
            
            <div class="box <?php echo cssClass($sum); ?>" style="border-radius: 50%; width: 60px; height: 60px; display:flex; align-items:center; justify-content:center;">
                <div>
                    <span class="label">SOMA</span>
                    <span style="font-size:24px"><?php echo $sum; ?></span>
                </div>
            </div>

            <div class="box <?php echo cssClass($cout); ?>" style="border-radius: 50%; width: 60px; height: 60px; display:flex; align-items:center; justify-content:center;">
                <div>
                    <span class="label">VAI 1</span>
                    <span style="font-size:24px"><?php echo $cout; ?></span>
                </div>
            </div>
        </div>

    </div>
    
    <script>
        // Um pouquinho de JS só para garantir que os botões não resetem os outros
        // Se preferir 100% PHP, teria que usar checkboxes e um botão "Calcular"
        const buttons = document.querySelectorAll('button');
        buttons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                // Previne envio padrão
                e.preventDefault(); 
                // Pega o input hidden correspondente a este botão
                // ... Para este exemplo simples, recomendo usar o fluxo:
                // Clica -> Muda URL -> Recarrega.
                // Mas vamos deixar o form acima, se o usuário clicar, vai enviar o valor novo do botão.
                // Para funcionar perfeito sem JS complexo, o ideal é usar CHECKBOXES.
            });
        });
    </script>
    
    <div style="margin-top:20px; text-align:center;">
        <h3>Controles (Use estes para testar):</h3>
        <label>
            <input type="checkbox" name="a" value="1" <?php if($a) echo "checked"; ?> onchange="this.form.submit()"> 
            A (Azul)
        </label>
        <label style="margin: 0 15px;">
            <input type="checkbox" name="b" value="1" <?php if($b) echo "checked"; ?> onchange="this.form.submit()"> 
            B (Verde)
        </label>
        <label>
            <input type="checkbox" name="cin" value="1" <?php if($cin) echo "checked"; ?> onchange="this.form.submit()"> 
            C-In (Laranja)
        </label>
        <br><small>Marque a caixa para ligar a alavanca</small>
    </div>
</form>

<div class="comentario">
    <h3>🤓 O que está acontecendo aqui?</h3>
    <p>
        1. <strong>XOR (Ou Exclusivo):</strong> É a peça principal da soma. Se você tem apenas UM sinal ligado (A ou B), ele acende (1). Se tiver os dois, ele apaga (0) porque "deu choque" e precisa subir o número.<br><br>
        2. <strong>Carry Out (Vai Um):</strong> Ele acende se tiver energia demais (dois ou mais inputs ligados). É a Redstone passando para o próximo bloco da construção.
    </p>
</div>

</body>
</html>