class UserController{
    constructor(UserService){
        'ngInject';

        //
        this.me;
        this.UserService = UserService;
        this.UserService.me((user) => {
          this.me = user;
        });
    }

    $onInit(){
    }
}

export const UserComponent = {
    templateUrl: './views/app/components/user/user.component.html',
    controller: UserController,
    controllerAs: 'vm',
    bindings: {
      field:'@'
    }
}
