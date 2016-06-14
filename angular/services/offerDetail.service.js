export class OfferDetailService {

    constructor(API, $q, ToastService, $state, $translate, DialogService) {
        'ngInject';

        this.API = API;
        this.ToastService = ToastService;
        this.$q = $q;
        this.$state = $state;
        this.DialogService = DialogService;
        this.$translate = $translate;
    }

    fetchAll() {
        var vm = this;
        return this.$q(function (resolve) {
            vm.API.all('offerDetail').getList().then(function (response) {
                resolve(response)
            }, function (error) {
                console.log(error);
                vm.$translate('Fehler beim Laden der Daten.').then((msg) => {
                    vm.ToastService.error(msg);
                });
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
                vm.$translate('Fehler beim Laden der Daten.').then((msg) => {
                    this.ToastService.error(msg);
                });
            });
        });
    }
}
