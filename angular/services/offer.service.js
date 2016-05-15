export class OfferService{
    constructor(API, $q, ToastService, $state, DialogService){
        'ngInject';

        this.API = API;
        this.ToastService = ToastService;
        this.$q = $q;
        this.$state = $state;
        this.DialogService = DialogService;

    }

    cancel(cms) {
        if (cms) {
            this.DialogService.hide();
        } else {
            this.$state.go("app.landing");
        }
    }

    create(offer) {
        this.API.all('offer').post(offer).then(()=>{
            this.$state.go(this.$state.current, {}, {reload: true});
            this.ToastService.show('Saved successfully');
            this.DialogService.hide();
        });
    }

}
