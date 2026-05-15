document.addEventListener('DOMContentLoaded', function() {
  const sidebar = document.querySelector('.sidebar');
  const mainContent = document.getElementById('main-content');
  const toggleBtn = document.getElementById('sidebar-toggle-btn');

  function toggleCollapsed() {
    const collapsed = sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('collapsed');
    // update aria-expanded for accessibility
    if (toggleBtn) toggleBtn.setAttribute('aria-expanded', (!collapsed).toString());
  }

  if (toggleBtn) {
    toggleBtn.addEventListener('click', function() {
      toggleCollapsed();
    });
  }

  // initialize aria state
  if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'true');
});
