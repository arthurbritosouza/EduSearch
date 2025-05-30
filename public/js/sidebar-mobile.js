
document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar em dispositivos móveis
    const sidebarCollapse = document.getElementById('sidebarCollapse');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const overlay = document.getElementById('overlay');

    if (sidebarCollapse) {
        sidebarCollapse.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('active');
            overlay.classList.toggle('active');
        });
    }

    // Fechar sidebar quando clicar no overlay
    if (overlay) {
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            mainContent.classList.remove('active');
            overlay.classList.remove('active');
        });
    }

    // Responsividade para dispositivos móveis
    function checkWidth() {
        if (window.innerWidth <= 991.98) {
            sidebar.classList.remove('active');
            mainContent.classList.remove('active');
            overlay.classList.remove('active');
        } else {
            sidebar.classList.remove('active');
            mainContent.classList.remove('active');
            overlay.classList.remove('active');
        }
    }

    window.addEventListener('resize', checkWidth);
    checkWidth();
});