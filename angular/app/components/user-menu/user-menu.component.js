class UserMenuController{
    constructor($auth,$state){
        'ngInject';

        //
        this.$auth = $auth;
        this.$state = $state;
    }

    logout(){
      this.$auth.logout().then((response) => {
        this.ToastService.show('Logged out successfully.');
        this.$state.go('app.landing');
      })
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
