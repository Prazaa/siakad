document.addEventListener('DOMContentLoaded', function() {
  const sidebar = document.querySelector('.sidebar');
  const mainContent = document.getElementById('main-content');
  const closeBtn = document.getElementById('sidebar-close-btn');
  const openBtn = document.getElementById('sidebar-open-btn');

  function setCollapsed(collapsed) {
    if (collapsed) {
      sidebar.classList.add('collapsed');
      mainContent.classList.add('collapsed');
    } else {
      sidebar.classList.remove('collapsed');
      mainContent.classList.remove('collapsed');
    }
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', function() {
      setCollapsed(true);
    });
  }

  if (openBtn) {
    openBtn.addEventListener('click', function() {
      setCollapsed(false);
    });
  }

  setCollapsed(false);
});
