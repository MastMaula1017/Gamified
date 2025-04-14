// Header functionality for FitQuest
document.addEventListener('DOMContentLoaded', function() {
    const userMenuBtn = document.querySelector('#user-menu-btn, .user-avatar');
    const userDropdown = document.querySelector('#user-dropdown, .user-dropdown');

    if (!userMenuBtn || !userDropdown) {
        console.warn('Header: User menu elements not found.');
        return;
    }

    let isDropdownOpen = false;

    function openDropdown() {
        userDropdown.classList.add('active');
        isDropdownOpen = true;
        console.log('Header: Dropdown opened');
    }

    function closeDropdown() {
        userDropdown.classList.remove('active');
        isDropdownOpen = false;
        console.log('Header: Dropdown closed');
    }

    // Toggle dropdown on user menu click
    userMenuBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (isDropdownOpen) {
            closeDropdown();
        } else {
            openDropdown();
        }
    });

    // Handle clicking outside
    document.addEventListener('click', function(event) {
        if (isDropdownOpen && !userMenuBtn.contains(event.target) && !userDropdown.contains(event.target)) {
            closeDropdown();
        }
    });

    // Close dropdown when pressing Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isDropdownOpen) {
            closeDropdown();
            userMenuBtn.focus();
        }
    });

    // Handle focus trap inside dropdown
    userDropdown.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            const focusableElements = userDropdown.querySelectorAll('a, button, [tabindex="0"]');
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];

            if (e.shiftKey) {
                if (document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                }
            } else {
                if (document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        }
    });

    // Ensure dropdown is properly positioned
    function adjustDropdownPosition() {
        if (window.innerWidth <= 768) {
            // Mobile positioning
            userDropdown.style.position = 'fixed';
            userDropdown.style.top = 'auto';
            userDropdown.style.bottom = '70px';
            userDropdown.style.right = '20px';
            userDropdown.style.maxHeight = `${window.innerHeight - 100}px`;
            userDropdown.style.overflowY = 'auto';
        } else {
            // Desktop positioning
            userDropdown.style.position = 'absolute';
            userDropdown.style.top = '120%';
            userDropdown.style.bottom = 'auto';
            userDropdown.style.right = '0';
            userDropdown.style.maxHeight = '';
            userDropdown.style.overflowY = '';
        }
    }

    // Initial position adjustment
    adjustDropdownPosition();
    window.addEventListener('resize', adjustDropdownPosition);

    // Add CSS to ensure dropdown is visible
    const style = document.createElement('style');
    style.textContent = `
        .user-dropdown.active {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
            z-index: 1000;
        }
    `;
    document.head.appendChild(style);

    console.log('Header: Initialization complete');
});