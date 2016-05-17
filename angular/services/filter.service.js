export class FilterService {
    constructor(API, LanguageService, ToastService) {
        'ngInject';

        //
        this._promise;
        this._callbacks = new Array();
        this.API = API;
        this.fitlers;
        this.fitler = {};

        this.API = API;
        this.ToastService = ToastService;
        this.LanguageService = LanguageService;

    }
    all(success, error, force) {
        if (angular.isDefined(this.filters) && !force) {
            success(this.categories);
        } else if (angular.isDefined(this._promise)) {
            this._callbacks.push(success);
        } else {
            this._callbacks.push(success);
            this._promise = this.API.all('filters').getList().then((response) => {
                this.fitlers = response;
                angular.forEach(this._callbacks, (callback) => {
                    callback(this.filters);
                })
                this._promise = null;
            }, error);
        }
    }
}