export class OfferService{
    constructor(API, $q, ToastService, $state, DialogService){
        'ngInject';

        this.API = API;
        this.ToastService = ToastService;
        this.$q = $q;
        this.$state = $state;
        this.DialogService = DialogService;
        this.offer;
    }


    fetchAll() {
        var vm = this;
        return this.$q(function(resolve) {
            vm.API.all('offers').getList().then(function (response) {
                resolve(response)
            }, function (error) {
                console.log(error);
                vm.ToastService.show("Fetching Offers failed");
            });
        });
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
            this.DialogService.hide();
        } else {
            this.$state.go("app.landing");
        }
    }

    create(offer) {
        this.API.all('offer').post(offer).then(()=>{
            this.$state.go(this.$state.current, {}, {reload: true});
            this.ToastService.show('Saved successfully');
            this.DialogService.hide();
        });
    }
    save(offer, success, error){
      if(offer.id){
        offer.save().then((response) => {
                this.ToastService.show('Offer updated.');
                if(success) success(response);
            },
            (error) => {
                this.ToastService.error('Offer update failed. Please try again');
            }
        );
      }
      else{
        this.API.all('offers').post(offer).then((response)=>{
            this.$state.go('', {}, {reload: true});
            this.ToastService.show('Saved successfully');
            this.DialogService.hide();
              if(success) success(response);
        });
      }

    }
    toggleEnabled(offer) {
        this.API.one('offers', offer.id).customPUT({
            enabled: offer.enabled ? 1 : 0
        },'toggleEnabled').then(
            (success) => {
                this.ToastService.show('Offer updated.');
            },
            (error) => {
                console.log(error);
                this.ToastService.error('Offer update failed. Please try again');
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
            this.ToastService.show(response.data.deletedRows+' item(s) successfully deleted!');
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
          this.ToastService.show('Offers successfully updated!');
          success(response.data.offers);
      });
    }
}
