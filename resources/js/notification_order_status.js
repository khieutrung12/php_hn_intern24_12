import Echo from "laravel-echo";
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
});

$(document).ready(function() {
      if(userID) {
          window.Echo.private(`order.${userID}`)
          .notification((notification) => {
                showNotifications(notification, '#notifications');
                var notificationsWrapper = $('.dropdown-notifications');
                var notificationsToggle = notificationsWrapper.find('a[data-toggle]');
                var notificationsCountElem = notificationsToggle.find('i[data-count]');
                var notificationsCount = parseInt(notificationsCountElem.data('count'));
                notificationsCount += 1;
                notificationsCountElem.attr('data-count', notificationsCount);
            });
    }
  
});

function showNotifications(notification, target) {
    if(notification.data) {
        $(target).prepend(makeNotification(notification));
    }
}

// Make a single notification string
function makeNotification(notification) {
        return `<a
        href="${notification.data.link}?read=${notification.id}">
        <li class="notification active">
            <div class="media">
                <div class="media-left">
                </div>
                <div class="media-body">
                    <strong
                        class="notification-title">
                        ${notification.data.title}</strong>
                    <div
                        class="notification-meta">
                        <small
                            class="timestamp">
                            ${notification.data.message}</small>
                        <span
                            class="dot unread-color"></span>
                    </div>
                </div>
            </div>
        </li>
    </a>`;
}
