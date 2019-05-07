const fs = require('fs-extra')
const path = require('path');

fs.remove('../public/js/kss-pwa/assets/SASS')
.then(() => {
  	console.log('removed sass folder');
	fs.copy('../public/js/kss-pwa/assets', '../public/assets', function (err) {
	  if (err) {
	    console.error(err);
	  } else {
	    console.log("assets folder copied to public");
	  }
	})
})
.catch(err => {
  console.error(err)
})

const file = '../public/js/kss-pwa/.gitignore'
fs.outputFile(file, '*')
	.then(() => fs.readFile(file, 'utf8'))
		.then(data => {
  			console.log(data) // => hello!
	})
	.catch(err => {
  		console.error(err)
	})


let file_hash = {};

function fromDir(startPath,filter){
    if (!fs.existsSync(startPath)){
        console.log("no dir ",startPath);
        return;
    }

    var files=fs.readdirSync(startPath);
    for(var i=0;i<files.length;i++){
        if (files[i].indexOf(filter)>=0) {
            console.log('-- found: ',files[i]);
            file_hash[files[i].split('.')[0]] = files[i].split('.')[1];
        };
    };
};

let files = ["runtime.", "polyfills.", "scripts." , "main.", "styles."]

for(let i = 0; i<files.length; i++){
    fromDir('../public/js/kss-pwa/', files[i]);
}

console.log("file hash ==>", file_hash);

fs.writeJson('../public/angular_file_hash.json', file_hash)
.then(() => {
  console.log('success!')
})
.catch(err => {
  console.error(err)
})
