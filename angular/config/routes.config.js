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
				top:{
					templateUrl: getView('main')
				},
				'header@app': {
					templateUrl: getView('header')
				},
				'footer@app': {
					templateUrl: getView('footer')
				},
				'main@app': {}
			}
		})
		.state('app.landing', {
            url: '/',
            data: {},
            views: {
                'main@app': {
                    templateUrl: getView('landing')
                }
            }
        })
        .state('app.login', {
			url: '/login',
			data: {},//{auth: true} would require JWT auth for this route
			views: {
				'main@app': {
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
		.state('app.ngoRegister', {
			url: '/ngoRegister',
			data: {},//{auth: true} would require JWT auth for this route
			views: {
				'main@app': {
					templateUrl: getView('ngo-register')
				}
			}
		})
		.state('app.forgotpassword', {
			url: '/forgotpassword',
			data: {},//{auth: true} would require JWT auth for this route
			views: {
				'main@app': {
					templateUrl: getView('forgot-password')
				}
			}
		})
		.state('app.resetpassword', {
			url: '/reset-password/{token}',
			data: {},//{auth: true} would require JWT auth for this route
			views: {
				'main@app': {
					templateUrl: getView('reset-password')
				}
			}
		})
		.state('app.ngo', {
			url: '/ngo',
			data: {
				auth:true,
				roles:['organisation']
			},
			views: {
				'main@app': {
					templateUrl: getView('ngo')
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
				top:{
					templateUrl: getCmsView('main')
				},
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
				'main@cms': {
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
				'main@cms': {
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
				'main@cms': {
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
				'main@cms': {
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
				'main@cms': {
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
				'main@cms': {
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
				'main@cms': {
					templateUrl: getCmsView('ngos')
				}
			}
		})
	;
}
