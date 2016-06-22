export class FilterService {
    constructor(API, ToastService, LanguageService, Restangular, $state, $translate) {
        'ngInject';

        this._promise;
        this._callbacks = new Array();
        this._promiseFlat;
        this._callbacksFlat = new Array();

        this.flattenedFilters;
        this.API = API;
        this.filters;
        this.filter = {};

        this.API = API;
        this.ToastService = ToastService;
        this.LanguageService = LanguageService;
        this.Restangular = Restangular;
        this.$state = $state;
        this.$translate = $translate;
    }
    all(success, error, force) {
        if (angular.isDefined(this.filters) && !force) {
            success(this.filters);
        } else if (angular.isDefined(this._promise) && !force) {
            this._callbacks.push(success);
        } else {
            this._callbacks.push(success);
            this._promise = this.API.all('filters').getList().then((response) => {
                this.filters = response;
                angular.forEach(this._callbacks, (callback) => {
                    callback(this.filters);
                })
                this._promise = null;
            }, error);
        }
    }
    flattened(success, error, force) {
        if (angular.isDefined(this.flattenedFilters) && !force) {
            success(this.flattenedFilters);
        } else if (angular.isDefined(this._promiseFlat)) {
            this._callbacksFlat.push(success);
        } else {
            this._callbacksFlat.push(success);
            this._promiseFlat = this.API.all('filters?all=true').getList().then((response) => {
                this.flattenedFilters = response;
                angular.forEach(this._callbacksFlat, (callback) => {
                    callback(this.flattenedFilters);
                })
                this._promiseFlat = null;
            }, error);
        }
    }
    one(id, success, error) {

        if (!id) return false;
        if (this.filter.id == id) {
            success(this.filter);
        } else {
            this.API.one('filters', id).get().then((item) => {
                this.filter = item;
                success(this.filter);
            }, error);
        }
    }

    save(filter) {
        if (filter.id && filter.id != 'new') {
            return this.filter.save().then((response) => {
                this.$translate('Erfolgreich gespeichert.').then((msg) => {
                    this.ToastService.show(msg);
                });
                angular.forEach(this.filters, (item) => {
                    if (item.id == filter.id) {
                        angular.copy(filter, item);
                    }
                })
            });
        } else {
            var data = {
                title: filter.title,
                description: filter.description,
                language: this.LanguageService.activeLanguage(),
                icon: filter.icon,
                parent_id: filter.parent_id
            };
            this.API.all('filters').post(data).then((response) => {
                this.$translate('Erfolgreich gespeichert.').then((msg) => {
                    this.ToastService.show(msg);
                });
                this.$state.go('cms.filters.details', {
                    id: response.id
                });
                this.filters.push(filter);
                return this.filter = filter;
            });
        }

    }

    cancel() {
        this.$state.go("cms.filters");
    }
    selectFilter(filter) {
        return this.selectedFilter = filter;
    }

    toggleEnabled(filter) {
        this.API.one('filters', filter.id).customPUT({
            enabled: filter.enabled ? 1 : 0
        },'toggleEnabled').then(
            (success) => {
                this.$translate('Filter aktualisiert.').then((msg) => {
                    this.ToastService.show(msg);
                });
            },
            (error) => {
                console.log(error);
                this.$translate('Filter konnte nicht aktualisiert werden.').then((msg) => {
                    this.ToastService.error(msg);
                });
                filter.enabled = !filter.enabled;
            }
        );
    }
}
