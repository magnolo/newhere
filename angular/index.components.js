import {CmsLanguageTableComponent} from './app/components/cms-language-table/cms-language-table.component';
import {LoginFormComponent} from './app/components/login-form/login-form.component';
import {RegisterFormComponent} from './app/components/register-form/register-form.component';

angular.module('app.components')
	.component('cmsLanguageTable', CmsLanguageTableComponent)
	.component('loginForm', LoginFormComponent)
	.component('registerForm', RegisterFormComponent);

