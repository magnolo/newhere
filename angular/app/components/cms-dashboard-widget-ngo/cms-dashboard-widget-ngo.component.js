class CmsDashboardWidgetNgoController{
    constructor(API){
        'ngInject';

        this.loading = true;
        this.stats = [];

        API.one('ngos').customGET('stats').then((response) => {
            this.stats = response.data.stats;
            this.loading = false;
        });
    }

    $onInit(){
    }
}

export const CmsDashboardWidgetNgoComponent = {
    templateUrl: './views/app/components/cms-dashboard-widget-ngo/cms-dashboard-widget-ngo.component.html',
    controller: CmsDashboardWidgetNgoController,
    controllerAs: 'vm',
    bindings: {}
}
