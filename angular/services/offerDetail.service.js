export class OfferDetailService {

    constructor(API, $q, ToastService, $state, DialogService) {
        'ngInject';

        this.API = API;
        this.ToastService = ToastService;
        this.$q = $q;
        this.$state = $state;
        this.DialogService = DialogService;

    }

    fetchAll() {
        var vm = this;
        return this.$q(function (resolve) {
            vm.API.all('offerDetail').getList().then(function (response) {
                resolve(response)
            }, function (error) {
                console.log(error);
                vm.ToastService.show("Fetching Offers failed");
            });
        });
    }

    one() {
        var vm = this;
        return this.$q(function (resolve) {
            vm.API.all('offer').getList().then(function (response) {
                resolve(response)
            }, function (error) {
                console.log(error);
                vm.ToastService.show("Fetching Offers failed");
            });
        });
    }
}

