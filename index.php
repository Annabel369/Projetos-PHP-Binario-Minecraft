<?php
// Define a página a ser carregada
$pagina_atual = 'home.php'; // Página padrão

// Verifica se o parâmetro 'page' foi passado na URL
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $caminho_solicitado = $_GET['page'];

    // Lista de arquivos permitidos (Whitelist) para segurança
    $arquivos_permitidos = [
        'home.php',
        'binario.php',
        'full_adder.php',
        'somador_minecraft.php',
        'somador2_minecraft.php',
        'tabela_mental.php',
        'ascii_display.php',
        'movie.php'
    ];

    // Garante que o arquivo solicitado está na nossa lista de permissão
    if (in_array($caminho_solicitado, $arquivos_permitidos) && file_exists($caminho_solicitado)) {
        $pagina_atual = $caminho_solicitado;
    } else {
        // Opcional: Redirecionar para uma página de erro ou voltar para a home
        $pagina_atual = '404.php'; // Você deve criar este arquivo
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Projetos</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>

    <header>
        <h1>Meus Projetos PHP</h1>
    </header>

    <div class="container">
        <nav class="sidebar">
            <h2>Navegação</h2>
            <ul>
                <?php
                // Array dos arquivos/subcategorias para criar os links
                $links_menu = [
                    'home.php' => 'Início',
                    'binario.php' => 'Conversor Binário',
                    'full_adder.php' => 'Circuito Full Adder',
                    'somador_minecraft.php' => 'Somador Minecraft (V1)',
                    'somador2_minecraft.php' => 'Somador Minecraft (V2)',
                    'tabela_mental.php' => 'Tabela Mental',
                    'ascii_display.php' => 'Display ASCII',
                    'movie.php' => 'Exemplo de Filme'
                ];

                // Gera os links usando o parâmetro 'page'
                foreach ($links_menu as $arquivo => $titulo) {
                    $active_class = ($arquivo === $pagina_atual) ? ' active' : '';
                    echo "<li><a href='index.php?page={$arquivo}' class='menu-link{$active_class}'>{$titulo}</a></li>";
                }
                ?>
            </ul>
        </nav>

        <main id="mainframe" class="content">
            <?php
            // **Este é o ponto crucial:** O PHP inclui (carrega) o arquivo solicitado
            // dentro da estrutura do index.php.
            include $pagina_atual;
            ?>
        </main>
    </div>

    <footer>
        <p>&copy; 2025 Meus Projetos</p>
    </footer>

</body>
</html>