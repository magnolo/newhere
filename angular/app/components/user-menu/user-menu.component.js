class UserMenuController {
    constructor($auth, $state, $translate, ToastService, $window) {
        'ngInject';

        //
        this.$auth = $auth;
        this.$state = $state;
        this.$translate = $translate;
        this.ToastService = ToastService;
        this.$window = $window;
    }

    logout() {
        this.$auth.logout().then((response) => {
            this.$translate('Erfolgreich abgemeldet.').then((msg) => {
                this.ToastService.show(msg);
            });
            this.$state.go('app.landing');
        });
    }
    isAuthenticated() {
        return this.$auth.isAuthenticated();
    }
    $onInit() {
        this.roles = JSON.parse(this.$window.localStorage.roles);
    }
    isAllowed(types) {
        let allowed = false;
        angular.forEach(types, (role) => {
            angular.forEach(this.roles, (userRole) => {
                if (role == userRole) {
                    allowed = true;
                }
            });
        });
        console.log(types, this.roles);
        return allowed;
    }
}

export const UserMenuComponent = {
    templateUrl: './views/app/components/user-menu/user-menu.component.html',
    controller: UserMenuController,
    controllerAs: 'vm',
    bindings: {}
}