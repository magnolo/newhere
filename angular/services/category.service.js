// just a temporary try...
export class CategoryService {
    constructor(API, ToastService, LanguageService, Restangular, $state, $translate) {
        'ngInject';

        this._promise;
        this._callbacks = new Array();
        this._promiseFlat;
        this._callbacksFlat = new Array();

        this.categories;
        this.flattenedCategories;
        this.category = {};

        this.API = API;
        this.ToastService = ToastService;
        this.LanguageService = LanguageService;
        this.Restangular = Restangular;
        this.$state = $state;
        this.$translate = $translate;
    }

    all(success, error, force) {
        if (angular.isDefined(this.categories) && !force) {
            success(this.categories);
        } else if (angular.isDefined(this._promise) && !force) {
            this._callbacks.push(success);
        } else {
            this._callbacks.push(success);
            this._promise = this.API.all('categories').getList().then((response) => {
                this.categories = response;
                angular.forEach(this._callbacks, (callback) => {
                    callback(this.categories);
                });
                this._promise = null;
            }, error);
        }
    }
    bySlug(slug, success, error) {

        this.API.one('categories', slug).get().then((response) => {
            this.category = response;
            success(response);
        }, error);

    }
    getOffers(success){

      if(this.category){
        this.API.one('categories', this.category.slug).getList('offers').then((offers) => {
          success(offers);
        })
      }
    }
    flattened(success, error, force) {
        if (angular.isDefined(this.flattenedCategories) && !force) {
            success(this.flattenedCategories);
        } else if (angular.isDefined(this._promiseFlat)) {
            this._callbacksFlat.push(success);
        } else {
            this._callbacksFlat.push(success);
            this._promiseFlat = this.API.all('categories?all=true').getList().then((response) => {
                this.flattenedCategories = response;
                angular.forEach(this._callbacksFlat, (callback) => {
                    callback(this.flattenedCategories);
                });
                this._promiseFlat = null;
            }, error);
        }
    }

    one(id, success, error) {

        if (!id) return false;
        if (this.category.id == id) {
            success(this.category);
        } else {
            this.API.one('categories', id).get().then((item) => {
                this.category = item;
                success(this.category);
            }, error);
        }
    }

    save(category) {
        if (category.id && category.id != 'new') {
            return this.category.save().then((response) => {
                this.ToastService.show('Saved successfully');
                angular.forEach(this.categories, (item) => {
                    if (item.id == category.id) {
                        angular.copy(category, item);
                    }
                });
            });
        } else {
            var data = {
                title: category.title,
                description: category.description,
                language: this.LanguageService.activeLanguage(),
                image_id: category.image_id,
                parent_id: category.parent_id
            };
            this.API.all('categories').post(data).then((response) => {
                this.$translate('Erfolgreich gespeichert.').then((msg) => {
                    this.ToastService.show(msg);
                });
                this.$state.go('cms.categories.details', {
                    id: response.id
                });
                this.categories.push(category);
                return this.category = category;
            });
        }

    }

    move(item, newIndex, newParent) {
        this.API.one('categories', item.id).customPUT({
            sortindex: newIndex,
            parent: (typeof newParent == "undefined" ? 0 : newParent.id)
        }, 'move').then(
            (response) => {
                this.$translate('Kategoriereihenfolge geändert.').then((msg) => {
                    this.ToastService.show(msg);
                });
            }
        );
    }

    cancel() {
        this.$state.go("cms.categories");
    }
    selectCategory(category) {
        return this.selectedCategory = category;
    }
    toggleEnabled(category) {
        this.API.one('categories', category.id).customPUT({
            enabled: category.enabled ? 1 : 0
        }, 'toggleEnabled').then(
            (response) => {
                this.$translate('Kategorie aktualisiert.').then((msg) => {
                    this.ToastService.show(msg);
                });
            },
            (response) => {
                category.enabled = !category.enabled;
            }
        );
    }
}
