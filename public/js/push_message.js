window.Echo.private('App.User.' + Laravel.user.id)
.notification((notification) => {
  console.log(notification.type);

  Notification.requestPermission()
  .then(function(result) {
    if (result === "granted") {
      navigator.serviceWorker.getRegistration()
      .then(function(reg) {
        var options = {
          body: notification.message.title,
          icon: '/icon/android-icon-96x96.png',
          badge: '/icon/android-icon-192x192.png',
          vibrate: [100, 50, 100],
          image: notification.message.userAvatarUrl
        }
        reg.showNotification(notification.message.userName, options);
        //new Notification(e.message.userName, options);
      })

    }
  })
});
