class WizardOfferController{
    constructor($http, $q, OfferService, CategoryService, LanguageService, NgoService){
        'ngInject';
        this.$http = $http;
        this.$q = $q;
        this.aborter = $q.defer();
        this.selectedLanguages = {};
        this.OfferService = OfferService;
        this.NgoService = NgoService;
        this.valid_from = new Date();
          this.NgoService.one().then((ngo) => {
              this.adoptFieldsFromNgo(ngo);
          });
        this.LanguageService = LanguageService;
        this.LanguageService.fetchEnabled((list) => {
          this.languages = list;
          angular.forEach(this.languages, (lang) =>{
            if(lang.default_language){
              this.offer.languages.push(lang);
              this.selectedLanguages[lang.language] = true;
            }
          })
        })
        this.CategoryService = CategoryService;
        this.CategoryService.all((list) => {
          this.categories = list;
        })
        //
        this.offer = {
          categories:[],
          filters:[],
          translations:{},
          languages:[],
          toAll: true
        }
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

    clearFilters(){
      if(this.offer.toAll){
        this.offer.filters = [];
      }
    }
    setLanguages(){
      this.offer.languages = [];
      angular.forEach(this.selectedLanguages, (lang, key) =>{
        if(lang){
          angular.forEach(this.languages, (l, k) =>{
            if(key == l.language){
              this.offer.languages.push(l);
            }
          });
        }
      });
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
    setMode(mode){
      console.log(mode);
    }
    finishedWizard(){
      console.log(this.offer);
        if (this.offer.withoutAddress) {
            this.offer.street = null;
            this.offer.streetnumber = null;
            this.offer.zip = null;
            this.offer.city = null;
        }

      this.offer.valid_until = this.valid_until;
      this.offer.valid_from = this.valid_from;
        if (new Date() > this.offer.valid_until) {
            this.ToastService.error('Endadresse ist in der Vergangenheit!');
            return false;
        }
      this.offer.title = this.offer.translations['de'].title;
      this.offer.description = this.offer.translations['de'].description;
      this.OfferService.save(this.offer, ()=>{}, ()=>{}, 'app.offers');

    }
    $onInit(){
    }
}

export const WizardOfferComponent = {
    templateUrl: './views/app/components/wizard-offer/wizard-offer.component.html',
    controller: WizardOfferController,
    controllerAs: 'vm',
    bindings: {}
}
