export class RoleService{
    constructor(API, ToastService){
        'ngInject';

        this.API = API;
        this._promise;
        this._callbacks = new Array();

        this.roles;

    }
    all(success, error, force){
      if(angular.isDefined(this.roles) && !force){
        success(this.roles);
      }
      else if(angular.isDefined(this._promise)){
        this._callbacks.push(success);
      }
      else{
        this._callbacks.push(success);
        this._promise = this.API.all('roles').getList().then((list) => {
          this.roles = list;
          angular.forEach(this._callbacks, (callback) => {
            callback(this.roles);
          })
          this._promise = null;
        }, error);
      }
    }
}
