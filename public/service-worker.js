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
    "revision": "79c165c514c468dba863756d1ba4ecb4"
  },
  {
    "url": "views/kss-pwa/11.js",
    "revision": "81b5ac4a69fb95419ffc07108075b9b8"
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
    "revision": "5dd4e8b98d62d5f4cb467d4b22b208b7"
  },
  {
    "url": "views/kss-pwa/common.js",
    "revision": "22640e4e6a460febb959c38bf7637176"
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
    "revision": "c7e0751a9b103d40dee14a4ab018dd01"
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
    "revision": "96adf6e6fdf6b79f02b741806432e7ce"
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
    "url": "assets/img/brands-title.jpg",
    "revision": "b52f72195eb8c173dc85ee649474b555"
  },
  {
    "url": "assets/img/categories-title.jpg",
    "revision": "d572b0f40ab81fd99effd3cccd7aea38"
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
    "url": "assets/img/offers-title.jpg",
    "revision": "0dd577c99b34d880ca88b8b55444e1e0"
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
    "url": "assets/img/stories-title.jpg",
    "revision": "43400c35c8ac72c97b90d7a0dce07590"
  },
  {
    "url": "assets/img/theme_week-title.jpg",
    "revision": "f83c715cbf9081bd70b99c5deaf3f850"
  },
  {
    "url": "assets/img/transparent.png",
    "revision": "978c1bee49d7ad5fc1a4d81099b13e18"
  },
  {
    "url": "assets/img/trending_looks-title.jpg",
    "revision": "8d979d7673389c164e10bd7a4b067661"
  },
  {
    "url": "assets/img/whats_happening-title.jpg",
    "revision": "17f6dbaffd2802683153adb3325f6ca3"
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
    "url": "/",
    "revision": "14b10a647c81fd7e5202a53539e36e27"
  }
]);