class OfferFormController {
    constructor($http, $q, OfferService, ToastService, NgoService, CategoryService, $state, $translate, LanguageService, OfferTranslationService) {
        'ngInject';

        this.$q = $q;
        this.aborter = $q.defer();
        var vm = this;

        this.categories = [];
        this.translations = [];
        this.untranslatedOffers = [];
        this.defaultLanguage = {};
        this.$http = $http;
        this.OfferService = OfferService;
        this.ToastService = ToastService;
        this.$state = $state;
        this.$translate = $translate;
        this.LanguageService = LanguageService;
        this.LanguageService.fetchDefault((defaultLanguage) => {
            this.defaultLanguage = defaultLanguage;
         });
        this.LanguageService.fetchEnabled((enabledLanguages) => {
            this.enabledLanguages = enabledLanguages;
         });
        this.OfferTranslationService = OfferTranslationService;
        this.OfferTranslationService.fetchAll((list) => {
            this.translations = list;
         });
        this.OfferTranslationService.fetchUntranslated((untranslatedOffers) => {
            this.untranslatedOffers = untranslatedOffers;
         });
        this.NgoService = NgoService;
        if(this.cms){
          this.NgoService.fetchAll().then((list) => {
            this.ngos = list;
          });
        }
        this.CategoryService = CategoryService;
        this.CategoryService.all((list) => {
          this.categories = list;
        })
        this.categoriesOptions = {
          selectionChanged: (items) => {
            this.offer.categories = items;
          }
        }
        if($state.params.id){
          this.OfferService.one($state.params.id, (offer) =>{
            this.offer = offer;
            if(this.offer.valid_from != null) {
               this.valid_from = new Date(this.offer.valid_from);
            }
            if(this.offer.valid_until != null) {
               this.valid_until = new Date(this.offer.valid_until);
            }
         })
        }
        else{
          this.offer = {
            categories:[],
              filters: [],
              translations: []
          };
          this.valid_from = new Date();
          this.NgoService.one().then((ngo) => {
                this.adoptFieldsFromNgo(ngo);
            });
        }

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
      if(!this.offer.street || !this.offer.streetnumber || !this.offer.zip ){
          this.$translate('Es ist keine Adresse vorhanden!').then((msg) => {
              this.ToastService.error(msg);
          });
          return false;
      }

      this.offer.valid_until = this.valid_until;
      this.offer.valid_from = this.valid_from;
        if (new Date() > this.offer.valid_until) {
            this.$translate('Enddatum liegt in der Vergangenheit!').then((msg) => {
                this.ToastService.error(msg);
            });
            return false;
        }

      this.OfferService.save(this.offer);

    }

    cancel() {
        this.OfferService.cancel(this.cms);
    }

    adoptFieldsFromNgo(ngo) {
        if (ngo) {
            this.offer.email = ngo.contact_email;
            this.offer.phone = ngo.contact_phone;
            this.offer.website = ngo.website;
            this.offer.street = ngo.street;
            this.offer.streetnumber = ngo.street_number;
            this.offer.zip = ngo.zip;
            this.offer.city = ngo.city;
        }
    }
    getTranslation(untranslatedOffer, targetLanguage) {
        var dummy = {title: '', description: '', opening_hours: '', version: 0};

        if (angular.isUndefined(untranslatedOffer) || angular.isUndefined(targetLanguage)) {
            return;
        }

        var translation = null;
        angular.forEach(untranslatedOffer.translations, function(t, ignore) {
            if (t.locale == targetLanguage.language && t.locale !='de') {
                translation = t;
            }
        });

        return translation;
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
