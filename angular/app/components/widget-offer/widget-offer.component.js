class WidgetOfferController{
    constructor(OfferService){
        'ngInject';

        //
        this.offers;
        this.OfferService = OfferService;
        this.OfferService.fetchAll().then((list) => {
          this.offers = list;
        })
    }

    $onInit(){
    }
}

export const WidgetOfferComponent = {
    templateUrl: './views/app/components/widget-offer/widget-offer.component.html',
    controller: WidgetOfferController,
    controllerAs: 'vm',
    bindings: {}
}
