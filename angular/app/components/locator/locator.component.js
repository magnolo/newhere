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
   var regex = new RegExp(query, "i")
   return function filterFn(item) {
      var xy = (item.title.match(regex) !==null || item.street.match(regex) !==null || item.zip.match(regex) !==null);
      console.log(xy+': '+item.title+' '+item.title.match(regex)+' '+item.street+' '+item.street.match(regex));
     return xy;
   };
}

export const LocatorComponent = {
    templateUrl: './views/app/components/locator/locator.component.html',
    controller: LocatorController,
    controllerAs: 'vm',
    bindings: {}
}
