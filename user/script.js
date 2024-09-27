console.log('user/script.js loaded');




document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('settingsIcon').addEventListener('click', function () {
        var dropdown = document.getElementById('settingsDropdown');
        dropdown.classList.toggle('hidden');
    });

    document.getElementById('profileIcon').addEventListener('click', function () {
        var dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('hidden');
    });

    window.onclick = function (event) {
        if (!event.target.closest('#settingsIcon') && !event.target.closest('#profileIcon')) {
            document.getElementById('settingsDropdown').classList.add('hidden');
            document.getElementById('profileDropdown').classList.add('hidden');
        }
    };
});
