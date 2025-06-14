// public/js/sidebar.js

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const overlay = document.getElementById('overlay');
    const sidebarCollapse = document.getElementById('sidebarCollapse');

    // Função para abrir/fechar a sidebar
    function toggleSidebar() {
        sidebar.classList.toggle('active');
        mainContent.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    // Função para fechar a sidebar
    function closeSidebar() {
        sidebar.classList.remove('active');
        mainContent.classList.remove('active');
        overlay.classList.remove('active');
    }

    // Adiciona o evento de clique ao botão de toggle
    if (sidebarCollapse) {
        sidebarCollapse.addEventListener('click', function(event) {
            event.stopPropagation(); // Impede que o evento se propague
            toggleSidebar();
        });
    }

    // Adiciona o evento de clique ao overlay para fechar a sidebar
    if (overlay) {
        overlay.addEventListener('click', function() {
            closeSidebar();
        });
    }
});
