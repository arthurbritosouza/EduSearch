// public/js/sidebar.js

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const overlay = document.getElementById('overlay');
    const sidebarCollapse = document.getElementById('sidebarCollapse');

    // --- Persistência do estado do sidebar ---
    function setSidebarState(isActive) {
        localStorage.setItem('sidebarActive', isActive ? '1' : '0');
    }
    function getSidebarState() {
        return localStorage.getItem('sidebarActive') === '1';
    }

    // --- Persistência do estado das gavetas (drawers) ---
    const drawerIds = ['estudosDrawer', 'colaborativoDrawer', 'ferramentasDrawer'];
    function setDrawerState(id, isOpen) {
        localStorage.setItem('drawer_' + id, isOpen ? '1' : '0');
    }
    function getDrawerState(id) {
        return localStorage.getItem('drawer_' + id) === '1';
    }

    // Função para abrir/fechar a sidebar
    function toggleSidebar() {
        sidebar.classList.toggle('active');
        mainContent.classList.toggle('active');
        overlay.classList.toggle('active');
        setSidebarState(sidebar.classList.contains('active'));
    }

    // Função para fechar a sidebar
    function closeSidebar() {
        sidebar.classList.remove('active');
        mainContent.classList.remove('active');
        overlay.classList.remove('active');
        setSidebarState(false);
    }

    // Restaurar estado do sidebar ao carregar
    if (getSidebarState()) {
        sidebar.classList.add('active');
        mainContent.classList.add('active');
        overlay.classList.add('active');
    }

    // Adiciona o evento de clique ao botão de toggle
    if (sidebarCollapse) {
        sidebarCollapse.addEventListener('click', function(event) {
            event.stopPropagation();
            toggleSidebar();
        });
    }

    // Adiciona o evento de clique ao overlay para fechar a sidebar
    if (overlay) {
        overlay.addEventListener('click', function() {
            closeSidebar();
        });
    }

    // --- Gavetas (drawers) ---
    // Espera o Bootstrap inicializar os collapses
    setTimeout(function() {
        drawerIds.forEach(function(id) {
            const drawer = document.getElementById(id);
            const toggle = document.querySelector('[data-bs-target="#' + id + '"]');
            if (drawer && toggle) {
                // Restaurar estado salvo
                if (getDrawerState(id)) {
                    drawer.classList.add('show');
                    toggle.setAttribute('aria-expanded', 'true');
                } else {
                    drawer.classList.remove('show');
                    toggle.setAttribute('aria-expanded', 'false');
                }
                // Salvar estado ao abrir/fechar
                toggle.addEventListener('click', function() {
                    setTimeout(function() {
                        setDrawerState(id, drawer.classList.contains('show'));
                    }, 350); // espera animação
                });
            }
        });
    }, 100); // Executa após Bootstrap
});
