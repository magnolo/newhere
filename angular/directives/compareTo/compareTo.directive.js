/**
 * Compares one ng-model to another
 * See: http://plnkr.co/edit/FipgiTUaaymm5Mk6HIfn
 * @returns {{require: string, scope: {otherModelValue: string}, link: link}}
 * @constructor
 */
export function CompareToDirective(){
    return {
        require: "ngModel",
        scope: {
            otherModelValue: "=compareTo"
        },
        link: function(scope, element, attributes, ngModel) {

            ngModel.$validators.compareTo = function(modelValue) {
                return modelValue == scope.otherModelValue;
            };

            scope.$watch("otherModelValue", function() {
                ngModel.$validate();
            });
        }
    }
}
