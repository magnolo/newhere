class AppHeaderController{
    constructor($mdSidenav){
        'ngInject';

        //
        this.$mdSidenav = $mdSidenav;
    }

    $onInit(){
    }
    openMainMenu(){
      this.$mdSidenav('filter').close();
      this.$mdSidenav('main-menu').toggle();
    }
}

export const AppHeaderComponent = {
    templateUrl: './views/app/components/app-header/app-header.component.html',
    controller: AppHeaderController,
    controllerAs: 'vm',
    bindings: {}
}
