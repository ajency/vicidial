const fs = require('fs');
const path = require('path');
var fs_extra = require("fs-extra");

var rootDir = path.resolve(__dirname, '../');

var buildDir = path.resolve(__dirname, './dist'); // buildDir for cart app
// var buildDir = path.resolve(__dirname, './dist2'); // buildDir for account app

var destDir = path.resolve(rootDir, 'public/js/cart'); // destDir for cart app
// var destDir = path.resolve(rootDir, 'public/views/my-account'); //destDir for account app

let src = path.join(buildDir, 'main.bundle.js');

let filesnames = ['main.bundle.js', 'polyfills.bundle.js', 'styles.bundle.css', 'vendor.bundle.js', 'inline.bundle.js', '0.chunk.js', '1.chunk.js', '2.chunk.js'];

console.log("rootDir ==>", rootDir);
console.log("buildDir ==>", buildDir);
console.log("destination ==>", destDir);


fs.access(destDir, (err) => {
  if(err)
    fs.mkdirSync(destDir);

  let filesname;
  for(let i=0;i < filesnames.length; i++){
  	filesname = filesnames[i];
  	src = path.join(buildDir, filesname);
  	console.log(src);
	  copyFile(src, path.join(destDir, filesname));		  	
  }
});

function copyFile(src, dest) {

  let readStream = fs.createReadStream(src);

  readStream.once('error', (err) => {
    console.log(err);
  });

  readStream.once('end', () => {
    console.log('done copying');
  });

  readStream.pipe(fs.createWriteStream(dest));
}

// let assetsDir = path.resolve(__dirname, './dist/assets');
// let assetsDest = path.resolve(rootDir, 'public/assets');
// fs_extra.copy(assetsDir, assetsDest, function(error) {
// 	if(error)
// 		console.log("error in copying assets folder");

// 	console.log("assets copied successfully");
// })