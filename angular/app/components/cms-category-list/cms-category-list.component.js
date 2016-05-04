class CmsCategoryListController{
    constructor($rootScope, API){
        'ngInject';
        var CmsCategoryListController = this;

        this.$rootScope = $rootScope;
        this.categoryAPI = API.all('category');

        this.categories = [];

        this.categoryAPI.getList()
            .then(
                (list) => {
                    this.categories = list;
                }
            );

        $rootScope.$on('category::reload', (e) => {
            this.categoryAPI.getList()
                .then(
                    (list) => {
                        this.categories = list;
                    }
                );
        });
    }

    selectCategory(category) {
        this.$rootScope.$emit('category::selected', category);
    }

    newCategory() {
        this.$rootScope.$emit('category::new');
    }

    toggleEnabled(category) {
        category.customPOST({enabled: category.enabled ? 1 : 0})
            .then(
                (response) => {
                    this.ToastService.show('Category updated.');
                },
                (response) => {
                    //this.ToastService.show('Category updated.');
                    category.enabled = !category.enabled;
                }
            );
    }
}

export const CmsCategoryListComponent = {
    templateUrl: './views/app/components/cms-category-list/cms-category-list.component.html',
    controller: CmsCategoryListController,
    controllerAs: 'vm',
    bindings: {}
}


