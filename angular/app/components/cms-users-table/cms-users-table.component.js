class CmsUsersTableController{
    constructor(UserService, RoleService, DialogService, $filter){
        'ngInject';


        this.$filter = $filter;
        this.DialogService = DialogService;
        this.UserService = UserService;
        this.UserService.all((list)=>{
          this.users = list;
        });
        this.RoleService = RoleService;
        this.RoleService.all((list)=>{
          this.roles = list;
        });

        this.query = {
            order: '-name',
            limit: 10,
            page: 1
        };
        this.search = {
          show:false,
          query: ''
        }


        this.onOrderChange = (order) => {
            return this.users = this.$filter('orderBy')(this.users, [order], true);
        };

        this.onPaginationChange = (page, limit) => {
            //console.log(page, limit);
        };
    }


    $onInit(){
      this.users = [];
      this.user;
      this.roles = [];
      this.filter = {};
    }
    exists(role, list){
      var exists = false;
      angular.forEach(list,(item) =>{
        if(item.id == role.id){
          exists = true;
        }
      })
      return exists;
    }
    toggleRole(role, list){
      if(this.exists(role,list)){
        angular.forEach(list, (item, key) =>{
          if(item.id == role.id){
            list.splice(key, 1);
          }
        })
      }
      else{
        list.push(role);
      }
    }
    add(){
      this.user = {
        ngos:[],
        roles:[],
        confirmed: false
      };
      this.DialogService.fromTemplate('user',{
        controller: () => this,
        controllerAs: 'vm'
      });
    }
    edit(user){
      this.user = user;
      this.DialogService.fromTemplate('user',{
        controller: () => this,
        controllerAs: 'vm'
      });
    }
    save(){
      if(!this.user){
        return;
      }
      this.UserService.save(this.user, () =>{
        this.DialogService.hide();
      });
    }
    cancel(){
      this.DialogService.hide();
    }
}

export const CmsUsersTableComponent = {
    templateUrl: './views/app/components/cms-users-table/cms-users-table.component.html',
    controller: CmsUsersTableController,
    controllerAs: 'vm',
    bindings: {}
}
