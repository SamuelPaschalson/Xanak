// const { notify } = require("browser-sync");

module.exports = {
	proxy: "localhost:8000",
	files: [
		"public/**/*.php",
		"templates/**/*.php",
		"pages/**/*.php",
		"pages/*.php",
		"public/**/*.js",
		"public/**/*.css",
	],
	port: 3000,
	open: false,
	notify: false,
};
