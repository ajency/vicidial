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
    "url": "views/kss-pwa/4.js",
    "revision": "f32cbc19eb2c1d1d80828a65d6590479"
  },
  {
    "url": "views/kss-pwa/fa-brands-400.eot",
    "revision": "3186ebd2918491445ea391a4f74e8dd7"
  },
  {
    "url": "views/kss-pwa/fa-brands-400.svg",
    "revision": "e4fed0a589f7130c6ef834a029854646"
  },
  {
    "url": "views/kss-pwa/fa-brands-400.ttf",
    "revision": "a995bae1d3cba3bdcf24071bf09b51c8"
  },
  {
    "url": "views/kss-pwa/fa-brands-400.woff",
    "revision": "c7d7a2a1781e8da1dc85deb1e4f39b84"
  },
  {
    "url": "views/kss-pwa/fa-brands-400.woff2",
    "revision": "662c24d02ff1711bd01ec3868df8680b"
  },
  {
    "url": "views/kss-pwa/fa-regular-400.eot",
    "revision": "80efa56be5eaebd06ea34f1adbad071c"
  },
  {
    "url": "views/kss-pwa/fa-regular-400.svg",
    "revision": "304f31f4585cf09768f9d4d69574d2d6"
  },
  {
    "url": "views/kss-pwa/fa-regular-400.ttf",
    "revision": "fcb220ee57704c9c80680153bada946c"
  },
  {
    "url": "views/kss-pwa/fa-regular-400.woff",
    "revision": "72f15fa766bc05a4b3ecaa8579763f85"
  },
  {
    "url": "views/kss-pwa/fa-regular-400.woff2",
    "revision": "6a9d786e67d54419d8629081fbb555d6"
  },
  {
    "url": "views/kss-pwa/fa-solid-900.eot",
    "revision": "9a52a4e971938c52d6c541b9bf3dc2ec"
  },
  {
    "url": "views/kss-pwa/fa-solid-900.svg",
    "revision": "c8ea4c79af12c22b2b6073999137156c"
  },
  {
    "url": "views/kss-pwa/fa-solid-900.ttf",
    "revision": "20c189aa192501e4ec907d5f84e8fbb1"
  },
  {
    "url": "views/kss-pwa/fa-solid-900.woff",
    "revision": "9c73abbdbd6492778680163269b68345"
  },
  {
    "url": "views/kss-pwa/fa-solid-900.woff2",
    "revision": "3638e62ea50e6f5859b6a15276c25c87"
  },
  {
    "url": "views/kss-pwa/main.js",
    "revision": "90f86a1ab82da3393d69f97700c138ce"
  },
  {
    "url": "views/kss-pwa/polyfills.js",
    "revision": "64c7b21bf2728f60c5215abddb94cec2"
  },
  {
    "url": "views/kss-pwa/runtime.js",
    "revision": "61aab71258b67c53e09dc375632f9529"
  },
  {
    "url": "views/kss-pwa/styles.css",
    "revision": "2045ddcecbfe740ac44d894d583cf39b"
  },
  {
    "url": "assets/icons/icon1.png",
    "revision": "0203e3c9074dc56d0c9c9fc5fa98497c"
  },
  {
    "url": "assets/icons/icon2.png",
    "revision": "ca5971e91609cacb537def51aa6ee714"
  },
  {
    "url": "assets/icons/icon3.png",
    "revision": "fbb97ff15c214fb3829ee53a3fe5197a"
  },
  {
    "url": "assets/icons/icon4.png",
    "revision": "836899f53d7091ee6f5a076c864c66a1"
  },
  {
    "url": "assets/icons/icon5.png",
    "revision": "006de5b03cb044a230aa496e73e1c8c4"
  },
  {
    "url": "assets/icons/icon6.png",
    "revision": "5471f3683173c20070353535bfdfcf57"
  },
  {
    "url": "assets/icons/icon7.png",
    "revision": "f18a095ded5de1b901754b5ab0263078"
  },
  {
    "url": "assets/icons/icon8.png",
    "revision": "652625682251933e5afc560797faa0c2"
  },
  {
    "url": "assets/img/256-encryption.png",
    "revision": "5fa9910c0fded4ab7bc175b7f147d0ab"
  },
  {
    "url": "assets/img/error.png",
    "revision": "2cec9c62bd87fd2ab12401d00c5a1ed8"
  },
  {
    "url": "assets/img/logo-kss.png",
    "revision": "2f0e741422e56da4551a215da51851a1"
  },
  {
    "url": "assets/img/secured-payu.png",
    "revision": "0e40d7acf0e9e2f7b2ccb5ff638dde1c"
  },
  {
    "url": "assets/img/sprite.png",
    "revision": "d21485823ec5604aeee210775bab5ebb"
  },
  {
    "url": "assets/img/transparent.png",
    "revision": "978c1bee49d7ad5fc1a4d81099b13e18"
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
    "revision": "19a7044a059cfc411b060ce7f4d9b068"
  }
]);