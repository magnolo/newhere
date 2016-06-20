export function SubarrayFilter(){
    'ngInject';

    return function( input, list ){
        //
        if(typeof list == "undefined" || list.length == 0){
          return input
        }

        var matchList = new Array();
        angular.forEach(input, function(item){
          // if(item.filters.length){
            angular.forEach(item.filters, function(filter){
              var found = new Array();
              angular.forEach(list, function(f){
                if(f.id == filter.id){
                  found.push(true);
                }
              });
              if(found.length >= list.length){
                matchList.push(item);
              }
            });
          // }
          // else{
          //     matchList.push(item);
          // }

        });
        return matchList;
    }
}
