export function SprintfFilter(){
    'ngInject';

    return function( input ){
        //
        return sprintf.apply(input, arguments)
    }
}
