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
            success(this.filters);
        } else if (angular.isDefined(this._promise)) {
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
    fetchFiltered(query,success, error, force){
        var q = this.API.all('filters').getList(query);
        q.then((response) =>{
            success(response);
        });
        return q;
    }
    toggleEnabled(filter) {
        this.API.one('filters', filter.id).customPUT({
            enabled: filter.enabled ? 1 : 0
        },'toggleEnabled').then(
            (success) => {
                this.ToastService.show('Filter updated.');
            },
            (error) => {
                console.log(error);
                this.ToastService.error('Filter update failed. Please try again');
                filter.enabled = !filter.enabled;
            }
        );
    }

    fetchAll(query,success, error, force){
        var q = this.API.all('filters').customGET('all').then(query);
        q.then((response) =>{
            console.log('got the filters');
            success(response);
        });
        return q;
    }

    bulkAssign(list, field, value, success, error){
        var ids = [];
        angular.forEach(list, (item) => {
            ids.push(item.id);
        });
        this.API.several('filters', ids).patch({
            field: field,
            value: value
        }).then((response) => {
            this.ToastService.show('Filters successfully updated!');
            success(response.data.filters);
        });
    }

    bulkRemove(list, success, error){
        var ids = [];
        angular.forEach(list, (item) => {
            ids.push(item.id);
        });
        this.API.several('filters', ids).remove().then((response) => {
            this.ToastService.show(response.data.deletedRows+' item(s) successfully deleted!');
            success(response.data.filters);
        });
    }
}
