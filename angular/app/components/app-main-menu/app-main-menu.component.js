class AppMainMenuController{
    constructor($mdSidenav, $window, $state){
        'ngInject';

        //
        this.$mdSidenav = $mdSidenav;
        this.$window = $window;
        this.$state = $state;
    }
    closeMainMenu(){
      this.$mdSidenav('main-menu').close();
    }
    changeLanguage(){
        this.$window.localStorage.removeItem('language');
        this.closeMainMenu();
        this.$state.go('app.landing');
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
