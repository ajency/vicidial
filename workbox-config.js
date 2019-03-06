module.exports = {
  "globDirectory": "public/",
  "globPatterns": [
    "views/kss-pwa/*.{css,ico,eot,svg,ttf,woff,woff2,js,json}",
    "assets/**/*.{jpg,jpeg,png}",
    "manifest.json",
    "img/kss_favicon.png"
  ],
  "templatedUrls" : {
        '/newhome': ['../resources/views/home_new.blade.php']
      },
  "swDest": "public/service-worker.js",
  "swSrc": "service-worker-src.js"
};