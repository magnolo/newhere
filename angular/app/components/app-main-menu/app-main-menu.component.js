class AppMainMenuController{
    constructor($mdSidenav, $translate, $window, $state, $auth, ToastService){
        'ngInject';

        //
        this.$mdSidenav = $mdSidenav;
        this.$window = $window;
        this.$state = $state;
        this.$auth = $auth;
        this.ToastService = ToastService;
        this.$translate = $translate;
    }
    closeMainMenu(){
      this.$mdSidenav('main-menu').close();
    }
    changeLanguage(){
        this.$window.localStorage.removeItem('language');
        this.closeMainMenu();
        this.$state.go('app.landing');
    }
    logout(){
      this.$auth.logout().then((response) => {
          this.$translate('Erfolgreich abgemeldet.').then((msg) => {
              this.ToastService.show(msg);
          });
          this.$state.go('app.landing');
      });
    }
    $onInit(){
    }
}

export const AppMainMenuComponent = {
    templateUrl: './views/app/components/app-main-menu/app-main-menu.component.html',
    controller: AppMainMenuController,
    controllerAs: 'vm',
    bindings: {}
}
