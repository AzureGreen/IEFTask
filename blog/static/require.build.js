({
	appDir: './js',		// 要打包的根目录
	baseUrl: './',    // js文件存放目录
	dir: './js/build',		// 打包后的输出目录
	mainConfigFile: './js/require.config.js', // requirejs的配置文件
	modules: [{
		name: 'home',
		excludeShallow: ['articleDetail', 'photoInfo']
	}, {
		name: 'article',
		excludeShallow: ['articleBlock', 'photoInfo']
	}, {
		name: 'photo',
		excludeShallow: ['articleBlock', 'articleDetail']
	},{
		name: 'about',
		excludeShallow: ['articleBlock', 'photoInfo']
	}]
})



