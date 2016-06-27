export class NgoService {
    constructor(API, $q, ToastService, $state, $translate, DialogService) {
        'ngInject';

        this.API = API;
        this.ToastService = ToastService;
        this.$q = $q;
        this.$state = $state;
        this.DialogService = DialogService;
        this.$translate = $translate;
    }

    one() {
        var vm = this;
        return this.$q(function(resolve) {
            vm.API.one('ngos/my').get().then(function(response) {
                resolve(response)
            }, function(error) {
                this.$translate('Fehler beim Laden der Daten.').then((msg) => {
                    this.ToastService.error(msg);
                });
            });
        });
    }

    oneById(id) {
        var vm = this;
        return this.$q(function(resolve) {
            vm.API.one('ngo', id).get().then(function(response) {
                resolve(response)
            });
        });
    }


    fetchAll() {
        var vm = this;
        return this.$q(function(resolve) {
            vm.API.all('ngos').getList().then(function(response) {
                resolve(response)
            });
        });
    }

    fetchNgoUsers(ngoId) {
        var vm = this;
        return this.$q(function(resolve) {
            vm.API.all('ngoUsers').getList("query", {
                ngoId: ngoId
            }).then(function(response) {
                resolve(response)
            });
        });

    }

    update(ngo) {
        return ngo.save().then((response) => {
            this.$translate('NGO aktualisiert.').then((msg) => {
                this.ToastService.show(msg);
            });
            this.DialogService.hide();
        })
    }

    cancel(cms) {
        if (cms) {
            this.DialogService.hide();
        } else {
            this.$state.go("app.landing");
        }
    }

    create(ngo) {
        this.API.all('ngos').post(ngo).then(() => {
            this.$state.go(this.$state.current, {}, {
                reload: true
            });
            this.$translate('Erfolgreich gespeichert.').then((msg) => {
                this.ToastService.show(msg);
            });
            this.DialogService.hide();
        });
    }

    togglePublished(ngo) {
        this.API.one('ngos', ngo.id).customPUT({
            published: ngo.published ? 1 : 0
        }, 'togglePublished').then(
            (success) => {
                this.$translate('NGO aktualisiert.').then((msg) => {
                    this.ToastService.show(msg);
                });
            },
            (error) => {
                this.$translate('Fehler beim Speichern der Daten.').then((msg) => {
                    this.ToastService.error(msg);
                });
                ngo.published = !ngo.published;
            }
        );
    }
    bulkRemove(list, success, error) {
        var ids = [];
        angular.forEach(list, (item) => {
            ids.push(item.id);
        });
        this.API.several('ngos', ids).remove().then((response) => {
            this.$translate('%d Ngo(s) gelöscht.').then((msg) => {
                this.ToastService.show(
                    sprintf(msg, response.data.deletedRows)
                );
            });
            success(response.data.ngos);
        });
    }
    bulkAssign(list, field, value, success, error) {
        var ids = [];
        angular.forEach(list, (item) => {
            ids.push(item.id);
        });
        this.API.several('ngos', ids).patch({
            field: field,
            value: value
        }).then((response) => {
            this.$translate('Ngo(s) aktualisiert.').then((msg) => {
                this.ToastService.show(msg);
            });
            this.ToastService.show('Ngo successfully updated!');
            success(response.data.ngos);
        });
    }
}