(function() {
    'use strict';

    var sidebarOverlay = document.getElementById('sidebarOverlay');
    var adminSidebar = document.getElementById('adminSidebar');
    var sidebarClose = document.getElementById('sidebarClose');

    function hideSidebar() {
        if (adminSidebar) adminSidebar.classList.remove('show');
        if (sidebarOverlay) sidebarOverlay.classList.remove('show');
    }

    function toggleSidebar() {
        if (adminSidebar) adminSidebar.classList.toggle('show');
        if (sidebarOverlay) sidebarOverlay.classList.toggle('show');
    }

    if (sidebarClose) {
        sidebarClose.addEventListener('click', hideSidebar);
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', hideSidebar);
    }

    var navToggle = document.querySelector('.nav-toggle-btn');
    if (navToggle) {
        navToggle.addEventListener('click', toggleSidebar);
    }

    var collapseLinks = document.querySelectorAll('.sidebar-nav-link[data-bs-toggle="collapse"]');
    collapseLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            var arrow = this.querySelector('.nav-arrow');
            if (arrow) {
                setTimeout(function() { arrow.classList.toggle('open'); }, 100);
            }
        });
    });

    var confirmDeletes = document.querySelectorAll('[data-confirm-delete]');
    confirmDeletes.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            if (!confirm(this.dataset.confirmDelete || 'Are you sure?')) {
                e.preventDefault();
            }
        });
    });
})();
