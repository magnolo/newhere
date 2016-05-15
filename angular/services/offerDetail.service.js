export class OfferDetailService {
    constructor(API, ToastService) {
        'ngInject';

        this.API = API;
        this.ToastService = ToastService;
        this.offerBase;
        this.offersExtended;

        this.defaultLanguage = {};
    }

    fetchDefaultLanguage(success, error) {
        this.API.all('languages').customGET('default').then((language) = > {
            this.defaultLanguage = language;
        success(this.defaultLanguage);
    })
        ;
    }

}

