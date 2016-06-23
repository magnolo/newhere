class LocatorController{
    constructor(MapService, OfferService, $state){
        'ngInject';

        this.MapService = MapService;
        this.OfferService = OfferService;
        this.state = $state;

        var vm = this;
        this.OfferService.fetchAll().then((response) => {
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
      if(item.title.match(regex) !==null) return true;

      if(item.street !== null && item.street.match(regex) !==null) return true;
      if(item.zip !== null && item.zip.match(regex) !==null) return true;

      return false;
   };
}

export const LocatorComponent = {
    templateUrl: './views/app/components/locator/locator.component.html',
    controller: LocatorController,
    controllerAs: 'vm',
    bindings: {}
}
