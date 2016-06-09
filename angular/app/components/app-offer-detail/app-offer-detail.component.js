class AppOfferDetailController{
    constructor(OfferService, CategoryService,  $state){
        'ngInject';

        var vm = this;

        this.CategoryService = CategoryService;

        OfferService.one($state.params.id, (offer) => {
            vm.offer = offer;
        });
    }

    $onInit(){
    }
    goBack(){
        if(this.CategoryService.category.parent_id){
            this.$state.go('app.start.categories.sub',{
                slug:this.CategoryService.category.parent.slug
            });
        }
        else{
            this.$state.go('app.start.categories');
        }
    }
}

export const AppOfferDetailComponent = {
    templateUrl: './views/app/components/app-offer-detail/app-offer-detail.component.html',
    controller: AppOfferDetailController,
    controllerAs: 'vm',
    bindings: {}
}
