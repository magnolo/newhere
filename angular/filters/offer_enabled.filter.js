export function OfferEnabledFilter(){
    'ngInject';

    return function( offers, enabled ) {
        if (angular.isDefined(enabled)) {
            var filteredOffers = [];
            angular.forEach(offers, function(offer) {
                if (offer.enabled === enabled) {
                    filteredOffers.push(offer);
                }
            });
            return filteredOffers;
        } else {
            return offers;
        }
    };
}
