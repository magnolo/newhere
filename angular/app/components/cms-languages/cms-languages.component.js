class CmsLanguagesController{
    constructor(LanguageService){
        'ngInject';

        this.LanguageService = LanguageService;
        this.languages = LanguageService.getActive();
        this.language = this.LanguageService.activeLanguage();
    }
    onChange(doneFn){
      this.LanguageService.changeLanguage(this.language);
    }
}

export const CmsLanguagesComponent = {
    templateUrl: './views/app/components/cms-languages/cms-languages.component.html',
    controller: CmsLanguagesController,
    controllerAs: 'vm',
    bindings: {
      changeFunction: '='
    }
}
