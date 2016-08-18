class LocatorController {
    constructor(MapService, OfferService, $state) {
        'ngInject';

        this.MapService = MapService;
        this.OfferService = OfferService;
        this.state = $state;

        var vm = this;
        vm.query = {
            enabled: true
        };

    }

    $onInit() {}

    locateMe() {
        this.MapService.locate();
    }

    searchPlaces(search) {
      if(!search) return [];
      return this.OfferService.fetchSearch(search, (response) => {
          return response;
      });
    }

    selectedItemChange(item) {
        this.state.go('app.start.detail', {
            id: item.id
        });
    }
}

export const LocatorComponent = {
    templateUrl: './views/app/components/locator/locator.component.html',
    controller: LocatorController,
    controllerAs: 'vm',
    bindings: {}
}
