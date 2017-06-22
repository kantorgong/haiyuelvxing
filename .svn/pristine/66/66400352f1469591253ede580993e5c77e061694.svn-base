// require.ensure 是 Webpack 的特殊语法，用来设置 code-split point
const Home = resolve => {
    require.ensure(['./views/wheel.vue'], () => {
        resolve(require('./views/wheel.vue'));
    });
};

const routers = [{
    path: '/:id',
    name: 'home',
    component: Home
}, {
    path: '/wheel/:id',
    name: 'wheel',
    component: Home
}, {
    path: '/scratch/:id',
    name: 'scratch',
	component(resolve) {
		require.ensure(['./views/scratch.vue'], () => {
			resolve(require('./views/scratch.vue'));
		});
	}
}, {
    path: '/shake/:id',
    name: 'shake',
    component(resolve) {
        require.ensure(['./views/shake.vue'], () => {
            resolve(require('./views/shake.vue'));
        });
    }
}, {
    path: '*',
    component: Home
}];

export default routers;