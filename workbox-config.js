module.exports = {
  "globDirectory": "public/",
  "globPatterns": [
    // "views/kss-pwa/*.{css,ico,eot,svg,ttf,woff,woff2,js,json}",
    // "js/kss-pwa/*.{css,js,json}",
    "manifest.json"
  ],
  // "templatedUrls" : {
  //       '/': ['../resources/views/layouts/ng-default.blade.php']
  //     },
  "swDest": "public/service-worker.js",
  "swSrc": "service-worker-src.js"
};