class MapController{
    constructor(MapService, OfferService){
        'ngInject';

        this.MapService = MapService;
        this.OfferService = OfferService;
    }

    $onInit(){
    }

}

export const MapComponent = {
    templateUrl: './views/app/components/map/map.component.html',
    controller: MapController,
    controllerAs: 'vm',
    bindings: {}
}
