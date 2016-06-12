class RegisterFormController {
	constructor($auth, $translate, ToastService) {
		'ngInject';

		this.$auth = $auth;
		this.$translate = $translate;
		this.ToastService = ToastService;

		this.name = '';
		this.email = '';
		this.password = '';
	}

	register() {
		var user = {
			name: this.name,
			email: this.email,
			password: this.password
		};

		this.$auth.signup(user)
			.then((response) => {
				//remove this if you require email verification
				this.$auth.setToken(response.data);
		
				this.$translate('Registrierung erfolgreich.').then((msg) => {
					this.ToastService.show(msg);
				});			
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
