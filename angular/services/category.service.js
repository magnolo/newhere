// just a temporary try...
export class CategoryService{
    constructor(API, ToastService, $state){
        'ngInject';
        var CategoryService = this;

        this.API = API;
        this.ToastService = ToastService;
        this.$state = $state;
        this.categories = [];
        this.category = {};
    }
    fetchAll(){
      return this.API.all('categories').getList().then((list) => {
        angular.copy(list, this.categories);
      });
    }
    one(id){
      if(!id) return;
      return this.API.one('categories', id).get().then((item) => {
        angular.copy(item, this.category);
      });
    }
    save(category){
      if(category.id && category.id != 'new'){
        return this.category.save().then((response)=>{
          this.ToastService.show('Saved successfully');
          angular.forEach(this.categories, function(item){
            if(item.id == category.id){
              angular.copy(category, item);
            }
          })
        });
      }
      else{
        var data = {
            title: category.title,
            description: category.description,
            language: 'de',
            icon: category.icon,
            parent_id: category.parent_id
        };
        return this.API.all('categories').post(data).then((response)=>{
          category.id = response.id;
          this.ToastService.show('Saved successfully');
          this.$state.go('cms.categories.details', {id: response.id});
          this.fetchAll();
          return this.category = category;
        });
      }

    }
    selectCategory(category){
      return this.selectedCategory = category;
    }
    toggleEnabled(category){
      this.API.one('categories', category.id).customPUT({
        enabled: category.enabled ? 1 : 0
      },'toggleEnabled').then(
            (response) => {
                this.ToastService.show('Category updated.');
            },
            (response) => {
                //this.ToastService.show('Category updated.');
                category.enabled = !category.enabled;
            }
        );
    }
}
