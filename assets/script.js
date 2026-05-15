document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleBtn = document.getElementById('sidebar-toggle-btn');
    const openBtn = document.getElementById('open-sidebar-btn');

    function updateSidebarState(collapsed) {
        if (collapsed) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('collapsed');
            if (toggleBtn) toggleBtn.textContent = 'Tampilkan Sidebar';
            if (openBtn) openBtn.style.display = 'inline-block';
        } else {
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('collapsed');
            if (toggleBtn) toggleBtn.textContent = 'Sembunyikan Sidebar';
            if (openBtn) openBtn.style.display = 'none';
        }
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            const collapsed = !sidebar.classList.contains('collapsed');
            updateSidebarState(collapsed);
        });
    }

    if (openBtn) {
        openBtn.addEventListener('click', function() {
            updateSidebarState(false);
        });
    }

    updateSidebarState(false);
});