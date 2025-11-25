<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display ASCII 8-Bits</title>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #221811; 
            --stone: #757575;
            --redstone-off: #4a0e0e;
            --redstone-on: #ff0000;
            --lamp-off: #382515;
            --lamp-on: #ffecb3; 
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

        h1 { color: #55ff55; text-shadow: 3px 3px #000; font-size: 2.5rem; margin-bottom: 10px; }

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
            width: 90%;
            max-width: 800px;
        }

        /* Área dos Inputs (Apenas um registrador A) */
        .inputs-area {
            display: grid;
            grid-template-columns: repeat(8, 1fr); 
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
        
        /* Estilos da alavanca (iguais) */
        .lever {
            width: 40px; 
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

        /* Placa de Display Principal */
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
        .sign-text { 
            font-size: 5rem; 
            font-weight: bold; 
            color: #ff0000; /* Destaque para o caractere */
            text-shadow: 3px 3px #333;
        }
        .binary-text {
            font-size: 1.5rem; 
            color: #333; 
            margin-top: 5px; 
            font-family: 'Courier New', monospace;
            letter-spacing: 1px;
        }

        /* Seleção de Caractere (igual ao anterior) */
        .char-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            align-items: center;
        }
        .char-selector select {
            padding: 5px;
            font-family: 'VT323', monospace;
            font-size: 1.2rem;
            background: #c3c3c3;
            border: 2px solid #555;
            cursor: pointer;
        }
        .info-panel {
            background: #444;
            padding: 10px;
            border-radius: 4px;
            font-size: 1.2rem;
        }

    </style>
</head>
<body>

    <h1>DECODIFICADOR DE CARACTERE ASCII 8 BITS</h1>
    <div class="info-panel">
        <span style="color: #ffeb3b;">Objetivo:</span> Converter 8 bits binários para um Caractere.
    </div>
    
    <div class="game-board">

        <div class="char-selector">
            <label style="color:#fff;">Escolher Caractere:</label>
            <select id="charA" onchange="setBitsFromChar(this.value)">
                <option value="">-- Manual (Alavancas) --</option>
                <script>
                    for(let i = 65; i <= 90; i++) { 
                        document.write(`<option value="${String.fromCharCode(i)}">${String.fromCharCode(i)} (ASCII ${i})</option>`);
                    }
                    for(let i = 97; i <= 122; i++) { 
                        document.write(`<option value="${String.fromCharCode(i)}">${String.fromCharCode(i)} (ASCII ${i})</option>`);
                    }
                    // Adicionando alguns símbolos úteis
                    document.write(`<option value=" ">Espaço (32)</option>`);
                    document.write(`<option value="!">Ponto Excl. (33)</option>`);
                </script>
            </select>
        </div>
        
        <div class="inputs-area">
            <div class="bit-column"><div class="label">128</div></div>
            <div class="bit-column"><div class="label">64</div></div>
            <div class="bit-column"><div class="label">32</div></div>
            <div class="bit-column"><div class="label">16</div></div>
            <div class="bit-column"><div class="label">8</div></div>
            <div class="bit-column"><div class="label">4</div></div>
            <div class="bit-column"><div class="label">2</div></div>
            <div class="bit-column"><div class="label">1</div></div>

            <div class="bit-column"><div class="lever" id="a7" onclick="toggleBit(7)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="a6" onclick="toggleBit(6)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="a5" onclick="toggleBit(5)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="a4" onclick="toggleBit(4)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="a3" onclick="toggleBit(3)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="a2" onclick="toggleBit(2)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="a1" onclick="toggleBit(1)"></div><div class="redstone-dust"></div></div>
            <div class="bit-column"><div class="lever" id="a0" onclick="toggleBit(0)"></div><div class="redstone-dust"></div></div>
        </div>

        <div class="sign-board">
            <div>CARACTERE DE SAÍDA:</div>
            <div class="sign-text" id="char-display">?</div>
            
            <div>CÓDIGO (Decimal / Binário):</div>
            <div class="binary-text" id="decimal-binary-display">0 / 00000000</div>
        </div>

        <button class="reset-btn" onclick="resetAll()">ZERAR REGISTRADOR</button>

    </div>

    <script>
    const BIT_COUNT = 8;
    // Apenas um registrador de 8 bits
    let bits = Array(BIT_COUNT).fill(0);
    const weights = Array.from({length: BIT_COUNT}, (_, i) => Math.pow(2, i));

    // Função para ligar/desligar uma alavanca e recalcular
    function toggleBit(index) {
        bits[index] = bits[index] ? 0 : 1;
        document.getElementById('a' + index).classList.toggle('on', bits[index]);
        document.getElementById('charA').value = ''; // Retira a seleção de caractere
        displayChar();
    }

    // Função para converter binário para decimal (para obter o código ASCII)
    function binToDec(bitsArray) {
        return bitsArray.reduce((acc, bit, i) => acc + bit * weights[i], 0);
    }
    
    // Função para definir os bits a partir de um caractere
    function setBitsFromChar(char) {
        if (!char) {
            displayChar();
            return;
        }

        const asciiValue = char.charCodeAt(0);
        
        // Converte o valor ASCII (decimal) para binário (string) e depois para array de bits
        const binString = asciiValue.toString(2).padStart(BIT_COUNT, '0');
        // Transforma a string binária em array de números, e inverte (para o bit 0 ser o primeiro)
        const newBits = binString.split('').reverse().map(Number); 

        bits = newBits;

        // Atualiza a interface (alavancas)
        for (let i = 0; i < BIT_COUNT; i++) {
            document.getElementById('a' + i).classList.toggle('on', bits[i]);
        }
        
        displayChar();
    }

    // A função principal que pega os bits e exibe o caractere
    function displayChar() {
        const decimalValue = binToDec(bits);
        const binString = decimalValue.toString(2).padStart(BIT_COUNT, '0');
        let charResult = "";
        let displayText = `Decimal: ${decimalValue}`;
        
        // Caracteres ASCII válidos (0 a 255)
        if (decimalValue >= 0 && decimalValue <= 255) {
            charResult = String.fromCharCode(decimalValue);
            
            // Verifica se é um caractere imprimível (Para não mostrar códigos de controle)
            if (decimalValue >= 32 && decimalValue <= 126) {
                 document.getElementById('char-display').innerText = charResult;
                 displayText += ` / Binário: ${binString}`;
            } else {
                 document.getElementById('char-display').innerText = '?';
                 displayText += ` / Binário: ${binString} (Não Imprimível)`;
            }

        } else {
            // Caso teoricamente impossível com 8 bits
            document.getElementById('char-display').innerText = 'ERRO';
            displayText += ` / Binário: ${binString}`;
        }
        
        document.getElementById('decimal-binary-display').innerText = displayText;
    }

    function resetAll() {
        bits = Array(BIT_COUNT).fill(0);
        document.querySelectorAll('.lever').forEach(el => el.classList.remove('on'));
        document.getElementById('charA').value = '';
        displayChar(); 
    }

    window.onload = resetAll;
    </script>
</body>
</html>