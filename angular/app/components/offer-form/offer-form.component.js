

class OfferFormController{
    constructor($auth, $http, OfferService, ToastService, $state, LanguageService) {
        'ngInject';

        this.$auth = $auth;
        this.$http = $http;
        this.OfferService = OfferService;
        this.ToastService = ToastService;
        this.$state = $state;
        this.$LanguageService = LanguageService;
        angular.element( document.querySelector( '#addressSearch' ) ).$valid = false;
    }

    querySearch (query) {
      return this.$http.get('http://newhere.local.routes-vienna.work/api/offer/autocomplete/'+query).then(function(response){
        return response.data; // usually response.data
  })
    }

    selectedItemChange(item) {
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
