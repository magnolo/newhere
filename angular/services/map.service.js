export class MapService {
    constructor($rootScope, ToastService, $translate) {
        'ngInject';
        //
        this.tokens = {
            mapbox: 'pk.eyJ1IjoibWFnbm9sbyIsImEiOiJuSFdUYkg4In0.5HOykKk0pNP1N3isfPQGTQ'
        }

        this.blueIcon = {
           iconUrl: 'img/icons/map-marker-blue.png',
           iconSize:     [28, 40],
           iconAnchor:   [14, 40],
        };

        this.whiteIcon = {
           iconUrl: 'img/icons/map-marker-white.png',
           iconSize:     [28, 40],
           iconAnchor:   [14, 40],
        }

        this.ToastService = ToastService;
        this.$translate = $translate;
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

                if (offer.latitude && offer.longitude) {
                    var marker = {
                        offer_id:offer.id,
                        lng:parseFloat(offer.latitude),
                        lat:parseFloat(offer.longitude),
                        icon: this.blueIcon
                    };
                    markers[offer.id] = marker;
                }
            });
            this.markers = markers;
        }


    }

    highlightMarker(offer) {

      angular.forEach(this.markers, (marker, key) => {
        marker.icon = this.blueIcon;
      });

      var marker = {
         offer_id:offer.id,
          lng:parseFloat(offer.latitude),
          lat:parseFloat(offer.longitude),
          icon: this.whiteIcon
      };
      this.markers[offer.id] = marker;

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
            this.$translate('Standort kann auf Grund fehlender Browserunterstützung nicht abgerufen werden.').then((msg) => {
                this.ToastService.error(msg);
            });
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
