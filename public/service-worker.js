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
workbox.routing.registerRoute(
    new RegExp('https://demo8558685.mockable.io/*'),
    workbox.strategies.cacheFirst({
        cacheName: 'mock-apis',
        plugins: [
            new workbox.expiration.Plugin({
                maxAgeSeconds: 60 * 5,
                maxEntries: 50,
                purgeOnQuotaError: true
            })
        ]
    })
);

workbox.routing.registerRoute(
    new RegExp('/api/rest/v1/test/*'),
    workbox.strategies.cacheFirst({
        cacheName: 'kss-apis',
        plugins: [
            new workbox.expiration.Plugin({
                maxAgeSeconds: 60 * 5,
                maxEntries: 50,
                purgeOnQuotaError: true
            })
        ]
    })
);

self.addEventListener('push', (event) => {
  const title = 'Get Started With Workbox';
  const options = {
    body: event.data.text()
  };
  event.waitUntil(self.registration.showNotification(title, options));
});
  
workbox.precaching.precacheAndRoute([
  {
    "url": "views/kss-pwa/10.js",
    "revision": "0f46dcbf226fd1112ca3a3559bdad603"
  },
  {
    "url": "views/kss-pwa/11.js",
    "revision": "413549eb9b8f8340f486dd612b0abcc2"
  },
  {
    "url": "views/kss-pwa/12.js",
    "revision": "8b6c86a9b86e967ca3d5650d13c1c8bb"
  },
  {
    "url": "views/kss-pwa/2.js",
    "revision": "4c822d7bba61ecaa30f8b14636edbbc5"
  },
  {
    "url": "views/kss-pwa/6.js",
    "revision": "6a05681337827148de6c031b46d79a90"
  },
  {
    "url": "views/kss-pwa/7.js",
    "revision": "63c811596607f9611265bc3484354f5b"
  },
  {
    "url": "views/kss-pwa/8.js",
    "revision": "78f724c6e1f5a3fad1e4cc301481b009"
  },
  {
    "url": "views/kss-pwa/9.js",
    "revision": "1a71166e98efe3bb73a8d06c4fab4605"
  },
  {
    "url": "views/kss-pwa/common.js",
    "revision": "22640e4e6a460febb959c38bf7637176"
  },
  {
    "url": "views/kss-pwa/main.js",
    "revision": "a6e8a47b367e186b13900c035d09ebf5"
  },
  {
    "url": "views/kss-pwa/manifest.json",
    "revision": "035277ae8ad14276e9e2e4733880fe01"
  },
  {
    "url": "views/kss-pwa/polyfills.js",
    "revision": "82a7b35281f81eb4f07b52fcd8fcfa63"
  },
  {
    "url": "views/kss-pwa/runtime.js",
    "revision": "4a87c0ee2956a1f4b400dc4eda92a501"
  },
  {
    "url": "views/kss-pwa/scripts.js",
    "revision": "c5e088b34b57c3e649474523c3a9cdcc"
  },
  {
    "url": "views/kss-pwa/styles.css",
    "revision": "40b5175278b2ade400512fa3b1a2008b"
  },
  {
    "url": "manifest.json",
    "revision": "25c69e36df1f66ca96e7cbbc1d699727"
  },
  {
    "url": "img/kss_favicon.png",
    "revision": "1ecd0b099531329cdabf4b0a531cbca4"
  },
  {
    "url": "/newhome",
    "revision": "d3ceda1230d9223ea2436260a78656b0"
  }
]);