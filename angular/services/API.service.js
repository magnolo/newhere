export class APIService {
	constructor(Restangular, ToastService, $window) {
		'ngInject';
		//content negotiation
		var headers = {
			'Content-Type': 'application/json',
			'Accept': 'application/x.laravel.v1+json'
		};

		return Restangular.withConfig(function(RestangularConfigurer) {
			RestangularConfigurer
				.setBaseUrl('/api/')
				.setDefaultHeaders(headers)
				.setErrorInterceptor(function(response) {
					if (response.status === 422) {
						for (var error in response.data.errors) {
							return ToastService.error(response.data.errors[error][0]);
						}
					}
				})
				.addFullRequestInterceptor(function(element, operation, what, url, headers) {
					var token = $window.localStorage.satellizer_token;
					if (token) {
						headers.Authorization = 'Bearer ' + token;
					}
					headers.Language = $window.localStorage.language || 'de';
				})
				.addResponseInterceptor(function(data, operation, what, url){
						var extractedData;
           if (operation === "getList") {
						 var type = what;
						 if(type.indexOf('?') > -1){
							 type = what.substring(0, what.indexOf('?'));
						 }
             extractedData = data.data[type];
						 if(data.data['count']){
							 extractedData.count = data.data['count'];
						 }
						 if(data.data['ngoPublished']){
							   extractedData.ngoPublished = data.data['ngoPublished'];
						 }
             extractedData.error = data.errors;
           } else {
             extractedData = data;
           }
           return extractedData;
				});
		});
	}
}
