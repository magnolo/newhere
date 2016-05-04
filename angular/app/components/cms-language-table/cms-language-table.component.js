class CmsLanguageTableController{
    constructor($filter, API, ToastService){
        'ngInject';
        var CmsLanguageTableController = this;
        
        this.$filter = $filter;
        this.API = API;
        this.languageAPI = API.all('language');
        this.ToastService = ToastService;

        this.languages = [];
        this.query = {
            order: '-language',
            limit: 10,
            page: 1
        };
        this.filter = {
            enabled: '',
            published: ''
        };

        this.languageAPI.getList()
            .then(
                (list) => {
                    this.languages = this.$filter('orderBy')(list, [this.query.order], true);
                }
            );

        this.onOrderChange = (order) => {
            return this.languages = this.$filter('orderBy')(this.languages, [order], true);
        };

        this.onPaginationChange = (page, limit) => {
            //console.log(page, limit);
        };
    }

    toggleEnabled(language) {
        language.customPOST({enabled: language.enabled ? 1 : 0})
            .then(
                (response) => {
                    this.ToastService.show('Language updated.');
                },
                (response) => {
                    language.enabled = !language.enabled;    
                }
            );
    }

    togglePublished(language) {
        language.customPOST({published: language.published ? 1 : 0})
            .then(
                (response) => {
                    this.ToastService.show('Language updated.');
                },
                (response) => {
                    language.published = !language.published;
                }
            );
    }
}

export const CmsLanguageTableComponent = {
    templateUrl: './views/app/components/cms-language-table/cms-language-table.component.html',
    controller: CmsLanguageTableController,
    controllerAs: 'vm',
    bindings: {}
}


