class CmsLanguageTableController{
    constructor($filter, LanguageService){
        'ngInject';

        this.$filter = $filter;
        this.LanguageService = LanguageService;
        this.languages = this.LanguageService.getAll();

        this.query = {
            order: '-language',
            limit: 10,
            page: 1
        };
        this.search = {
          show:false,
          query: ''
        }
        this.filter = {
            enabled: '',
            published: '',
        };

        this.onOrderChange = (order) => {
            return this.languages = this.$filter('orderBy')(this.languages, [order], true);
        };

        this.onPaginationChange = (page, limit) => {
            //console.log(page, limit);
        };
    }
    removeFilter(){
      this.search = {
        show:false,
        query: ''
      }
    }
    save(language) {

      language.save();
      //this.LanguageService.update(language);
    }
}

export const CmsLanguageTableComponent = {
    templateUrl: './views/app/components/cms-language-table/cms-language-table.component.html',
    controller: CmsLanguageTableController,
    controllerAs: 'vm',
    bindings: {}
}
