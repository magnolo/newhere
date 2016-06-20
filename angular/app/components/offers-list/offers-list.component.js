class OffersListController{
    constructor(OfferService, $state ){
        'ngInject';

        this.state = $state;
        this.OfferService = OfferService;
        this.query = {
            ngo_id: this.state.params.id,
            order: '-id',
            limit: 4,
            page: 1,
            enabled: true
        };
        this.OfferService.fetchFiltered(this.query, (response) => {
            this.offers = response;
            this.offerCount = response.count;
        });
    }

    goToPage(page) {
        this.query.page = page;
        this.OfferService.fetchFiltered(this.query, (response) => {
            this.offers = response;
        });
    }

    showOffer(id) {
        this.state.go('app.start.detail',{id:id});
    }


}

export const OffersListComponent = {
    templateUrl: './views/app/components/offers-list/offers-list.component.html',
    controller: OffersListController,
    controllerAs: 'vm',
    bindings: {}
}
