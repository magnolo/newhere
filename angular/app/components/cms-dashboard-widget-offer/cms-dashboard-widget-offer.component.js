class CmsDashboardWidgetOfferController{
    constructor(API){
        'ngInject';

        this.loading = true;
        this.stats = [];

        API.one('offers').customGET('stats').then((response) => {
            this.stats = response.data.stats;
            this.loading = false;
        });
    }

    $onInit(){
    }
}

export const CmsDashboardWidgetOfferComponent = {
    templateUrl: './views/app/components/cms-dashboard-widget-offer/cms-dashboard-widget-offer.component.html',
    controller: CmsDashboardWidgetOfferController,
    controllerAs: 'vm',
    bindings: {}
}
