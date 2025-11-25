<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutoriais de Arquitetura e Minecraft</title>
    <!-- Carregando Tailwind CSS para um visual moderno e responsivo -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Estilo personalizado para usar a fonte Inter e o fundo escuro */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0d1117; /* Fundo escuro sutil */
            color: #e5e7eb; /* Texto claro */
        }
        /* Classe para criar o efeito de sombra e profundidade nos cards de vídeo */
        .video-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
            background-color: #161b22; /* Fundo do card um pouco mais claro */
        }
        .video-card:hover {
            transform: translateY(-5px); /* Efeito de elevação ao passar o mouse */
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
        }
        /* Garante que o iframe do YouTube seja responsivo */
        .video-responsive {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
            height: 0;
            overflow: hidden;
            max-width: 100%;
        }
        .video-responsive iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 0.5rem; /* Borda arredondada para o player */
        }
    </style>
</head>
<body class="p-4 sm:p-8">

    <div class="max-w-6xl mx-auto">
        <!-- Título Principal -->
        <header class="text-center mb-12 py-6 border-b border-gray-700">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-blue-400 leading-tight">
                Tutoriais de Computação e Minecraft
            </h1>
            <p class="text-gray-400 mt-2 text-lg">Aprenda sobre Arquitetura de Computadores e Lógica Digital com Redstone!</p>
        </header>

        <!-- Container dos Vídeos (Grid Responsivo) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- Card 1: Compact Full Adder -->
            <div class="video-card p-4 rounded-xl border border-gray-700">
                <div class="video-responsive">
                    <iframe 
                        src="https://www.youtube.com/embed/tEnAyKipiEg" 
                        title="Minecraft Compact Full Adder [Tutorial]" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="mt-4">
                    <h2 class="text-xl font-bold text-gray-100">Minecraft Compact Full Adder [Tutorial]</h2>
                    <p class="text-sm text-gray-400 mt-1">
                        Aprenda a construir um somador completo compacto no Minecraft usando Redstone. Essencial para lógica digital!
                    </p>
                </div>
            </div>

            <!-- Card 2: Computer Architecture Explained -->
            <div class="video-card p-4 rounded-xl border border-gray-700">
                <div class="video-responsive">
                    <iframe 
                        src="https://www.youtube.com/embed/dV_lf1kyV9M" 
                        title="Computer Architecture Explained With MINECRAFT" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="mt-4">
                    <h2 class="text-xl font-bold text-gray-100">Computer Architecture Explained With MINECRAFT</h2>
                    <p class="text-sm text-gray-400 mt-1">
                        Uma explicação detalhada sobre arquitetura de computadores, ilustrada de forma criativa dentro do Minecraft.
                    </p>
                </div>
            </div>

            <!-- Card 3: How to build a computer TUTORIAL -->
            <div class="video-card p-4 rounded-xl border border-gray-700">
                <div class="video-responsive">
                    <iframe 
                        src="https://www.youtube.com/embed/6u2rzB3HtXM" 
                        title="How to build a computer TUTORIAL" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="mt-4">
                    <h2 class="text-xl font-bold text-gray-100">How to build a computer TUTORIAL (Logic Gates)</h2>
                    <p class="text-sm text-gray-400 mt-1">
                        Tutorial sobre como construir um computador do zero usando portas lógicas em uma simulação digital.
                    </p>
                </div>
            </div>

        </div>

        <!-- Rodapé/Informação extra -->
        <footer class="text-center mt-12 pt-6 border-t border-gray-700">
            <p class="text-gray-500 text-sm">Página criada para organizar seus tutoriais sobre lógica e arquitetura.</p>
        </footer>

    </div>

    <script>
        // Pequeno script para adicionar um efeito simples ao carregar a página
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.video-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50 * index); // Pequeno atraso para efeito cascata
            });
        });
    </script>
</body>
</html>