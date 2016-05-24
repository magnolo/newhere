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
        }

    }
    getLocation(success, error) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
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
