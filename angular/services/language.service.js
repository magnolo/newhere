export class LanguageService {
    constructor(API, ToastService, $window, $filter) {
        'ngInject';

        this.$filter = $filter;
        this.$window = $window;
        this._promise;
        this._callbacks = new Array();
        this.API = API;
        this.ToastService = ToastService;
        this.languages = [];
        this.activeLanguages = [];
        this.selectedLanguage = '';
    }

    fetchAll(success, error, force) {

        if (this.languages.length && !force) {
            success(this.languages);
        } else if (angular.isDefined(this._promise)) {
            this._callbacks.push(success)
        } else {
            this._callbacks.push(success);

            this._promise = this.API.all('languages').getList().then((list) => {
                this.languages = list;
                angular.forEach(this._callbacks, (callback) => {
                    callback(this.languages);
                })
                this._promise = null;
            })
        }
    }
    fetchPublished(doneFn) {
        return this.API.all('languages/published').getList().then((list) => {
            if (typeof doneFn == "function") {
                doneFn();
            }
            return angular.copy(list, this.languages);
        })
    }
    getActive(success) {
        this.fetchAll((languages) => {
            this.activeLanguages = this.$filter('filter')(languages, {
                'enabled': true
            }, true);
            success(this.activeLanguages);
        });
    }
    changeLanguage(language, doneFn) {
        this.selectedLanguage = this.$window.localStorage.language = language;
        if (typeof doneFn == "function") {
            doneFn();
        }
        return this.selectedLanguage;
    }
    activeLanguage() {
        if (this.selectedLanguage == '') {
            this.selectedLanguage = this.$window.localStorage.language || 'de';
        }
        return this.selectedLanguage;
    }
    update(language) {
        return language.save().then((response) => {
            this.ToastService.show('Language updated.');
        })
    }
}
