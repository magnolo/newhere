class AppHeaderController{
    constructor($mdSidenav, $state, $scope){
        'ngInject';
        this.$mdSidenav = $mdSidenav;
        $scope.currState = $state;
        var vm = this;
        $scope.$watch('currState.current.name', function(stateName, oldStateName) {
            vm.showNgoLink = stateName.indexOf('app.landing') > -1;
            vm.showLocator = stateName.indexOf('start') > -1;
        });

    }

    $onInit(){
    }
    openMainMenu(){
      this.$mdSidenav('main-menu').open();
      this.$mdSidenav('filter').close();

    }
}

export const AppHeaderComponent = {
    templateUrl: './views/app/components/app-header/app-header.component.html',
    controller: AppHeaderController,
    controllerAs: 'vm',
    bindings: {}
}
