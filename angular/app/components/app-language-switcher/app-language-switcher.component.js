class AppLanguageSwitcherController{
    constructor(LanguageService, $state, $rootScope){
        'ngInject';
        this.LanguageService = LanguageService;
        this.LanguageService.fetchPublished((publishedLanguages) => {
            this.languages = publishedLanguages;
        });
        this.$state = $state;
        this.$rootScope = $rootScope;
    }

    $onInit(){
    }

    switchLanguage(language) {
        var vm = this;
        this.LanguageService.changeLanguage(language, function(){
            vm.$state.go('app.start.categories');
            console.log(vm.$rootScope.fromState);
            vm.$rootScope.$broadcast('languageChanged');
        });
    }
}

export const AppLanguageSwitcherComponent = {
    templateUrl: './views/app/components/app-language-switcher/app-language-switcher.component.html',
    controller: AppLanguageSwitcherController,
    controllerAs: 'vm',
    bindings: {}
}
