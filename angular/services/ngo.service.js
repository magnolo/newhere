export class NgoService{
    constructor(API, $q, ToastService, $state, DialogService){
        'ngInject';

        this.API = API;
        this.ToastService = ToastService;
        this.$q = $q;
        this.$state = $state;
        this.DialogService = DialogService;

    }

    one(){
        var vm = this;
        return this.$q(function(resolve) {
            vm.API.one('ngos/my').get().then(function (response) {
                resolve(response)
            }, function (error) {
                vm.ToastService.show("Fetching NGO failed");
            });
        });
    }

    oneById(id){
        var vm = this;
        return this.$q(function(resolve) {
            vm.API.one('ngo',id).get().then(function (response) {
                resolve(response)
            });
        });
    }


    fetchAll() {
        var vm = this;
        return this.$q(function(resolve) {
            vm.API.all('ngos').getList().then(function (response) {
                resolve(response)
            });
        });
    }

    fetchNgoUsers(ngoId) {
        var vm = this;
        return this.$q(function(resolve) {
            vm.API.all('ngoUsers').getList("query", {ngoId : ngoId}).then(function (response) {
                resolve(response)
            });
        });

    }

    update(ngo) {
        return ngo.save().then((response) => {
            this.ToastService.show('NGO updated.');
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
        this.API.all('ngos').post(ngo).then(()=>{
            this.$state.go(this.$state.current, {}, {reload: true});
            this.ToastService.show('Saved successfully');
            this.DialogService.hide();
        });
    }

    togglePublished(ngo) {
        this.API.one('ngos', ngo.id).customPUT({
            published: ngo.published ? 1 : 0
        },'togglePublished').then(
            (success) => {
                this.ToastService.show('NGO updated.');
            },
            (error) => {
                this.ToastService.show('NGO update failed. Please try again');
                ngo.published = !ngo.published;
            }
        );
    }
}

