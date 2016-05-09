export function RoutesConfig($stateProvider, $urlRouterProvider) {
	'ngInject';

	var getView = (viewName) => {
		return `./views/app/pages/${viewName}/${viewName}.page.html`;
	};

	var getCmsView = (viewName) => {
		return `./views/app/pages/cms/${viewName}/${viewName}.page.html`;
	};

	$urlRouterProvider.otherwise('/');

	$stateProvider
		.state('app', {
			abstract: true,
			views: {
				header: {
					templateUrl: getView('header')
				},
				footer: {
					templateUrl: getView('footer')
				},
				main: {}
			}
		})
		.state('app.landing', {
            url: '/',
            data: {},
            views: {
                'main@': {
                    templateUrl: getView('landing')
                }
            }
        })
        .state('app.login', {
			url: '/login',
			data: {},//{auth: true} would require JWT auth for this route
			views: {
				'main@': {
					templateUrl: getView('login')
				}
			}
		})
        .state('app.register', {
            url: '/register',
            data: {},//{auth: true} would require JWT auth for this route
            views: {
                'main@': {
                    templateUrl: getView('register')
                }
            }
        })

		//
		// CMS
		//
		.state('cms', {
			abstract: true,
			url:'/cms',
			views: {
				header: {
					templateUrl: getCmsView('header')
				},
				footer: {
					templateUrl: getCmsView('footer')
				},
				main: {}
			}
		})
		.state('cms.dashboard', {
			url: '/dashboard',
			data: {},
			views: {
				'main@': {
					templateUrl: getCmsView('dashboard')
				}
			}
		})
		.state('cms.categories', {
			url: '/categories',
			data: {},
			views: {
				'main@': {
					templateUrl: getCmsView('categories')
				}
			}
		})
		.state('cms.categories.details', {
			url: '/:id',
			data: {},
			views: {
				'details': {
					templateUrl: getCmsView('category')
				}
			}
		})
		.state('cms.languages', {
			url: '/languages',
			data: {},
			views: {
				'main@': {
					templateUrl: getCmsView('language')
				}
			}
		})
	;
}
