const cacheName = 'v1';
const cacheAssets = [
    '/eportal/result-app',
    '/eportal/public/css/overview.css',
    '/eportal/public/js/overview.js'
];

// installing serviceworker
self.addEventListener('install', e => {
    console.log('Service Worker: Installed');
    
    e.waitUntil(
        caches
            .open(cacheName)
            .then(cache => {
                console.log('Service Worker: Caching Files');
                cache.addAll(cacheAssets);
            }).then(() => self.skipWaiting())
    );
});

// activating serviceworker
// self.addEventListener('activate', e => {
//     console.log('Service Worker: Activated');
    
//     // removing unwanted caches
//     e.waitUntil(
//         caches.keys().then(cacheNames => {
//             return Promise.all(
//                 cacheNames.map(cache => {
//                     if(cache !== cacheName){
//                         console.log('Service Worker: Clearing Old Caches');
//                         return caches.delete(cache);
//                     }
//                 })
//             );
//         }).then(() => self.skipWaiting())
//     )
// });
self.addEventListener('activate', event => {
  event.waitUntil(self.clients.claim());
});

// calling fetch
self.addEventListener('fetch', e => {
    console.log('Service Worker: Fetching');
    console.log(e.request.url);
    e.respondWith(fetch(e.request).catch(() => caches.match(e.request)))
});