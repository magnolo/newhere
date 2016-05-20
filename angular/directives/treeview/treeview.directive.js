class TreeviewController {
    constructor() {
        'ngInject';

        //this.selection = [];
        //
        this.expandedItems = [];
    }
    onDragOver(event, index, external, type) {
      /*if(this.items[index-1].children.length){
        this.items[index-1].expanded = true;
      }*/
        return true;
    }
    onDropComplete(event, index, item, external) {
        angular.forEach(this.items, function(entry, key) {
            if (entry.id == 0) {
                this.items.splice(key, 1);
            }
        })
        return item;
    }
    onMovedComplete(index, data, evt) {
        if (this.options.allowMove) {
            return this.items.splice(index, 1);
        }
    }
    toggleExpansion(item){
      let idx = this.expandedItems.indexOf(item.id);
      if(idx > -1){
        this.expandedItems.splice(idx, 1);
      }
      else{
        this.expandedItems.push(item.id);
      }
    }
    isExpanded(item){
        let idx = this.expandedItems.indexOf(item.id);
        return idx > -1 ? true : false;
    }
    toggleSelection(item) {
        var index = -1;
        angular.forEach(this.selection, function(selected, i) {
            if (selected.id == item.id) {
                index = i;
            }
        });
        if (index > -1) {
            this.selection.splice(index, 1);
        } else {
            this.selection.push(item);
        }
        if(this.options){
          if (typeof this.options.selectionChanged == 'function')
              this.options.selectionChanged(this.selection);
        }


    }
    addChildren(item) {
        item.children = [];
        item.expanded = true;
    }
    selectedItem(item) {
        var found = false;
        angular.forEach(this.selection, function(selected) {
            if (selected.id == item.id) {
                found = true;
            }
        });
        return found;

    }
    findId(list, id){
      let found = false;
      angular.forEach(list, (item) => {
        if(item.id == id){
          found = true;
        }
      });
      return found;
    }
    childSelected(item) {
        var found = false;
        var founds = [];

        if(!this.selection) return false;
        if(!this.selection.length) return false;

      //  if(item.children.length){
          angular.forEach(item.children, (child) =>{
            founds.push(this.findId(this.selection, child.id));
            if(child.children.length){
              angular.forEach(child.children, (c) =>{
                  founds.push(this.findId(this.selection, c.id));
                if(c.children.length){
                  angular.forEach(c.children, (cc) =>{
                      founds.push(this.findId(this.selection, cc.id));

                  })
                }
              })
            }
            // if(sel.id == item.id){
            //   console.log(sel, item);
            // }
          })
        //  console.log(this.selection,item);
      //  }
        //
        // angular.forEach(item.children, function(child) {
        //     if (this.selection.indexOf(child) > -1) {
        //         found = true;
        //     }
        //     if (!found) {
        //         found = this.TreeviewController.childSelected(child, selection);
        //
        //     }
        // })
      //  console.log(founds);
        return founds.indexOf(true) > -1 ? true : false;
      //  return found;
    }


}

export function TreeviewDirective(RecusionsHelperService){
  'ngInject';
    var options = {
			editWeight:false,
			drag: false,
			edit: false,
			children:'children'
		};
    return {
        templateUrl: './views/directives/treeview/treeview.directive.html',
        controller: TreeviewController,
        controllerAs: 'vm',
        scope: {},
        bindToController: {
            items: '=',
            item: '=?',
            selection: '=?',
            options: '=?',
            active: '=?',
            click: '&'
        },
        replace: true ,
        compile: function(element) {

               return RecusionsHelperService.compile(element, function(scope, iElement, iAttrs, controller, transcludeFn) {
                   angular.extend(options, scope.vm.options)
               });
        }
    }
}
