class CmsDashboardGridController{
    constructor($compile, $scope, API){
        'ngInject';

        this.$compile = $compile;
        this.$scope = $scope;
        this.API = API;

        this.availableSlots = ['slot-1', 'slot-2', 'slot-3'];
        this.availableWidgets = [];
        this.userWidgets = [];

        this.API.all('dashboard').customGETLIST('widgets').then((list) => {
            this.availableWidgets = list;
        });
        
        this.API.all('dashboard').getList().then((list) => {
            this.userWidgets = list;
            angular.forEach(this.userWidgets, (userWidget, ignore) => {
                this.loadWidget(userWidget.dashboard_widget, userWidget.slot);
            });
        });
    }
    
    useWidget(widget, slot) {
        this.API.one('dashboard').customPOST({
            widget: widget.id,
            slot: slot
        }, '').then((response) => {
            this.loadWidget(
                response.data.userDashboardWidget.dashboard_widget,
                response.data.userDashboardWidget.slot
            );
        });
    }

    loadWidget(widget, slot) {
        angular.element(document.getElementById(slot)).empty();
        angular.element(document.getElementById(slot)).append(
            this.$compile('<' + widget.angular_component + '></' + widget.angular_component + '>')(this.$scope)
        );
    }
    
    getIcon(widgetname) {
        switch (widgetname) {
            case 'ngo-stats':
                return 'business';
            case 'offer-stats':
                return 'local_offer';
            case 'translations':
                return 'translate';
            default:
                return 'dashboard';
        }
    }

    $onInit(){
    }
}

export const CmsDashboardGridComponent = {
    templateUrl: './views/app/components/cms-dashboard-grid/cms-dashboard-grid.component.html',
    controller: CmsDashboardGridController,
    controllerAs: 'vm',
    bindings: {}
}
