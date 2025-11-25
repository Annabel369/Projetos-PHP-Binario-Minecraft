<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Somador Minecraft 4-Bits</title>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #221811; /* Cor de terra escura */
            --stone: #757575;
            --redstone-off: #4a0e0e;
            --redstone-on: #ff0000;
            --lamp-off: #382515;
            --lamp-on: #ffecb3; /* Brilho da lâmpada */
            --wool-orange: #f07800;
        }

        body {
            background-color: var(--bg-color);
            color: white;
            font-family: 'VT323', monospace;
            display: flex;
            flex-direction: column;
            align-items: center;
            user-select: none;
        }

        h1 { color: #ff5555; text-shadow: 3px 3px #000; font-size: 2.5rem; margin-bottom: 10px; }

        /* O Painel Principal */
        .game-board {
            background: #3b281f; /* Madeira escura */
            padding: 20px;
            border: 6px solid #222;
            border-radius: 4px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
        }

        /* Área das Alavancas (Inputs) */
        .inputs-area {
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* 4 bits + espaço */
            gap: 15px;
            background: rgba(0,0,0,0.2);
            padding: 15px;
            border-radius: 8px;
        }

        .bit-column {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .label { color: #aaa; font-size: 1.2rem; }

        /* Estilo da Alavanca */
        .lever {
            width: 50px;
            height: 50px;
            background-color: var(--stone);
            border: 4px solid #444;
            cursor: pointer;
            position: relative;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.5);
        }
        /* O "pauzinho" da alavanca */
        .lever::after {
            content: '';
            position: absolute;
            width: 10px;
            height: 30px;
            background: #8b5a2b; /* Madeira */
            top: 10px;
            left: 16px;
            transition: transform 0.2s;
            transform-origin: bottom center;
            transform: rotate(-45deg); /* Desligado */
        }
        .lever.on::after {
            transform: rotate(45deg); /* Ligado */
        }
        /* Luzinha indicadora na alavanca */
        .redstone-dust {
            width: 10px;
            height: 10px;
            background: var(--redstone-off);
            margin-top: 5px;
            box-shadow: 0 0 2px var(--redstone-off);
        }
        .lever.on + .redstone-dust {
            background: var(--redstone-on);
            box-shadow: 0 0 8px var(--redstone-on);
        }

        /* O Somador (Blocos Laranjas da sua imagem) */
        .adder-chain {
            display: flex;
            flex-direction: row-reverse; /* Para o bit menos significativo ficar na direita */
            gap: 5px;
            align-items: center;
        }

        .full-adder-box {
            background-color: var(--wool-orange);
            border: 4px solid #a05000;
            width: 90px;
            height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .adder-title { font-size: 1rem; color: #4a2800; font-weight: bold; }
        
        /* Fio de Carry (Laranja) entre os blocos */
        .carry-wire {
            height: 6px;
            width: 20px;
            background-color: var(--redstone-off);
            transition: background 0.2s;
        }
        .carry-wire.on {
            background-color: var(--redstone-on);
            box-shadow: 0 0 10px var(--redstone-on);
        }

        /* Visor Binário (Lâmpadas) */
        .lamps-area {
            display: flex;
            flex-direction: row-reverse;
            gap: 45px; /* Ajustar para alinhar com as colunas */
            margin-top: 10px;
            margin-right: -50px; /* Ajuste fino para alinhar */
        }

        .lamp-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .redstone-lamp {
            width: 60px;
            height: 60px;
            background-color: var(--lamp-off);
            border: 4px solid #2b1a0e;
            image-rendering: pixelated;
            /* Textura simples CSS */
            background-image: 
                linear-gradient(45deg, #332211 25%, transparent 25%), 
                linear-gradient(-45deg, #332211 25%, transparent 25%), 
                linear-gradient(45deg, transparent 75%, #332211 75%), 
                linear-gradient(-45deg, transparent 75%, #332211 75%);
            background-size: 10px 10px;
            transition: all 0.3s;
        }

        .redstone-lamp.on {
            background-color: var(--lamp-on);
            border-color: #aa8800;
            box-shadow: 0 0 20px #ffaa00;
            background-image: none; /* Lâmpada acesa fica lisa/brilhante */
        }

        /* Display Digital (Placa) */
        .sign-board {
            background: #8d7650; /* Cor de placa de carvalho */
            border: 4px solid #5d4037;
            padding: 15px 30px;
            color: #000;
            text-align: center;
            font-size: 1.5rem;
            min-width: 300px;
            margin-top: 20px;
        }
        .sign-text { font-size: 2.5rem; font-weight: bold; }

        /* Botão de Reset */
        .reset-btn {
            margin-top: 20px;
            background: #777;
            border: none;
            padding: 10px 20px;
            font-family: 'VT323', monospace;
            font-size: 1.5rem;
            color: white;
            cursor: pointer;
            border-bottom: 4px solid #444;
        }
        .reset-btn:active { transform: translateY(4px); border-bottom: 0; }
		
		/* Adicione isso no seu CSS */
        .binary-text {
            font-size: 1.8rem; 
            color: #333; 
            margin-top: 5px; 
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
        }

    </style>
</head>
<body>

    <h1>SOMADOR 4 BITS <span style="font-size:1rem; vertical-align:middle">v.Minecraft</span></h1>

    <div class="game-board">
        
        <div class="inputs-area">
            <div class="bit-column"><div class="label">2³ = 8 </div></div>
            <div class="bit-column"><div class="label">2² = 4 </div></div>
            <div class="bit-column"><div class="label">2¹ = 2 </div></div>
            <div class="bit-column"><div class="label">2⁰ = 1 </div></div>
            <div class="bit-column" style="width:20px"></div>

            <div class="bit-column">
                <div class="lever" id="a3" onclick="toggleBit('a', 3)"></div>
                <div class="redstone-dust"></div>
            </div>
            <div class="bit-column">
                <div class="lever" id="a2" onclick="toggleBit('a', 2)"></div>
                <div class="redstone-dust"></div>
            </div>
            <div class="bit-column">
                <div class="lever" id="a1" onclick="toggleBit('a', 1)"></div>
                <div class="redstone-dust"></div>
            </div>
            <div class="bit-column">
                <div class="lever" id="a0" onclick="toggleBit('a', 0)"></div>
                <div class="redstone-dust"></div>
            </div>
            <div class="bit-column"><div class="label" style="color:#88f">A</div></div>
			
			<div class="bit-column"><div class="label">2^3 = 8</div></div>
            <div class="bit-column"><div class="label">2^2 = 4</div></div>
            <div class="bit-column"><div class="label">2^1 = 2</div></div>
            <div class="bit-column"><div class="label">2^0 = 1</div></div><br>

            <div class="bit-column">
                <div class="lever" id="b3" onclick="toggleBit('b', 3)"></div>
                <div class="redstone-dust"></div>
            </div>
            <div class="bit-column">
                <div class="lever" id="b2" onclick="toggleBit('b', 2)"></div>
                <div class="redstone-dust"></div>
            </div>
            <div class="bit-column">
                <div class="lever" id="b1" onclick="toggleBit('b', 1)"></div>
                <div class="redstone-dust"></div>
            </div>
            <div class="bit-column">
                <div class="lever" id="b0" onclick="toggleBit('b', 0)"></div>
                <div class="redstone-dust"></div>
            </div>
            <div class="bit-column"><div class="label" style="color:#8f8">B</div></div>
        </div>

        <div class="adder-chain">
            
            <div class="carry-wire" id="wire-4" style="width:10px; opacity:0;"></div> 

            <div class="full-adder-box">
                <span class="adder-title">FULL ADDER</span>
                <span>Bit 3</span>
            </div>
            <div class="carry-wire" id="wire-3" title="Carry Out do bit 2 para 3"></div>

            <div class="full-adder-box">
                <span class="adder-title">FULL ADDER</span>
                <span>Bit 2</span>
            </div>
            <div class="carry-wire" id="wire-2" title="Carry Out do bit 1 para 2"></div>

            <div class="full-adder-box">
                <span class="adder-title">FULL ADDER</span>
                <span>Bit 1</span>
            </div>
            <div class="carry-wire" id="wire-1" title="Carry Out do bit 0 para 1"></div>

            <div class="full-adder-box">
                <span class="adder-title">FULL ADDER</span>
                <span>Bit 0</span>
            </div>
            
            <div class="carry-wire" style="background:#222"></div> 
        </div>

        <div class="lamps-area">
            <div class="lamp-container">
                <div class="redstone-lamp" id="lamp-cout"></div>
                <div class="label">16 (OVF)</div>
            </div>

            <div class="lamp-container">
                <div class="redstone-lamp" id="lamp-3"></div>
                <div class="label">8</div>
            </div>
            <div class="lamp-container">
                <div class="redstone-lamp" id="lamp-2"></div>
                <div class="label">4</div>
            </div>
            <div class="lamp-container">
                <div class="redstone-lamp" id="lamp-1"></div>
                <div class="label">2</div>
            </div>
            <div class="lamp-container">
                <div class="redstone-lamp" id="lamp-0"></div>
                <div class="label">1</div>
            </div>
        </div>

        <div class="sign-board">
            <div>RESULTADO:</div>
            <div class="sign-text" id="decimal-display">0 + 0 = 0</div>
            
            <div class="binary-text" id="binary-display">0000 + 0000 = 00000</div>
        </div>

        <button class="reset-btn" onclick="resetAll()">RESETAR SISTEMA</button>

    </div>

    <script>
    // Estado inicial dos bits [0, 0, 0, 0] (Do bit 1 ao 8)
    let bitsA = [0, 0, 0, 0];
    let bitsB = [0, 0, 0, 0];

    function toggleBit(type, index) {
        // Inverte o bit (0 vira 1, 1 vira 0)
        if (type === 'a') {
            bitsA[index] = bitsA[index] ? 0 : 1;
            // Atualiza visual da alavanca
            const lever = document.getElementById('a' + index);
            bitsA[index] ? lever.classList.add('on') : lever.classList.remove('on');
        } else {
            bitsB[index] = bitsB[index] ? 0 : 1;
            // Atualiza visual da alavanca
            const lever = document.getElementById('b' + index);
            bitsB[index] ? lever.classList.add('on') : lever.classList.remove('on');
        }
        calculate();
    }

    function calculate() {
        let carry = 0; // Começa com 0 (Carry In inicial)
        let totalSum = [];
        
        // Loop do Somador (Do bit 0 até o 3)
        for (let i = 0; i < 4; i++) {
            let a = bitsA[i];
            let b = bitsB[i];

            // LÓGICA DO FULL ADDER (IGUAL AO MINECRAFT)
            // 1. Soma (XOR)
            let sum = a ^ b ^ carry;
            
            // 2. Novo Carry (Se tiver pelo menos dois '1's, sobe 1)
            // Lógica: (A AND B) OR ((A XOR B) AND Cin)
            let newCarry = (a & b) | ((a ^ b) & carry);

            totalSum[i] = sum;

            // ATUALIZAR VISUAL
            // Acende a lâmpada do bit correspondente
            let lamp = document.getElementById('lamp-' + i);
            if (sum) lamp.classList.add('on'); else lamp.classList.remove('on');

            // Acende o fio de Carry se "foi 1" para o próximo
            // O fio 'wire-1' conecta o bit 0 ao 1, etc.
            if (i < 3) { // Não existe fio de entrada para o bit 0 visualmente aqui
                let wire = document.getElementById('wire-' + (i+1));
                if (wire) {
                        if (newCarry) wire.classList.add('on'); else wire.classList.remove('on');
                }
            }

            carry = newCarry; // Passa o bastão para o próximo bit
        }

        // Lida com o último Carry (Overflow / Bit 16)
        let lampCout = document.getElementById('lamp-cout');
        if (carry) lampCout.classList.add('on'); else lampCout.classList.remove('on');

        // --- PARTE 1: DISPLAY DECIMAL (Língua de gente) ---
        // Converte array binario pra decimal
        // Multiplica cada posição pelo seu valor (1, 2, 4, 8)
        let valA = bitsA[0]*1 + bitsA[1]*2 + bitsA[2]*4 + bitsA[3]*8;
        let valB = bitsB[0]*1 + bitsB[1]*2 + bitsB[2]*4 + bitsB[3]*8;
        let result = valA + valB;

        document.getElementById('decimal-display').innerText = `${valA} + ${valB} = ${result}`;

        // --- PARTE 2: DISPLAY BINÁRIO (Língua de Redstone) ---
        // .toString(2) transforma o número em texto binário
        // .padStart(4, '0') força ter 4 zeros (ex: 1 vira 0001)
        let binA = valA.toString(2).padStart(4, '0');
        let binB = valB.toString(2).padStart(4, '0');
        
        // Se tiver "estouro" (carry final), mostramos 5 dígitos, senão 4
        let padding = (carry) ? 5 : 4;
        let binResult = result.toString(2).padStart(padding, '0');

        // Atualiza a nova linha da placa se ela existir
        let binDisplay = document.getElementById('binary-display');
        if(binDisplay) {
            binDisplay.innerText = `${binA} + ${binB} = ${binResult}`;
        }
    }

    function resetAll() {
        bitsA = [0,0,0,0];
        bitsB = [0,0,0,0];
        document.querySelectorAll('.lever').forEach(el => el.classList.remove('on'));
        calculate();
    }
</script>
</body>
</html>