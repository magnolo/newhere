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
        this.publishedLanguages = [];
        this.selectedLanguage = '';
        this.defaultLanguage;
        this.enabledLanguages = [];
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
    
    fetchDefault(success, error, force) {
        if (this.defaultLanguage && !force) {
            success(this.defaultLanguage);
            return;
        }

        this.API.all('languages').customGET('default').then((language) => {
            this.defaultLanguage = language;
            success(this.defaultLanguage);
        });
    }

    fetchEnabled(success, error, force) {
        if (this.enabledLanguages.length > 0 && !force) {
            success(this.enabledLanguages);
            return;
        }

        this.API.all('languages').customGETLIST('enabled').then((list) => {
            this.enabledLanguages = list;
            success(this.enabledLanguages);
        });
    }

    fetchPublished(success, error, force) {
        if (this.publishedLanguages.length > 0 && !force) {
            success(this.publishedLanguages);
            return;
        }

        this.API.all('languages').customGETLIST('published').then((list) => {
            this.publishedLanguages = list;
            success(this.publishedLanguages);
        });
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
