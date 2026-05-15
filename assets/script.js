document.addEventListener('DOMContentLoaded', function() {
  const sidebar = document.querySelector('.sidebar');
  const mainContent = document.getElementById('main-content');
  const toggleBtn = document.getElementById('sidebar-toggle-btn');
  const openBtn = document.getElementById('open-sidebar-btn');

  function setCollapsed(collapsed) {
    if (collapsed) {
      sidebar.classList.add('collapsed');
      mainContent.classList.add('collapsed');
      if (toggleBtn) toggleBtn.textContent = 'Tampilkan Sidebar';
    } else {
      sidebar.classList.remove('collapsed');
      mainContent.classList.remove('collapsed');
      if (toggleBtn) toggleBtn.textContent = 'Sembunyikan Sidebar';
    }
  }

  if (toggleBtn) {
    toggleBtn.addEventListener('click', function() {
      setCollapsed(!sidebar.classList.contains('collapsed'));
    });
  }

  if (openBtn) {
    openBtn.addEventListener('click', function() {
      setCollapsed(false);
    });
  }

  setCollapsed(false);
});