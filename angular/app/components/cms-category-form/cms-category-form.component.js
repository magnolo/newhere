class CmsCategoryFormController{
    constructor( $stateParams, CategoryService, LanguageService, ToastService){
        'ngInject';

        this.ToastService = ToastService;
        this.CategoryService = CategoryService;
        this.LanguageService = LanguageService;


        this.LanguageService.getActive((languages) => {
          this.languages = languages;
        });
        this.CategoryService.flattened((categories) => {
          this.categories = categories;
        })
        this.category = {
          title:'',
          description:'',
          translations:[]
        };



        if($stateParams.id != 'new'){
          this.CategoryService.one($stateParams.id, (category) =>{
            this.category = category;
          });
        }
    }
    addTranslation(language){
      var exists = false;
      angular.forEach(this.category.translations, (translation, key) =>{
          if(translation.locale == language){
            exists = true;
            this.activeTransTab = key;
          }
      });
      if(!exists){
        this.category.translations.push({
          title:'',
          description:'',
          locale: language
        });
      }

    }
    save() {
      this.CategoryService.save(this.category);
    }

    cancel() {
        this.CategoryService.cancel()
    }
}

export const CmsCategoryFormComponent = {
    templateUrl: './views/app/components/cms-category-form/cms-category-form.component.html',
    controller: CmsCategoryFormController,
    controllerAs: 'vm',
    bindings: {}
}
