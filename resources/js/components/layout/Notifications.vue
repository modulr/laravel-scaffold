<template>

</template>

<script>
export default {
  mounted () {
    this.subscribe()    
  },
  methods: {
    subscribe () {
      navigator.serviceWorker.ready.then(registration => {
        const options = { userVisibleOnly: true }
        const vapidPublicKey = process.env.MIX_VAPID_PUBLIC_KEY
        
        if (vapidPublicKey) {
          options.applicationServerKey = this.urlBase64ToUint8Array(vapidPublicKey)
        }
        registration.pushManager.subscribe(options)
          .then(subscription => {
            this.updateSubscription(subscription)
          })
          .catch(error => {
            if (Notification.permission === 'denied') {
              console.log('Permission for Notifications was denied')
            } else {
              console.log('Unable to subscribe to push.', error)
            }
          })
      })
    },
    updateSubscription (subscription) {
      console.log('Received PushSubscription: ', JSON.stringify(subscription));
      const key = subscription.getKey('p256dh')
      const token = subscription.getKey('auth')
      const contentEncoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0]
      // const data = {
      //   endpoint: subscription.endpoint,
      //   publicKey: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
      //   authToken: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null,
      //   contentEncoding
      // }
      const data = {
        endpoint: subscription.endpoint,
        publicKey: subscription.toJSON().keys.p256dh,
        authToken: subscription.toJSON().keys.auth,
        contentEncoding
      }
      console.log(data);
      
      axios.post('/subscriptions', data)
        .then(response => {
          console.log('Notifications subscribe successful') 
        })
    },
    urlBase64ToUint8Array(base64String) {
      var padding = '='.repeat((4 - base64String.length % 4) % 4);
      var base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

      var rawData = window.atob(base64);
      var outputArray = new Uint8Array(rawData.length);

      for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
      }
      return outputArray;
    }
  }
}
</script>
