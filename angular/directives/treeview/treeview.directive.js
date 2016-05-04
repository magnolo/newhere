class TreeviewController {
    constructor() {
        'ngInject';
        console.log(this);
        this.selection = [];
        //
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
        if (typeof this.options.selectionChanged == 'function')
            this.options.selectionChanged();
        console.log(item, this.selection);
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
    childSelected(item) {
        var found = false;
        /*angular.forEach(item.children, function(child) {
            if (this.selection.indexOf(child) > -1) {
                found = true;
            }
            if (!found) {
                found = childSelected(child);

            }
        })*/
        return found;
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
          console.log(this);
               return RecusionsHelperService.compile(element, function(scope, iElement, iAttrs, controller, transcludeFn) {
                   angular.extend(options, scope.vm.options)
               });
        }
    }
}
