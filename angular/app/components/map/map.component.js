class MapController {
    constructor(MapService, OfferService, leafletData, leafletMarkerEvents, $scope, $rootScope, $state) {
        'ngInject';
        var vm = this;
        this.MapService = MapService;
        //this.OfferService = OfferService;
        this.$state = $state;
        //this.MapService.locate();
        // var markerEvents = leafletMarkerEvents.getAvailableEvents();
        //
        // for (var k in markerEvents) {
        //     var eventName = 'leafletDirectiveMarker.nhMap.' + markerEvents[k];
        //     $rootScope.$on(eventName, function(event, args) {
        //         console.log(event.name);
        //     });
        // }
        $scope.$on("leafletDirectiveMarker.nhMap.click", function(event, args) {
            vm.$state.go('app.start.detail', {
                id: args.model.offer_id
            });
        });

        this.orgLatLng = {};

        $scope.$on('leafletDirectiveMarker.nhMap.dragstart', function(e, args) {
            vm.orgLatLng = args.leafletObject._latlng;
        });
        $scope.$on('leafletDirectiveMarker.nhMap.dragend', function(e, args) {
            args.leafletObject.setLatLng(vm.orgLatLng);
            vm.$state.go('app.start.detail', {
                id: args.model.offer_id
            });
        });

        //
        // $scope.$on("leafletDirectiveMarker.nhMap.touchend", function(event, args) {
        //     console.log('touched');
        //     vm.$state.go('app.start.detail', {
        //         id: args.model.offer_id
        //     });
        // });


    }

}

export const MapComponent = {
    templateUrl: './views/app/components/map/map.component.html',
    controller: MapController,
    controllerAs: 'vm',
    bindings: {}
}