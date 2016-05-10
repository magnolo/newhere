class RegisterFormController {
	constructor($auth, ToastService, $state) {
		'ngInject';

		this.$auth = $auth;
		this.ToastService = ToastService;
		this.$state = $state;

		this.ngo = {};
	}

	register() {
		this.$auth.signup(this.ngo)
			.then((response) => {
				//remove this if you require email verification
				this.$auth.setToken(response.data);

				this.ToastService.show('Successfully registered.');
				this.$state.go('app.login');
			})
			.catch(this.failedRegistration.bind(this));
	}



	failedRegistration(response) {
		if (response.status === 422) {
			for (var error in response.data.errors) {
				return this.ToastService.error(response.data.errors[error][0]);
			}
		}
		this.ToastService.error(response.statusText);
	}
}

export const RegisterFormComponent = {
	templateUrl: './views/app/components/register-form/register-form.component.html',
	controller: RegisterFormController,
	controllerAs: 'vm',
	bindings: {}
}
