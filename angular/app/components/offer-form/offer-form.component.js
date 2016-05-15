

class OfferFormController{
    constructor($auth, $http, OfferService, ToastService, $state, LanguageService) {
        'ngInject';

        this.$auth = $auth;
        this.$http = $http;
        this.OfferService = OfferService;
        this.ToastService = ToastService;
        this.$state = $state;
        this.$LanguageService = LanguageService;
    }

    querySearch (query) {
      console.log("querySearch "+query);
      return $http.get('http://newhere.local.routes-vienna.work/api/offer/autocomplete/hi').then(function(response){
        return response.data; // usually response.data
  })
    }

    save() {

      
        this.offer.language = this.$LanguageService.activeLanguage();


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
