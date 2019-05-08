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
// 1. js and css
workbox.routing.registerRoute(
    new RegExp('https://d34use2w6yizv9.cloudfront.net/pre_prod/public/js/kss-pwa/*'),
    new workbox.strategies.StaleWhileRevalidate({
        cacheName: 'kss-pwa-pre-prod',
        plugins: [
            new workbox.expiration.Plugin({
                maxAgeSeconds: 60 * 60 * 24 * 7, // cache for one week
                maxEntries: 50, // only cache 20 request
                purgeOnQuotaError: true
            })
        ]
    })
);

workbox.routing.registerRoute(
    new RegExp('https://static.kidsuperstore.in/public/js/kss-pwa/*'),
    new workbox.strategies.StaleWhileRevalidate({
        cacheName: 'kss-pwa-prod',
        plugins: [
            new workbox.expiration.Plugin({
                maxAgeSeconds: 60 * 60 * 24 * 7, // cache for one week
                maxEntries: 50, // only cache 20 request
                purgeOnQuotaError: true
            })
        ]
    })
);

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

  
workbox.precaching.precacheAndRoute([]);