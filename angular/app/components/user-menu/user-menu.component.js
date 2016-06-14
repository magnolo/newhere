class UserMenuController{
    constructor($auth, $state, $translate, ToastService){
        'ngInject';

        //
        this.$auth = $auth;
        this.$state = $state;
        this.$translate = $translate;
        this.ToastService = ToastService;
    }

    logout(){
      this.$auth.logout().then((response) => {
          this.$translate('Erfolgreich abgemeldet.').then((msg) => {
              this.ToastService.show(msg);
          });
          this.$state.go('app.landing');
      });
    }
    isAuthenticated(){
      return this.$auth.isAuthenticated();
    }
}

export const UserMenuComponent = {
    templateUrl: './views/app/components/user-menu/user-menu.component.html',
    controller: UserMenuController,
    controllerAs: 'vm',
    bindings: {}
}
