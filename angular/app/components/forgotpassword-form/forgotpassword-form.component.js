class ForgotpasswordFormController {
    constructor(UserService, $state, ToastService, $translate) {
        'ngInject';

        //
        this.email;
        this.$state = $state;
        this.$translate = $translate;
        this.UserService = UserService;
        this.ToastService = ToastService;
        this.sending = false;
    }
    resetPassword() {
        this.sending = true;
        this.UserService.forgotpassword(this.email, (response) => {
            this.sending = false;
            this.$state.go('app.login');
            this.$translate('Email wurde versendet').then((msg) => {
                this.ToastService.show(msg);
            });
        });
    }

    $onInit() {}
}

export const ForgotpasswordFormComponent = {
    templateUrl: './views/app/components/forgotpassword-form/forgotpassword-form.component.html',
    controller: ForgotpasswordFormController,
    controllerAs: 'vm',
    bindings: {}
};