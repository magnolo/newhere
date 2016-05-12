class CmsUsersTableController {
    constructor(UserService, RoleService, LanguageService, DialogService, $filter) {
        'ngInject';

        this.users = [];
        this.user;
        this.roles = [];
        this.filter = {};
        this.selectedUsers = [];
        this.languages = [];

        this.$filter = $filter;
        this.DialogService = DialogService;
        this.UserService = UserService;
        this.UserService.all((list) => {
            this.users = list;
        });
        this.RoleService = RoleService;
        this.RoleService.all((list) => {
            this.roles = list;
        });
        this.LanguageService = LanguageService;
        this.LanguageService.getActive((list) => {
          this.languages = list;
        })

        this.query = {
            order: '-name',
            limit: 10,
            page: 1
        };
        this.search = {
            show: false,
            query: ''
        }
        this.onOrderChange = (order) => {
            return this.users = this.$filter('orderBy')(this.users, [order], true);
        };

        this.onPaginationChange = (page, limit) => {
            //console.log(page, limit);
        };
    }

    exists(item, list) {
        var exists = false;
        angular.forEach(list, (entry) => {
            if (item.id == entry.id) {
                exists = true;
            }
        })
        return exists;
    }
    toggle(item, list) {
        if (this.exists(item, list)) {
            angular.forEach(list, (entry, key) => {
                if (item.id == entry.id) {
                    list.splice(key, 1);
                }
            })
        } else {
            list.push(item);
        }
    }
    userType(type){
      if(!this.user) return;
      var exists = false;
      angular.forEach(this.user.roles, (role) => {
        if(role.name == type){
          exists = true;
        }
      });
      return exists;
    }
    add() {
        this.user = {
            ngos: [],
            roles: [],
            confirmed: false
        };
        this.DialogService.fromTemplate('user', {
            controller: () => this,
            controllerAs: 'vm'
        });
    }
    edit(user) {
        this.user = user;
        this.DialogService.fromTemplate('user', {
            controller: () => this,
            controllerAs: 'vm'
        });
    }
    save(user) {
        if (user) {
            this.user = user;
        }
        if (!this.user) {
            return;
        }
        this.UserService.save(this.user, () => {
            this.DialogService.hide();
        });
    }
    remove() {
        this.DialogService.prompt('Deleting Users?', 'You are about to delete user(s). Is that really a good idea? If so, type in DELETE and confirm?', 'Delete Secret').then((response) => {
            if (response === "DELETE") {
                this.UserService.bulkRemove(this.selectedUsers, (list) => {
                  this.selectedUsers = [];
                  angular.forEach(list, (item) => {
                    angular.forEach(this.users, (user, key) => {
                      if(user.id == item.id){
                        this.users.splice(key, 1);
                      }
                    });
                  });
                });
            } else {
                this.DialogService.alert('Not correct', 'Thankfully, you entered the wrong secret. So nothing is going to change... for now.');
            }
        });
    }
    cancel() {
        this.DialogService.hide();
    }
}

export const CmsUsersTableComponent = {
    templateUrl: './views/app/components/cms-users-table/cms-users-table.component.html',
    controller: CmsUsersTableController,
    controllerAs: 'vm',
    bindings: {}
}
