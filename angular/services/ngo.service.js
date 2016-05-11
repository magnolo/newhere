export class NgoService{
    constructor(API, $q, ToastService, $state){
        'ngInject';

        this.API = API;
        this.ToastService = ToastService;
        this.$q = $q;
        this.$state = $state;

    }

    fetchAll() {
        var vm = this;
        return this.$q(function(resolve) {
            vm.API.all('ngos').getList().then(function (response) {
                resolve(response)
            }, function (error) {
                console.log(error);
                vm.ToastService.show("Fetching NGOs failed");
            });
        });
    }

    update(ngo) {
        return ngo.save().then((response) => {
            this.ToastService.show('NGO updated.');
        })
    }

    create(ngo) {
        this.API.all('ngos').post(ngo).then(()=>{
            this.ToastService.show('Saved successfully');
            this.$state.go('cms.ngos');
        });
    }
}

