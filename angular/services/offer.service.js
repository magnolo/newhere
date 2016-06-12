export class OfferService{
    constructor(API, $q, ToastService, $state, $translate, DialogService){
        'ngInject';

        this.API = API;
        this.ToastService = ToastService;
        this.$q = $q;
        this.$state = $state;
        this.DialogService = DialogService;
        this.offer;
        this.$translate = $translate;
    }

    count(){

    }
    fetchAll() {
        var vm = this;
        return this.$q(function(resolve) {
            vm.API.all('offers').getList().then(function (response) {
                resolve(response)
            }, function (error) {
                console.log(error);
                this.$translate('Fehler beim Laden der Daten.').then((msg) => {
                    this.ToastService.error(msg);
                });
            });
        });
    }
    fetchFiltered(query,success, error, force){
      var q = this.API.all('offers').getList(query);
      q.then((response) =>{
        success(response);
      });
      return q;
    }

    one(id, success, error) {

        if (!id) return false;
        // if (this.offer.id == id) {
        //     success(this.offer);
        // } else {
            this.API.one('offers', id).get().then((item) => {
                this.offer = item;
                success(this.offer);
            }, error);
        // }
    }

    cancel(cms) {
        if (cms) {
            this.$state.go("cms.offers");
        }
    }

    create(offer) {
        this.API.all('offer').post(offer).then(()=>{
            this.$state.go(this.$state.current, {}, {reload: true});
            this.$translate('Erfolgreich gespeichert.').then((msg) => {
                this.ToastService.show(msg);
            });
            this.DialogService.hide();
        });
    }
    save(offer, success, error, goto){
      if(offer.id){
        offer.save().then((response) => {
                this.$translate('Angebot aktualisiert.').then((msg) => {
                    this.ToastService.show(msg);
                });
                if(success) success(response);
                this.$state.go("cms.offers");
            },
            (error) => {
                this.$translate('Fehler beim Speichern der Daten.').then((msg) => {
                    this.ToastService.error(msg);
                });
            }
        );
      }
      else{
        this.API.all('offers').post(offer).then((response)=>{
            this.$state.go(this.$state.current, {}, {reload: true});
            this.$translate('Erfolgreich gespeichert.').then((msg) => {
                this.ToastService.show(msg);
            });
            this.DialogService.hide();
              if(success) success(response);
              if(goto){
                this.$state.go(goto);
              }
              else{
                  this.$state.go("cms.offers");
              }

        });
      }

    }
    toggleEnabled(offer) {
        this.API.one('offers', offer.id).customPUT({
            enabled: offer.enabled ? 1 : 0
        },'toggleEnabled').then(
            (success) => {
                this.$translate('Angebot aktualisiert.').then((msg) => {
                    this.ToastService.show(msg);
                });
            },
            (error) => {
                console.log(error);
                this.$translate('Fehler beim Speichern der Daten.').then((msg) => {
                    this.ToastService.error(msg);
                });
                offer.enabled = !offer.enabled;
            }
        );
    }
    bulkRemove(list, success, error){
        var ids = [];
        angular.forEach(list, (item) => {
            ids.push(item.id);
        });
        this.API.several('offers', ids).remove().then((response) => {
            this.$translate('{{count}} Angebote gelöscht.', {count: response.data.deletedRows}).then((msg) => {
                this.ToastService.show(msg);
            });
            success(response.data.offers);
        });
    }
    bulkAssign(list, field, value, success, error){
      var ids = [];
      angular.forEach(list, (item) => {
          ids.push(item.id);
      });
      this.API.several('offers', ids).patch({
        field: field,
        value: value
      }).then((response) => {
          this.$translate('Angebot aktualisiert.').then((msg) => {
            this.ToastService.show(msg);
          });
          this.ToastService.show('Offers successfully updated!');
          success(response.data.offers);
      });
    }
}
