// just a temporary try...
export class CategoryService{
    constructor($http){
        'ngInject';
        var CategoryService = this;

        this.$http = $http;

        this.selectedCategory;
    }

    save(category, id, successCallback, errorCallback) {
        var language = 'de';
        if (category.hasOwnProperty('translation') && category.translation.hasOwnProperty('language')) {
            language = category.translation.language.language;
        }
        var data = {
            title: category.translation.title,
            description: category.translation.description,
            language: language,
            icon: category.icon,
        };
        var url = '/api/category';
        if (typeof id != 'undefined') {
            url = url + '/' + id;
        }

        this.$http.post(url, data)
            .then(
                (response) => {
                    successCallback(response.data);
                },
                (response) => {
                    errorCallback(response.data);
                }
            );
    }
}

