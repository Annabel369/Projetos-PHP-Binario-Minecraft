// script.js - VERSÃO ATUALIZADA
document.addEventListener('DOMContentLoaded', () => {
    const mainframe = document.getElementById('mainframe');
    const links = document.querySelectorAll('.category-link');
    const head = document.head;
    let currentStyleLink = null; // Para rastrear o CSS que está ativo

    const loadContent = (fileName, styleName, linkElement) => {
        // --- 1. CARREGAMENTO DO ESTILO ---
        
        // Remove o CSS anterior se houver
        if (currentStyleLink) {
            currentStyleLink.remove();
            currentStyleLink = null;
        }

        // Se houver um nome de estilo, cria e injeta o novo link CSS
        if (styleName && styleName !== 'style.css') {
            const newLink = document.createElement('link');
            newLink.rel = 'stylesheet';
            newLink.type = 'text/css';
            newLink.href = styleName; // Ex: binario.css
            newLink.id = 'dynamic-style'; // ID para facilitar a remoção
            head.appendChild(newLink);
            currentStyleLink = newLink;
        }

        // --- 2. CARREGAMENTO DO CONTEÚDO (AJAX) ---

        // Remove a classe 'active' de todos os links e adiciona ao clicado
        links.forEach(l => l.classList.remove('active'));
        linkElement.classList.add('active');

        mainframe.classList.add('loading');
        mainframe.innerHTML = ''; 

        fetch(fileName)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erro ${response.status}: O arquivo '${fileName}' não foi encontrado. Verifique se ele existe no diretório.`);
                }
                return response.text();
            })
            .then(htmlContent => {
                mainframe.innerHTML = htmlContent;
            })
            .catch(error => {
                console.error('Falha ao carregar a subcategoria:', error);
                mainframe.innerHTML = `<h3 style="color: red;">Erro ao carregar o conteúdo.</h3><p>${error.message}</p><p>Certifique-se de que todos os arquivos PHP (${fileName}) e CSS (${styleName}) existem no mesmo diretório do index.php.</p>`;
            })
            .finally(() => {
                mainframe.classList.remove('loading');
            });
    };

    links.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const fileName = link.getAttribute('data-file');
            const styleName = link.getAttribute('data-style');
            loadContent(fileName, styleName, link);
        });
    });
});