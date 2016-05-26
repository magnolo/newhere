export function FilterEnabledFilter(){
    'ngInject';

    return function( filters, enabled ) {
        if (angular.isDefined(enabled)) {
            var filteredFilters = [];
            angular.forEach(filters, function(filter) {
                if (filter.enabled === enabled) {
                    filteredFilters.push(filter);
                }
            });
            return filteredFilters;
        } else {
            return filters;
        }
    };
}
