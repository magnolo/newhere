export function NgoPublishedFilter(){
    'ngInject';

    return function( ngos, published ) {
        if (!angular.isUndefined(published)) {
            var filteredNgos = [];
            angular.forEach(ngos, function(ngo) {
                if (ngo.published === published) {
                    filteredNgos.push(ngo);
                }
            });
            return filteredNgos;
        } else {
            return ngos;
        }
    };
}
