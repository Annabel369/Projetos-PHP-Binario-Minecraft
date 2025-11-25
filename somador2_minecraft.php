<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALU Minecraft 8-Bits</title>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #221811; 
            --stone: #757575;
            --redstone-off: #4a0e0e;
            --redstone-on: #ff0000;
            --lamp-off: #382515;
            --lamp-on: #ffecb3; 
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

        .game-board {
            background: #3b281f; 
            padding: 20px;
            border: 6px solid #222;
            border-radius: 4px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
            width: 90%; /* Aumenta a largura para 8 bits */
            max-width: 1200px;
        }

        .inputs-area {
            display: grid;
            grid-template-columns: repeat(9, 1fr); /* 8 bits + espaço */
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
        
        .lever {
            width: 40px; /* Reduz para caber 8 */
            height: 40px;
            background-color: var(--stone);
            border: 4px solid #444;
            cursor: pointer;
            position: relative;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.5);
        }
        .lever::after {
            content: '';
            position: absolute;
            width: 8px;
            height: 20px;
            background: #8b5a2b; 
            top: 10px;
            left: 14px;
            transition: transform 0.2s;
            transform-origin: bottom center;
            transform: rotate(-45deg); 
        }
        .lever.on::after { transform: rotate(45deg); }
        
        .redstone-dust {
            width: 8px;
            height: 8px;
            background: var(--redstone-off);
            margin-top: 3px;
            box-shadow: 0 0 2px var(--redstone-off);
        }
        .lever.on + .redstone-dust {
            background: var(--redstone-on);
            box-shadow: 0 0 8px var(--redstone-on);
        }
        
        .adder-chain {
            display: flex;
            flex-direction: row-reverse; 
            gap: 5px;
            align-items: center;
        }

        .full-adder-box {
            background-color: var(--wool-orange);
            border: 4px solid #a05000;
            width: 50px; /* Reduz para caber 8 */
            height: 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            font-size: 0.8rem;
        }

        .carry-wire {
            height: 6px;
            width: 10px;
            background-color: var(--redstone-off);
            transition: background 0.2s;
        }
        .carry-wire.on {
            background-color: var(--redstone-on);
            box-shadow: 0 0 10px var(--redstone-on);
        }

        .lamps-area {
            display: flex;
            flex-direction: row-reverse;
            gap: 20px; /* Ajusta espaçamento */
            margin-top: 10px;
            margin-right: -25px; 
        }

        .redstone-lamp {
            width: 40px;
            height: 40px;
        }

        .sign-board {
            background: #8d7650; 
            border: 4px solid #5d4037;
            padding: 15px 30px;
            color: #000;
            text-align: center;
            font-size: 1.5rem;
            min-width: 400px;
            margin-top: 20px;
        }
        .sign-text { font-size: 2.5rem; font-weight: bold; }
        .binary-text {
            font-size: 1.5rem; 
            color: #333; 
            margin-top: 5px; 
            font-family: 'Courier New', monospace;
            letter-spacing: 1px;
        }

        /* Novo estilo para o controle de operação */
        .op-control {
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 20px;
            background: rgba(0,0,0,0.2);
            padding: 10px;
            border-radius: 5px;
        }
        .op-select {
            padding: 5px;
            font-family: 'VT323', monospace;
            font-size: 1.2rem;
            background: #aaa;
        }

    </style>
