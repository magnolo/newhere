class NgoFormController{
    constructor($auth, NgoService, ToastService, $state, LanguageService) {
        'ngInject';

        this.$auth = $auth;
        this.NgoService = NgoService;
        this.ToastService = ToastService;
        this.$state = $state;
        this.$LanguageService = LanguageService;

        this.ngo = {};
    }

    register() {
        this.ngo.language = this.$LanguageService.activeLanguage();
        if (!this.cms) {
            this.$auth.signup(this.ngo)
                .then((response) => {
                    //remove this if you require email verification
                    this.$auth.setToken(response.data);

                    this.ToastService.show('Successfully registered.');
                    this.$state.go('app.login');
                })
                .catch(this.failedRegistration.bind(this));
        } else {
            this.NgoService.create(this.ngo);
        }

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

export const NgoFormComponent = {
    templateUrl: './views/app/components/ngo-form/ngo-form.component.html',
    controller: NgoFormController,
    controllerAs: 'vm',
    bindings: {
        cms: '='
    }
}
