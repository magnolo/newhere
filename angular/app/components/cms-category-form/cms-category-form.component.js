class CmsCategoryFormController{
    constructor($rootScope, CategoryService, API, ToastService){
        'ngInject';

        this.$rootScope = $rootScope;
        this.ToastService = ToastService;
        this.CategoryService = CategoryService;

        this.category;

        $rootScope.$on('category::selected', (e, category) => {
            this.category = angular.copy(category);
        });

        $rootScope.$on('category::new', (e) => {
            this.category = {};
        });
    }

    save() {
        var id = this.category.id || undefined;
        this.CategoryService.save(
            this.category,
            id,
            (category) => {
                this.category = category;
                this.ToastService.show('Saved successfully.');
                this.$rootScope.$emit('category::reload');
            },
            (response) => {
                this.ToastService.show('Error while saving.');
            }
        );
    }
}

export const CmsCategoryFormComponent = {
    templateUrl: './views/app/components/cms-category-form/cms-category-form.component.html',
    controller: CmsCategoryFormController,
    controllerAs: 'vm',
    bindings: {}
}


