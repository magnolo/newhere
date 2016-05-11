export function NgoPublishedFilter(){
    'ngInject';

    return function( ngos, showOnlyUnpublished ) {
        if (showOnlyUnpublished) {
            var filteredNgos = [];
            angular.forEach(ngos, function(ngo) {
                if (!ngo.published) {
                    filteredNgos.push(ngo);
                }
            });
            return filteredNgos;
        } else {
            return ngos;
        }
    };
}
