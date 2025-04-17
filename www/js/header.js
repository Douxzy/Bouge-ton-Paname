function toggleNotifications() {
    const panel = document.getElementById('notificationPanel');
    panel.classList.toggle('translate-x-full');
}

function askNotificationPermission() {
    Notification.requestPermission().then(permission => {
        if (permission === "granted") {
            alert("Notifications activées !");
        } else {
            alert("Notifications refusées.");
        }
    });
}
const btn = document.getElementById('mobile-menu-button');
const menu = document.getElementById('mobile-menu');

btn.addEventListener('click', () => {
    menu.classList.toggle('hidden');
});