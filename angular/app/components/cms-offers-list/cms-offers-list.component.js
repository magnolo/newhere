class CmsOffersListController{
    constructor(OfferService, $filter, $state, DialogService){
        'ngInject';
        var vm = this;
        this.filter = {};
        this.$filter = $filter;
        this.$state = $state;
        this.DialogService = DialogService;
        this.OfferService = OfferService;
        this.OfferService.fetchAll().then(function(response) {
            vm.offers = response;
        });

        this.selectedOffers = [];

        this.query = {
            order: '-id',
            limit: 10,
            page: 1
        };
        this.search = {
            show: false,
            query: ''
        }

        this.listOrderByColumn = '-organisation';
        this.onOrderChange = (order) => {
            console.log("onOrderChange " + order);
            return vm.offers = this.$filter('orderBy')(vm.offers, [order], true);
        };
        this.onPaginationChange = (page, limit) => {
            //console.log(page, limit);
        };
    }

    toggleEnabled(offer) {
        this.OfferService.toggleEnabled(offer);
    }

    add() {
        this.offer = {};
        //this.DialogService.fromTemplate('offer', {
        //    controller: () => this,
        //    controllerAs: 'vm'
        //});
    }

    details(offer) {
        this.offer = offer;
        //this.DialogService.fromTemplate('offer', {
        //    controller: () => this,
        //    controllerAs: 'vm'
        //});
    }

    remove() {
        //this.DialogService.prompt('Deleting Offers?', 'You are about to delete offer(s). Is that really a good idea? If so, type in DELETE and confirm?', 'Delete Secret').then((response) => {
        //    if (response === "DELETE") {
        //        this.OfferService.bulkRemove(this.selectedOffers, (list) => {
        //            this.selectedOffers = [];
        //            angular.forEach(list, (item) => {
        //                angular.forEach(this.offers, (offer, key) => {
        //                    if(offer.id == item.id){
        //                        this.offers.splice(key, 1);
        //                    }
        //                });
        //            });
        //        });
        //    } else {
        //        this.DialogService.alert('Not correct', 'Thankfully, you entered the wrong secret. So nothing is going to change... for now.');
        //    }
        //});
    }

    $onInit(){
    }
}

export const CmsOffersListComponent = {
    templateUrl: './views/app/components/cms-offers-list/cms-offers-list.component.html',
    controller: CmsOffersListController,
    controllerAs: 'vm',
    bindings: {}
}