class LocatorController{
    constructor(MapService, OfferService, $state){
        'ngInject';

        this.MapService = MapService;
        this.OfferService = OfferService;
        this.state = $state;

        var vm = this;
        vm.query = {
            enabled: true
        };
        this.OfferService.fetchFiltered(vm.query, (response) => {
            vm.offers = response;
        });
    }

    $onInit(){
    }

    locateMe(){
      this.MapService.getLocation();
    }

    searchPlaces(search) {
      var filteredOffers = this.offers.filter(createFilterFor(search));
      return filteredOffers;
   }

   selectedItemChange(item) {
      this.state.go('app.start.detail',{id:item.id});
   }


}

function createFilterFor(query) {
   var regex = new RegExp(query, "i");
   return function filterFn(item) {
      return (item.title.match(regex) !==null || item.street.match(regex) !==null || item.zip.match(regex) !==null);
   };
}

export const LocatorComponent = {
    templateUrl: './views/app/components/locator/locator.component.html',
    controller: LocatorController,
    controllerAs: 'vm',
    bindings: {}
}
