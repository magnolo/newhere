class CmsRolesTableController{
    constructor(RoleService, $filter){
        'ngInject';

        //
        this.$filter = $filter;
        this.RoleService = RoleService;
        this.roles = [];
        this.RoleService.all((list) => {
          this.roles = list
        });

        this.query = {
            order: '-name',
            limit: 10,
            page: 1
        };
        this.search = {
          show:false,
          query: ''
        }

        this.onOrderChange = (order) => {
            return this.roles = this.$filter('orderBy')(this.roles, [order], true);
        };

    }
    cancel() {
        this.RoleService.cancel();
    }

    $onInit(){

    }
}

export const CmsRolesTableComponent = {
    templateUrl: './views/app/components/cms-roles-table/cms-roles-table.component.html',
    controller: CmsRolesTableController,
    controllerAs: 'vm',
    bindings: {}
}
