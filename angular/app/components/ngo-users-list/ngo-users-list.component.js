class NgoUsersListController{
    constructor(NgoService, $filter, UserService, DialogService, $state){
        'ngInject';
        var vm = this;
        this.users = [];
        this.user;
        this.selectedUsers = [];

        this.$filter = $filter;
        this.$state = $state;
        this.UserService = UserService;
        this.DialogService = DialogService;
        this.NgoService = NgoService;

        this.NgoService.fetchNgoUsers(this.$state.params.id).then(function (users) {
            angular.forEach(users, function (user) {
                var roles = [];
                angular.forEach(user.roles, function (role) {
                    roles.push(role.name);
                });
                user.isNgoAdmin = (roles.indexOf("organisation-admin") > -1);
            });
            vm.users = users;
        });
        this.listFilter = {
            search: ''
        };
        this.listPagination = {
            limit: 10,
            page: 1
        };
        this.listOrderByColumn = '-name';
        this.onOrderChange = (order) => {
            return vm.users = this.$filter('orderBy')(vm.users, [order], true);
        };

    }

    $onInit(){
    }

    addUser() {
        this.user = {
            isNgoAdmin: false
        };
        this.DialogService.fromTemplate('createNgoUser', {
            controller: () => this,
            controllerAs: 'vm'
        });
    }

    toggleAdmin(ngoUser) {
        this.UserService.toggleNgoUserAdmin(ngoUser);
    }

    save() {
        this.user.ngoUser = true;
        if (this.$state.params.id) {
            this.user.ngoId = this.$state.params.id;
        }
        this.UserService.saveNgoUser(this.user, () => {
            this.users.push(this.user);
            this.user = null;
            this.DialogService.hide();
        });
    }

    cancel() {
        this.DialogService.hide();
    }

    removeUsers() {
        this.DialogService.prompt('Mitarbeiter löschen?', 'Sie sind dabei Mitarbeiter zu löschen. Falls Sie das wirklich möchten, geben sie DELETE ein', 'Delete Secret').then((response) => {
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
                this.DialogService.alert('Nicht richtig', 'Sie haben einen falschen Befehl eingegeben. Es wurde nichts geändert.');
            }
        });
    }
}

export const NgoUsersListComponent = {
    templateUrl: './views/app/components/ngo-users-list/ngo-users-list.component.html',
    controller: NgoUsersListController,
    controllerAs: 'vm',
    bindings: {}
}
