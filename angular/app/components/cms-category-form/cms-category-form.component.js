class CmsCategoryFormController{
    constructor( $stateParams, CategoryService, LanguageService, ToastService){
        'ngInject';

        this.ToastService = ToastService;
        this.CategoryService = CategoryService;
        this.LanguageService = LanguageService;


        this.LanguageService.getActive((languages) => {
          this.languages = languages;
        });
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
