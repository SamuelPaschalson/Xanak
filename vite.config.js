export default {
	root: "public",
	build: {
		outDir: "../dist",
	},
	server: {
		watch: {
			ignored: ["!**/node_modules/**", "!**/vendor/**"],
		},
		hmr: {
			protocol: "ws",
			host: "localhost",
		},
	},
};