</head>
<body>

    <h1>ALU 8 BITS <span style="font-size:1rem; vertical-align:middle">v.Minecraft</span></h1>

    <div class="op-control">
        <div class="label" style="font-size: 1.5rem; color: #ffeb3b;">FUNÇÃO:</div>
        <select id="operation" class="op-select" onchange="calculate()">
            <option value="add">SOMAR (A + B)</option>
            <option value="sub">SUBTRAIR (A - B)</option>
            <option value="mul">MULTIPLICAR (A * B)</option>
            <option value="div">DIVIDIR (A / B)</option>
        </select>
    </div>

    <div class="game-board">
        
        <div class="inputs-area">
            <div class="bit-column"><div class="label">128</div></div>
            <div class="bit-column"><div class="label">64</div></div>
            <div class="bit-column"><div class="label">32</div></div>
            <div class="bit-column"><div class="label">16</div></div>
            <div class="bit-column"><div class="label">8</div></div>
            <div class="bit-column"><div class="label">4</div></div>
            <div class="bit-column"><div class="label">2</div></div>
            <div class="bit-column"><div class="label">1</div></div>
            <div class="bit-column" style="width:20px"></div>

            <div class="bit-column"><div class="lever" id="a7" onclick="toggleBit('a', 7)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="a6" onclick="toggleBit('a', 6)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="a5" onclick="toggleBit('a', 5)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="a4" onclick="toggleBit('a', 4)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="a3" onclick="toggleBit('a', 3)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="a2" onclick="toggleBit('a', 2)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="a1" onclick="toggleBit('a', 1)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="a0" onclick="toggleBit('a', 0)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="label" style="color:#88f">A</div></div>
            
            <div class="bit-column"><div class="lever" id="b7" onclick="toggleBit('b', 7)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="b6" onclick="toggleBit('b', 6)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="b5" onclick="toggleBit('b', 5)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="b4" onclick="toggleBit('b', 4)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="b3" onclick="toggleBit('b', 3)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="b2" onclick="toggleBit('b', 2)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="b1" onclick="toggleBit('b', 1)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="b0" onclick="toggleBit('b', 0)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="label" style="color:#8f8">B</div></div>
        </div>

        <div class="adder-chain">
            <div class="carry-wire" id="wire-8" style="width:10px; opacity:0;"></div> 

            <div class="full-adder-box"><span>FA 7</span></div>
            <div class="carry-wire" id="wire-7" title="C-out 6 para C-in 7"></div>
            <div class="full-adder-box"><span>FA 6</span></div>
            <div class="carry-wire" id="wire-6" title="C-out 5 para C-in 6"></div>
            <div class="full-adder-box"><span>FA 5</span></div>
            <div class="carry-wire" id="wire-5" title="C-out 4 para C-in 5"></div>
            <div class="full-adder-box"><span>FA 4</span></div>
            <div class="carry-wire" id="wire-4" title="C-out 3 para C-in 4"></div>
            <div class="full-adder-box"><span>FA 3</span></div>
            <div class="carry-wire" id="wire-3" title="C-out 2 para C-in 3"></div>
            <div class="full-adder-box"><span>FA 2</span></div>
            <div class="carry-wire" id="wire-2" title="C-out 1 para C-in 2"></div>
            <div class="full-adder-box"><span>FA 1</span></div>
            <div class="carry-wire" id="wire-1" title="C-out 0 para C-in 1"></div>
            <div class="full-adder-box"><span>FA 0</span></div>
            
            <div class="carry-wire" id="cin-wire" style="background:#222; width: 10px;"></div> 
        </div>

        <div class="lamps-area">
            <div class="lamp-container">
                <div class="redstone-lamp" id="lamp-cout"></div>
                <div class="label">256 (OVF)</div>
            </div>
            <div class="lamp-container"><div class="redstone-lamp" id="lamp-7"></div><div class="label">128</div></div>
            <div class="lamp-container"><div class="redstone-lamp" id="lamp-6"></div><div class="label">64</div></div>
            <div class="lamp-container"><div class="redstone-lamp" id="lamp-5"></div><div class="label">32</div></div>
            <div class="lamp-container"><div class="redstone-lamp" id="lamp-4"></div><div class="label">16</div></div>
            <div class="lamp-container"><div class="redstone-lamp" id="lamp-3"></div><div class="label">8</div></div>
            <div class="lamp-container"><div class="redstone-lamp" id="lamp-2"></div><div class="label">4</div></div>
            <div class="lamp-container"><div class="redstone-lamp" id="lamp-1"></div><div class="label">2</div></div>
            <div class="lamp-container"><div class="redstone-lamp" id="lamp-0"></div><div class="label">1</div></div>
        </div>

        <div class="sign-board">
            <div>CÁLCULO (DECIMAL):</div>
            <div class="sign-text" id="decimal-display">0 + 0 = 0</div>
            
            <div>CÁLCULO (BINÁRIO):</div>
            <div class="binary-text" id="binary-display">00000000 + 00000000 = 000000000</div>
        </div>

        <button class="reset-btn" onclick="resetAll()">RESETAR SISTEMA</button>

    </div>

    <script>
    const BIT_COUNT = 8;
    // Estado inicial dos bits, agora com 8 posições
    let bitsA = Array(BIT_COUNT).fill(0);
    let bitsB = Array(BIT_COUNT).fill(0);

    // Array de pesos para converter para decimal (1, 2, 4, 8, 16, 32, 64, 128)
    const weights = Array.from({length: BIT_COUNT}, (_, i) => Math.pow(2, i));

    function toggleBit(type, index) {
        if (type === 'a') {
            bitsA[index] = bitsA[index] ? 0 : 1;
            const lever = document.getElementById('a' + index);
            bitsA[index] ? lever.classList.add('on') : lever.classList.remove('on');
        } else {
            bitsB[index] = bitsB[index] ? 0 : 1;
            const lever = document.getElementById('b' + index);
            bitsB[index] ? lever.classList.add('on') : lever.classList.remove('on');
        }
        calculate();
    }

    // Função auxiliar para converter binário para decimal
    function binToDec(bits) {
        return bits.reduce((acc, bit, i) => acc + bit * weights[i], 0);
    }

    function calculate() {
        const operation = document.getElementById('operation').value;
        const valA = binToDec(bitsA);
        let valB = binToDec(bitsB);
        let resultDec;
        let operator;
        let carryInitial = 0; // Carry In de FA0
        
        // --- LÓGICA DA ALU (SELEÇÃO DE OPERAÇÃO) ---
        if (operation === 'add') {
            operator = '+';
            resultDec = valA + valB;
            // Para Soma, o CARRY IN inicial (FA0) é 0 (OFF)
            carryInitial = 0; 
            document.getElementById('cin-wire').classList.remove('on');

        } else if (operation === 'sub') {
            operator = '-';
            resultDec = valA - valB;
            // Para Subtração (A - B), usamos o Complemento de Dois: A + (~B) + 1
            // ~B: Inverter B. O +1 é o Carry In inicial (FA0)
            carryInitial = 1; 
            document.getElementById('cin-wire').classList.add('on');
            
        } else {
            // Se for Multiplicação ou Divisão, usamos apenas a função matemática,
            // pois o hardware sequencial seria muito complexo de simular
            if (operation === 'mul') {
                operator = '*';
                resultDec = valA * valB;
            } else if (operation === 'div') {
                operator = '/';
                resultDec = valB === 0 ? "Erro (Div/0)" : Math.floor(valA / valB); // Apenas a parte inteira
            }
            // Desligamos visualmente a cadeia de Carry, pois não estamos usando o somador.
            document.getElementById('cin-wire').classList.remove('on');
            for (let i = 1; i <= BIT_COUNT - 1; i++) {
                document.getElementById('wire-' + i).classList.remove('on');
            }
        }
        
        // --- SIMULAÇÃO DA CADEIA DE SOMADOR (Ripple Carry) ---
        // A simulação da ALU só se aplica à Soma/Subtração
        let carry = carryInitial; 
        
        // Usamos uma cópia de B, invertida se for Subtração
        let bForAdder = [...bitsB];
        if (operation === 'sub') {
            // Simula as portas XOR na frente de B: ~B
            bForAdder = bForAdder.map(bit => bit ^ 1);
        }
        
        let finalSumBits = [];

        for (let i = 0; i < BIT_COUNT; i++) {
            // No modo de Subtração (A + ~B + 1), B já está invertido acima (bForAdder)
            const a = bitsA[i];
            const b = bForAdder[i]; 

            // LÓGICA DO FULL ADDER
            let sum = a ^ b ^ carry; // Porta XOR para a Soma
            let newCarry = (a & b) | ((a ^ b) & carry); // Portas AND/OR para o Novo Carry

            finalSumBits[i] = sum;

            // ATUALIZAR VISUAL das Lâmpadas (Soma/Resultado)
            let lamp = document.getElementById('lamp-' + i);
            if (sum && (operation === 'add' || operation === 'sub')) {
                 // Acende apenas para Soma e Subtração (Multiplicação/Divisão são complexos demais para o display simples)
                lamp.classList.add('on');
            } else {
                lamp.classList.remove('on');
            }

            // ATUALIZAR VISUAL do Fio de Carry
            if (i < BIT_COUNT - 1) { 
                let wire = document.getElementById('wire-' + (i+1));
                if (wire && (operation === 'add' || operation === 'sub')) {
                    if (newCarry) wire.classList.add('on'); else wire.classList.remove('on');
                } else if (wire) {
                    wire.classList.remove('on');
                }
            }

            carry = newCarry; // Passa o Carry para o próximo bit
        }

        // Lida com o último Carry (Overflow / Bit 256)
        let lampCout = document.getElementById('lamp-cout');
        if (carry && (operation === 'add' || operation === 'sub')) lampCout.classList.add('on'); else lampCout.classList.remove('on');
        
        // --- PARTE 3: DISPLAYS ---
        document.getElementById('decimal-display').innerText = `${valA} ${operator} ${valB} = ${resultDec}`;

        let binA = valA.toString(2).padStart(BIT_COUNT, '0');
        let binB = valB.toString(2).padStart(BIT_COUNT, '0');
        
        // Exibe o resultado binário da soma/subtração se for o caso
        let binResult = "";
        if (operation === 'add' || operation === 'sub') {
             // Se houver carry final, o resultado tem BIT_COUNT + 1 bits (9 bits)
            let padding = carry ? BIT_COUNT + 1 : BIT_COUNT;
            binResult = (resultDec >>> 0).toString(2).padStart(padding, '0'); // >>> 0 para garantir que é um inteiro não-assinado (evita números negativos)
            if (operation === 'sub' && valA < valB) binResult = "NEGATIVO"; // Não lidamos com Complemento de Dois negativo aqui.
        } else {
            // Multiplicação/Divisão apenas mostram o resultado decimal
            binResult = resultDec.toString().substring(0, 15);
        }

        let binDisplay = document.getElementById('binary-display');
        binDisplay.innerText = `${binA} ${operator} ${binB} = ${binResult}`;
    }

    function resetAll() {
        bitsA = Array(BIT_COUNT).fill(0);
        bitsB = Array(BIT_COUNT).fill(0);
        document.querySelectorAll('.lever').forEach(el => el.classList.remove('on'));
        document.getElementById('operation').value = 'add'; // Volta para soma
        calculate(); 
    }

    window.onload = resetAll; // Inicializa o sistema ao carregar a página
    </script>
</body>
</html>