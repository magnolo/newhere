class LoginFormController {
	constructor($auth, $state, $window, $translate, ToastService) {
		'ngInject';

		this.$window = $window;
		this.$auth = $auth;
		this.$state = $state;
		this.$translate = $translate;
		this.ToastService = ToastService;

		this.email = '';
		this.password = '';
	}

	login() {
		var user = {
			email: this.email,
			password: this.password
		};

		this.$auth.login(user)
			.then((response) => {
				var roles = [];
				this.$auth.setToken(response.data);
				angular.forEach(response.data.data.user.roles, function(role){
					roles.push(role.name);
				});
				this.$window.localStorage.roles = JSON.stringify(roles);
				this.$translate('Sie haben sich erfolgreich angemeldet.').then((msg) => {
					this.ToastService.show(msg);
				});
				
				if (this.isNgoUser(roles)) {
					this.$state.go('app.myngo');
				} else {
					this.$state.go('cms.dashboard');
				}
			})
			.catch(this.failedLogin.bind(this));
	}

	/**
	 * Check whether user holds organisation role (but no superadmin/admin roles)
	 * @param roles
	 * @returns {boolean}
     */
	isNgoUser(roles) {
		return (roles.indexOf("organisation-admin") > -1  || roles.indexOf("organisation-user") > -1 && roles.indexOf("superadmin") == -1 && roles.indexOf("admin") == -1);
	}


	failedLogin(response) {
		if (response.status === 422) {
			for (var error in response.data.errors) {
				return this.ToastService.error(response.data.errors[error][0]);
			}
		}
		else if(response.data.errors){
			for (var error in response.data.errors) {
				return this.ToastService.error(response.data.errors[error][0]);
			}
		}
		this.ToastService.error(response.statusText);
	}
}

export const LoginFormComponent = {
	templateUrl: './views/app/components/login-form/login-form.component.html',
	controller: LoginFormController,
	controllerAs: 'vm',
	bindings: {}
}
