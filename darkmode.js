function darkmode() {
    const body = document.body;
    const button = document.querySelector('.dark-button');
    
    if (!button) return;
    
    const icon = button.querySelector('i');
    
    body.classList.toggle('dark-mode');
    
    if (body.classList.contains('dark-mode')) {
        localStorage.setItem('darkMode', 'enabled');
        
        if (icon) {
            icon.className = 'fa fa-sun-o';
        }
        button.setAttribute('aria-pressed', 'true');
    } else {
        localStorage.setItem('darkMode', 'disabled');
        
        if (icon) {
            icon.className = 'fa fa-moon-o';
        }
        button.setAttribute('aria-pressed', 'false');
    }
}

function initDarkMode() {
    const darkModePreference = localStorage.getItem('darkMode');
    const body = document.body;
    const button = document.querySelector('.dark-button');
    
    if (button && darkModePreference === 'enabled') {
        body.classList.add('dark-mode');
        
        const icon = button.querySelector('i');
        if (icon) {
            icon.className = 'fa fa-sun-o';
        }
        button.setAttribute('aria-pressed', 'true');
    }
}

window.addEventListener('DOMContentLoaded', function() {
    setTimeout(initDarkMode, 100);
});

document.addEventListener('DOMContentLoaded', initDarkMode);
