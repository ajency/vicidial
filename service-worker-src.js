importScripts('https://storage.googleapis.com/workbox-cdn/releases/3.6.3/workbox-sw.js');

workbox.skipWaiting();
workbox.clientsClaim();

// cache name
workbox.core.setCacheNameDetails({
    prefix: 'kss',
    precache: 'precache',
    runtime: 'runtime',
  });
  
// runtime cache
// 1. stylesheet
// workbox.routing.registerRoute(
//     new RegExp('\.css$'),
//     workbox.strategies.cacheFirst({
//         cacheName: 'My-awesome-cache-Stylesheets',
//         plugins: [
//             new workbox.expiration.Plugin({
//                 maxAgeSeconds: 60 * 60 * 24 * 7, // cache for one week
//                 maxEntries: 20, // only cache 20 request
//                 purgeOnQuotaError: true
//             })
//         ]
//     })
// );
// 2. images
workbox.routing.registerRoute(
    /\.(?:png|gif|jpg|jpeg|svg)$/,
    workbox.strategies.cacheFirst({
        cacheName: 'kss-images',
        plugins: [
            new workbox.expiration.Plugin({
                maxAgeSeconds: 60 * 60 * 24 * 7,
                maxEntries: 500,
                purgeOnQuotaError: true
            })
        ]
    })
);

//3. cache apis
// workbox.routing.registerRoute(
//     new RegExp('https://demo8558685.mockable.io/*'),
//     workbox.strategies.cacheFirst({
//         cacheName: 'mock-apis',
//         plugins: [
//             new workbox.expiration.Plugin({
//                 maxAgeSeconds: 60 * 5,
//                 maxEntries: 50,
//                 purgeOnQuotaError: true
//             })
//         ]
//     })
// );

// workbox.routing.registerRoute(
//     new RegExp('/api/rest/v1/test/*'),
//     workbox.strategies.cacheFirst({
//         cacheName: 'kss-apis',
//         plugins: [
//             new workbox.expiration.Plugin({
//                 maxAgeSeconds: 60 * 5,
//                 maxEntries: 50,
//                 purgeOnQuotaError: true
//             })
//         ]
//     })
// );

self.addEventListener('push', (event) => {
  const title = 'Get Started With Workbox';
  const options = {
    body: event.data.text()
  };
  event.waitUntil(self.registration.showNotification(title, options));
});
  
workbox.precaching.precacheAndRoute([]);