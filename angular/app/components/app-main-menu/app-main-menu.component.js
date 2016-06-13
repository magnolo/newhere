class AppMainMenuController{
    constructor($mdSidenav){
        'ngInject';

        //
        this.$mdSidenav = $mdSidenav;
    }
    closeMainMenu(){
      this.$mdSidenav('main-menu').close();
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
