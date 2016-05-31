import {MapService} from './services/map.service';
import {CategoryTranslationService} from './services/categoryTranslation.service';
import {FilterService} from './services/filter.service';
import {NgoService} from './services/ngo.service';
import {OfferService} from './services/offer.service';
import {OfferTranslationService} from './services/offerTranslation.service';
import {OfferDetailService} from './services/offerDetail.service';
import {UserService} from './services/user.service';
import {RoleService} from './services/role.service';
import {LanguageService} from './services/language.service';
import {RecusionsHelperService} from './services/recusionsHelper.service';
import {CategoryService} from './services/category.service';
import {APIService} from './services/API.service';
import {DialogService} from './services/dialog.service';
import {ToastService} from './services/toast.service';


angular.module('app.services')
	.service('MapService', MapService)
	.service('CategoryTranslationService', CategoryTranslationService)
	.service('FilterService', FilterService)
	.service('NgoService', NgoService)
	.service('OfferService', OfferService)
	.service('OfferTranslationService', OfferTranslationService)
	.service('OfferDetailService', OfferDetailService)
	.service('UserService', UserService)
	.service('RoleService', RoleService)
	.service('LanguageService', LanguageService)
	.factory('RecusionsHelperService', RecusionsHelperService)
	.service('CategoryService', CategoryService)
	.service('API', APIService)
	.service('DialogService', DialogService)
	.service('ToastService', ToastService);
