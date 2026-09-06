        </div> <!-- End .main-content -->

    <script>
    // Sidebar Dropdown Logic
    document.querySelectorAll('.has-dropdown').forEach(item => {
        item.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.nextElementSibling;
            const arrow = this.querySelector('.dropdown-arrow');
            
            // Close other top-level dropdowns
            document.querySelectorAll('.sidebar-nav > .nav-group > .dropdown-content').forEach(content => {
                if (content !== dropdown) {
                    content.style.display = 'none';
                    const prevArrow = content.previousElementSibling.querySelector('.dropdown-arrow');
                    if (prevArrow) prevArrow.style.transform = 'rotate(0deg)';
                }
            });

            // Toggle current
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            } else {
                dropdown.style.display = 'block';
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            }
        });
    });

    // Mobile Toggle
    {
        const toggle = document.querySelector('.mobile-nav-toggle');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if(toggle && sidebar) {
            toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = sidebar.classList.toggle('mobile-active');
                const icon = toggle.querySelector('i');
                if (overlay) overlay.style.display = isOpen ? 'block' : 'none';
                if (icon) {
                    if (isOpen) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    } else {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                }
            });

            if (overlay) {
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('mobile-active');
                    overlay.style.display = 'none';
                    const icon = toggle.querySelector('i');
                    if (icon) {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });
            }
        }
    }
    // Auto-scroll sidebar to active menu
    window.addEventListener('load', function() {
        const activeItem = document.querySelector('.nav-item.active') || document.querySelector('.active-sub');
        if (activeItem) {
            activeItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
    </script>
</body>
</html>
