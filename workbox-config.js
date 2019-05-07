module.exports = {
  "globDirectory": "public/",
  "globPatterns": [
    // "views/kss-pwa/*.{css,ico,eot,svg,ttf,woff,woff2,js,json}",
    "views/kss-pwa/*.{css,js,json}",
    "manifest.json"
  ],
  "templatedUrls" : {
        '/': ['../resources/views/layouts/ng-default.php']
      },
  "swDest": "public/service-worker.js",
  "swSrc": "service-worker-src.js"
};