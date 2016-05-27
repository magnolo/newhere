class CmsFilterFormController{
    constructor( $stateParams, FilterService, LanguageService, ToastService){
        'ngInject';

        this.ToastService = ToastService;
        this.FilterService = FilterService;
        this.LanguageService = LanguageService;


        this.LanguageService.getActive((languages) => {
            this.languages = languages;
        });
        this.FilterService.flattened((filters) => {
            this.filters = filters;
        })
        this.filter = {
            title:'',
            translations:[]
        };



        if($stateParams.id != 'new'){
            this.FilterService.one($stateParams.id, (filter) =>{
                this.filter = filter;
            });
        }
    }
    addTranslation(language){
        var exists = false;
        angular.forEach(this.filter.translations, (translation, key) =>{
            if(translation.locale == language){
                exists = true;
                this.activeTransTab = key;
            }
        });
        if(!exists){
            this.filter.translations.push({
                title:'',
                locale: language
            });
        }

    }
    i18nTitle(locale){
        var title;
        angular.forEach(this.languages, (lang) => {
            if(lang.language == locale)
                title = lang.i18n;
        });
        return title;
    }
    save() {
        this.FilterService.save(this.filter);
    }

    cancel() {
        this.FilterService.cancel()
    }
}

export const CmsFilterFormComponent = {
    templateUrl: './views/app/components/cms-filter-form/cms-filter-form.component.html',
    controller: CmsFilterFormController,
    controllerAs: 'vm',
    bindings: {}
}
