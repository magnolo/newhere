class CmsDashboardWidgetTranslationsController{
    constructor(API){
        'ngInject';

        this.loading = true;
        this.stats = [];

        API.one('offer-translations').customGET('stats').then((response) => {
            this.stats = response.data.stats;
            this.loading = false;
        });
    }

    $onInit(){
    }
}

export const CmsDashboardWidgetTranslationsComponent = {
    templateUrl: './views/app/components/cms-dashboard-widget-translations/cms-dashboard-widget-translations.component.html',
    controller: CmsDashboardWidgetTranslationsController,
    controllerAs: 'vm',
    bindings: {}
}
