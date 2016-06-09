export class MapService {
    constructor($rootScope, ToastService) {
        'ngInject';
        //
        this.tokens = {
            mapbox: 'pk.eyJ1IjoibWFnbm9sbyIsImEiOiJuSFdUYkg4In0.5HOykKk0pNP1N3isfPQGTQ'
        }

        this.$rootScope = $rootScope;
        this.center = {
            lat: 48.209272,
            lng: 16.372801,
            zoom: 12
        };
        this.controls = {
            fullscreen: {
                position: 'topleft'
            }
        }
        this.layers = {
            baselayers: {
                xyz: {
                    name: 'Outdoor',
                    url: 'https://{s}.tiles.mapbox.com/v4/valderrama.d86114b6/{z}/{x}/{y}.png?access_token=' + this.tokens.mapbox,
                    type: 'xyz',
                    layerOptions: {
                        noWrap: true,
                        continuousWorld: false,
                        detectRetina: true,
                        showOnSelector: false
                    }
                }
            }
        };
        this.events = { // or just {} //all events
                    markers:{
                      enable: [ 'clicked' ],
                      logic: 'emit'
                    }
                };

               /* $scope.$on("leafletDirectiveMarker.click", function(event, args){
                                     console.log('event click aojsdnajs');
                                 });*/


        this.markers = {};
        this.setMarkers = (offers) => {
            var markers = {}

            angular.forEach(offers, (offer, key) => {
              var marker = {
                 offer_id:offer.id,
                  lng:parseFloat(offer.latitude),
                  lat:parseFloat(offer.longitude),
                  message:offer.title
              };
              markers[offer.id+'_'+key] = marker;
            });
            console.log(markers);
            this.markers = markers;
        }


    }

    zoomTo(offer) {
      this.center = {
          lat: parseFloat(offer.longitude),
          lng: parseFloat(offer.latitude),
          zoom: 14
      };
    }

    $onInit(){
      this.markers = {};
    }



    getLocation(success, error) {

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {

               console.log(position.coords.latitude+' '+position.coords.longitude);
                this.center.lat = position.coords.latitude;
                this.center.lng = position.coords.longitude;
                this.center.zoom = 12;
                this.$rootScope.$apply();
                if (typeof success == "function") {
                    success(position);
                }

            });
        } else {
            ToastService.error('Geolocation is not supported by this browser.');
            if (typeof error == "function") {
                error();
            }
        }
    }
    getLocationByAddress(address) {

    }
    setLocation() {

    }

}
