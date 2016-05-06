class CmsCategoryFormController{
    constructor( $stateParams, CategoryService, LanguageService, ToastService){
        'ngInject';

        this.ToastService = ToastService;
        this.CategoryService = CategoryService;
        this.categories = CategoryService.categories;
        this.LanguageService = LanguageService;
        this.languages = this.LanguageService.getActive();
        this.category = {
          title:'',
          description:''
        };

        if($stateParams.id != 'new'){
          this.CategoryService.one($stateParams.id, (category) =>{
            this.category = category;
          });
        }
    }

    save() {
      this.CategoryService.save(this.category);
    }
}

export const CmsCategoryFormComponent = {
    templateUrl: './views/app/components/cms-category-form/cms-category-form.component.html',
    controller: CmsCategoryFormController,
    controllerAs: 'vm',
    bindings: {}
}
