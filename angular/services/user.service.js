export class UserService {
    constructor(API, ToastService) {
        'ngInject';

        this._promise;
        this._callbacks = new Array();

        this.API = API;
        this.ToastService = ToastService;
        this.users;
        this.user;
    }
    all(success, error, force) {
        if (angular.isDefined(this.users) && !force) {
            success(this.users);
        } else if (angular.isDefined(this._promise)) {
            this._callbacks.push(success);
        } else {
            this._callbacks.push(success);
            this._promise = this.API.all('users').getList().then((list) => {
                this.users = list;
                angular.forEach(this._callbacks, (callback) => {
                    callback(this.users);
                })
                this._promise = null;
            }, error);
        }
    }
    one(id, success, error){
      this.API.one('users', id).get().then((item) => {
        this.user = item;
        success(this.user);
      },error);
    }
    save(user, success){
      if(user.id && user.id != 'new'){
        user.save().then((response) => {
          this.ToastService.show('Saved successfully');
          success(response);
        });
      }
      else{
        this.API.all('users').post(user).then((response)=>{
          this.ToastService.show('Saved successfully');
          this.one(response.data.user.id, (user) =>{
            this.users.push(user);
            console.log(this.users);
          })
          success(response);
        });
      }
    }
    bulkRemove(list, success, error){
      var ids = [];
      angular.forEach(list, (item) => {
        ids.push(item.id);
      });
      this.API.several('users', ids).remove().then((response) => {
          this.ToastService.show(response.data.deletedRows+' item(s) successfully deleted!');
         success(response.data.users);
      });
    }
}