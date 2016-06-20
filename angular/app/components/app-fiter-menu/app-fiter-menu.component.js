class AppFiterMenuController{
    constructor($mdSidenav, $rootScope){
        'ngInject';

        //
        this.$rootScope = $rootScope;
        this.$mdSidenav = $mdSidenav;
    }

    $onInit(){
    }
    closeWithReset(){
      this.$rootScope.filters = [];
      this.close();
    }
    close(){

      this.$mdSidenav('filter').close();
    }
}

export const AppFiterMenuComponent = {
    templateUrl: './views/app/components/app-fiter-menu/app-fiter-menu.component.html',
    controller: AppFiterMenuController,
    controllerAs: 'vm',
    bindings: {}
}
