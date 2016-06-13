class AppHeaderController{
    constructor($mdSidenav, $state){
        'ngInject';

        //
        this.$mdSidenav = $mdSidenav;
        this.showLocator = $state.current.name.indexOf('start') > -1;
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
