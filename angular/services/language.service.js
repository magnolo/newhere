export class LanguageService{
    constructor(API,ToastService,$window, $filter){
        'ngInject';

        this.$filter = $filter;
        this.$window = $window;
        this.API = API;
        this.ToastService = ToastService;
        this.languages = [];
        this.activeLanguages = [];
        this.selectedLanguage = '';
    }

    fetchAll(success, error, force){
      if(this.languages.length && !force){
        success(this.languages);
      }
      else{
       this.API.all('languages').getList().then((list) => {
          this.languages = list
          success(this.languages);
        })
      }
    }
    fetchPublished(doneFn){
      return this.API.all('languages/published').getList().then((list) => {
        if(typeof doneFn == "function"){
          doneFn();
        }
        return angular.copy(list, this.languages);
      })
    }
    getActive(){
      if(!this.languages.length){
        this.fetchAll(() => {
           angular.copy(this.$filter('filter')(this.languages, {'enabled': true}, true),this.activeLanguages);
        });
      }
      return this.activeLanguages;
    }
    changeLanguage(language, doneFn){
      this.selectedLanguage = this.$window.localStorage.language = language;
      if(typeof doneFn == "function"){
        doneFn();
      }
      return this.selectedLanguage;
    }
    activeLanguage(){
      if(this.selectedLanguage == ''){
        this.selectedLanguage = this.$window.localStorage.language || 'de';
      }
      return this.selectedLanguage;
    }
    update(language){
      return language.save().then((response) => {
        this.ToastService.show('Language updated.');
      })
    }
}
