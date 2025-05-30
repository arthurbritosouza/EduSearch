document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("main-content");
    const overlay = document.getElementById("overlay");
    const sidebarCollapse = document.getElementById("sidebarCollapse");

    function updateLayout() {
        const isMobile = window.innerWidth <= 991.98;
        if (!sidebar || !mainContent || !overlay) return;

        if (isMobile) {
            // MOBILE: sidebar controlado por .active (transform no CSS)
            sidebar.style.width = ''; // Remove largura fixa
            mainContent.style.marginLeft = "0";
            mainContent.style.width = "100%";
            // Overlay só aparece se sidebar está aberto
            if (sidebar.classList.contains('active')) {
                overlay.classList.add('active');
            } else {
                overlay.classList.remove('active');
            }
            // Remove classes/estilos desktop
            sidebar.classList.remove('chat-open');
        } else {
            // DESKTOP: sidebar fixo, remove .active e overlay
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            sidebar.style.width = "250px";
            mainContent.style.marginLeft = "250px";
            mainContent.style.width = "calc(100% - 250px)";
        }
    }

    // Botão para abrir/fechar sidebar no mobile
    if (sidebarCollapse) {
        sidebarCollapse.addEventListener('click', function() {
            if (window.innerWidth <= 991.98) {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }
        });
    }

    // Clicar no overlay fecha o sidebar no mobile
    if (overlay) {
        overlay.addEventListener('click', function() {
            if (window.innerWidth <= 991.98) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        });
    }

    // Fechar sidebar automaticamente ao clicar em um link no mobile
    const navLinks = document.querySelectorAll('.sidebar .nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 991.98) {
                sidebar.classList.remove("active");
                overlay.classList.remove("active");
            }
        });
    });

    window.addEventListener('resize', updateLayout);
    updateLayout();
});
