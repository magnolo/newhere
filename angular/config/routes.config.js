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
		.state('app.ngo', {
			url: '/ngo',
			data: {},//{auth: true} would require JWT auth for this route
			views: {
				'main@': {
					templateUrl: getView('ngo-register')
				}
			}
		})
		.state('app.forgotpassword', {
			url: '/forgotpassword',
			data: {},//{auth: true} would require JWT auth for this route
			views: {
				'main@': {
					templateUrl: getView('forgot-password')
				}
			}
		})
		.state('app.resetpassword', {
			url: '/reset-password/{token}',
			data: {},//{auth: true} would require JWT auth for this route
			views: {
				'main@': {
					templateUrl: getView('reset-password')
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
			data: {
				auth:true,
				roles:['admin', 'superadmin', 'organisation', 'moderator']
			},
			views: {
				'main@': {
					templateUrl: getCmsView('dashboard')
				}
			}
		})
		.state('cms.categories', {
			url: '/categories',
			data: {
				auth:true,
				roles:['admin', 'superadmin']
			},
			views: {
				'main@': {
					templateUrl: getCmsView('categories')
				}
			}
		})
		.state('cms.categories.details', {
			url: '/:id',
			data: {
				auth:true,
					roles:['admin', 'superadmin']
			},
			views: {
				'details': {
					templateUrl: getCmsView('category')
				}
			}
		})
		.state('cms.languages', {
			url: '/languages',
			data: {
				auth:true,
					roles:['admin', 'superadmin']
			},
			views: {
				'main@': {
					templateUrl: getCmsView('language')
				}
			}
		})
		.state('cms.roles',{
			url:'/roles',
			data:{
				auth:true,
				roles:['admin', 'superadmin']
			},
			views: {
				'main@': {
					templateUrl: getCmsView('roles')
				}
			}
		})
		.state('cms.users',{
			url:'/users',
			data:{
				auth:true,
				roles:['admin', 'superadmin']
			},
			views: {
				'main@': {
					templateUrl: getCmsView('users')
				}
			}
		})
		.state('cms.offer-translations',{
			url:'/offer-translations',
			data:{
				auth:true,
				roles:['admin', 'superadmin']
			},
			views: {
				'main@': {
					templateUrl: getCmsView('offer-translations')
				}
			}
		})
		.state('cms.ngos',{
			url:'/ngos',
			data:{
				auth:true,
				roles:['admin', 'superadmin']
			},
			views: {
				'main@': {
					templateUrl: getCmsView('ngos')
				}
			}
		})
	;
}
