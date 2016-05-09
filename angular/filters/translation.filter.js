// just a temporary try...
export function TranslationFilter(){
    'ngInject';

    return function(items, language){
        if (typeof items == 'undefined') {
            return;
        }

        angular.forEach(items, function(item, index) {
            angular.forEach(item.translations, function(translation, index) {
                if (translation.language.language == language || (typeof language == 'undefined' && translation.language.default_language)) {
                    item.translation = translation;
                }
            });
        });

        return items;
    }
}
