// paystack key
const pk_test_4nc9wbc9wbcyw97wt99e86e86q880q9e038683q6yd88 = 'pk_live_0573173e6e3ff9ba3c3e5a61a18d41118c3a74a5';
// check if serviceWorker
if('serviceWorker' in navigator){
    window.addEventListener('load', () => {
        navigator.serviceWorker
            .register('/eportal/public/js/sw_cached.js')
            .then(reg => console.log('Service Worker: Registered'))
            .catch(err => console.log(`Service Worker: Error => ${err}`))
    })
}