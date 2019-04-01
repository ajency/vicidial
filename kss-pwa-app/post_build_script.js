const fs = require('fs-extra')


fs.remove('../public/views/kss-pwa/assets/SASS')
.then(() => {
  	console.log('removed sass folder');
	fs.move('../public/views/kss-pwa/assets', '../public/assets', function (err) {
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

const file = '../public/views/kss-pwa/.gitignore'
fs.outputFile(file, '*')
	.then(() => fs.readFile(file, 'utf8'))
		.then(data => {
  			console.log(data) // => hello!
	})
	.catch(err => {
  		console.error(err)
	})

