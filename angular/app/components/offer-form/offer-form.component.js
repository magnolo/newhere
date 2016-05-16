class OfferFormController {
    constructor($auth, $http, $q, OfferService, ToastService, $state, LanguageService) {
        'ngInject';

        this.$q = $q;
        this.aborter = $q.defer();

        this.$auth = $auth;
        this.$http = $http;
        this.OfferService = OfferService;
        this.ToastService = ToastService;
        this.$state = $state;
        this.$LanguageService = LanguageService;
        angular.element(document.querySelector('#addressSearch')).$valid = false;
    }

    querySearch(query) {
        if (this.$http.pendingRequests.length) {
            this.aborter.resolve();
            this.aborter = this.$q.defer();
        }
        return this.$http.get('/api/offer/autocomplete/' + query, {
            timeout: this.aborter.promise
        }).then(function(response) {
            return response.data; // usually response.data
        });

    }

    selectedItemChange(item) {
        if (!item) return;
        this.offer.street = item.street;
        this.offer.streetnumber = item.number;
        this.offer.city = item.city;
        this.offer.zip = item.zip;
    }

    save() {

        this.OfferService.create(this.offer);

    }

    cancel() {
        this.OfferService.cancel(this.cms);
    }

}

export const OfferFormComponent = {
    templateUrl: './views/app/components/offer-form/offer-form.component.html',
    controller: OfferFormController,
    controllerAs: 'vm',
    bindings: {
        cms: '=',
        ngo: '='
    }
}