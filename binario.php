<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora Binária (4 ou 8 Bits)</title>
    <!-- Carrega o Tailwind CSS para um estilo moderno -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Configuração de fonte padrão */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Garantindo que o input binário use uma fonte monoespaçada para melhor alinhamento */
        #binary-input {
            font-family: 'Consolas', 'Courier New', monospace;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-blue': '#1e40af', /* Darker blue for action */
                        'primary-light': '#3b82f6', /* Blue for buttons */
                        'bit-active': '#d1fae5', /* Light green for active bit */
                        'bit-border': '#10b981', /* Green border */
                        'text-active': '#065f46', /* Dark green text */
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

<div class="container bg-white p-6 md:p-10 rounded-xl shadow-2xl w-full max-w-xl">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-4 border-b pb-2">Calculadora Binária Visual</h1>
    <p class="text-gray-600 mb-6">Converta números binários para decimal e veja o valor de cada bit.</p>

    <form method="POST" id="binary-form">
        <!-- Seleção de Modo (4 ou 8 bits) -->
        <div class="mb-6 flex justify-center space-x-4">
            <label class="inline-flex items-center">
                <input type="radio" class="form-radio h-5 w-5 text-primary-light" name="mode" value="4"
                       onchange="updateInputLength(4)"
                       <?php echo (!isset($_POST['mode']) || $_POST['mode'] == '4') ? 'checked' : ''; ?>>
                <span class="ml-2 text-gray-700 font-medium">4 Bits</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" class="form-radio h-5 w-5 text-primary-light" name="mode" value="8"
                       onchange="updateInputLength(8)"
                       <?php echo (isset($_POST['mode']) && $_POST['mode'] == '8') ? 'checked' : ''; ?>>
                <span class="ml-2 text-gray-700 font-medium">8 Bits (Byte)</span>
            </label>
        </div>

        <!-- Campo de Input Binário -->
        <div class="flex flex-col items-center mb-6">
            <label for="binary-input" class="text-lg font-semibold text-gray-700 mb-2">Digite o Binário (0s e 1s):</label>
            <input type="text" id="binary-input" name="binario"
                   class="text-3xl p-3 w-full md:w-3/4 text-center tracking-widest border-2 border-primary-light focus:border-primary-blue rounded-lg transition duration-150 shadow-inner"
                   maxlength="<?php echo (isset($_POST['mode']) && $_POST['mode'] == '8') ? '8' : '4'; ?>"
                   placeholder="Ex: <?php echo (isset($_POST['mode']) && $_POST['mode'] == '8') ? '10101010' : '1010'; ?>"
                   value="<?php echo isset($_POST['binario']) ? htmlspecialchars($_POST['binario']) : ''; ?>" required>
        </div>

        <button type="submit"
                class="w-full bg-primary-light hover:bg-primary-blue text-white font-bold py-3 px-4 rounded-lg transition duration-300 shadow-md hover:shadow-lg">
            Converter para Decimal
        </button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mode = isset($_POST['mode']) && $_POST['mode'] == '8' ? 8 : 4;
        $binario = $_POST['binario'];

        // Limpa tudo que não for 0 ou 1
        $binario = preg_replace('/[^01]/', '', $binario);
        
        // Garante que tenha o número correto de dígitos, preenchendo com zeros
        $binario = str_pad($binario, $mode, "0", STR_PAD_LEFT);
        
        $bits = str_split($binario);
        
        // As potências de 2, dependendo do modo (4 ou 8 bits)
        $potencias = ($mode == 8) 
            ? [128, 64, 32, 16, 8, 4, 2, 1] 
            : [8, 4, 2, 1];

        $total = 0;
        $soma_visual = [];

        echo '<div class="mt-8 pt-6 border-t border-gray-200">';
        echo '<h2 class="text-2xl font-bold text-gray-800 mb-4">Visualização dos ' . $mode . ' Bits:</h2>';
        
        // Display dos bits (responsivo com grid)
        echo '<div class="grid ' . ($mode == 8 ? 'grid-cols-4 md:grid-cols-8' : 'grid-cols-4') . ' gap-2 md:gap-3 justify-center">';
        
        // Loop para desenhar cada caixinha
        for ($i = 0; $i < $mode; $i++) {
            $bit_atual = $bits[$i];
            $valor_potencia = $potencias[$i];
            
            $classe_ativo = ($bit_atual == '1') ? 'active bg-bit-active border-bit-border text-text-active shadow-md transition transform scale-105' : 'bg-gray-50 border-gray-300 text-gray-500';
            $classe_inativo = ($bit_atual == '0') ? 'opacity-60' : '';
            
            // Se o bit for 1, soma ao total
            if ($bit_atual == '1') {
                $total += $valor_potencia;
                $soma_visual[] = $valor_potencia;
            }
            
            // O HTML de cada caixinha
            echo "
            <div class='bit-box flex flex-col items-center justify-between p-2 rounded-lg border-2 text-center $classe_ativo $classe_inativo'>
                <div class='power-label text-xs font-light'>2<sup>" . ($mode - 1 - $i) . "</sup></div>
                <div class='value-label text-xl font-extrabold mb-1'>$valor_potencia</div>
                <div class='bit-value text-base font-semibold'>($bit_atual)</div>
            </div>";
        }
        echo '</div>'; // Fim do grid

        // Mostra o resultado final
        echo '<div class="result-area mt-8 bg-gray-50 p-4 rounded-lg border-l-4 border-primary-light">';
        echo '<div class="sum-text text-gray-600 text-sm md:text-base mb-2">Soma dos valores ativos: ' . (count($soma_visual) > 0 ? implode(" + ", $soma_visual) : '0') . '</div>';
        echo '<div class="final-result text-4xl font-black text-primary-blue">= ' . $total . '</div>';
        echo '</div>';
        echo '</div>'; // Fim da área de resultado
    }
    ?>
</div>

<script>
    // Função JavaScript para atualizar o maxlength do input
    function updateInputLength(length) {
        const input = document.getElementById('binary-input');
        input.maxLength = length;
        // Limpa o input se o novo tamanho for menor
        if (input.value.length > length) {
            input.value = input.value.substring(0, length);
        }
        // Atualiza o placeholder
        input.placeholder = (length === 8) ? 'Ex: 10101010' : 'Ex: 1010';
    }

    // Inicializa o input com o tamanho correto ao carregar a página
    window.onload = function() {
        const mode = document.querySelector('input[name="mode"]:checked').value;
        updateInputLength(parseInt(mode));
    }
</script>

</body>
</html>