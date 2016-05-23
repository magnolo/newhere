import {CompareToDirective} from './directives/compareTo/compareTo.directive';
import {TreeviewDirective} from './directives/treeview/treeview.directive';

angular.module('app.directives')
	.directive('compareTo', CompareToDirective)
	.directive('treeview', TreeviewDirective);
