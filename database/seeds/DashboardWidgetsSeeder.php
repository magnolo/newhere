<?php

use Illuminate\Database\Seeder;

class DashboardWidgetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $widget = new \App\DashboardWidget();
        $widget->name = 'ngo-stats';
        $widget->angular_component = 'cms-dashboard-widget-ngo';
        $widget->save();

        /*$widget = new \App\DashboardWidget();
        $widget->name = 'category-stats';
        $widget->angular_component = 'cms-dashboard-widget-category';
        $widget->save();*/

        $widget = new \App\DashboardWidget();
        $widget->name = 'offer-stats';
        $widget->angular_component = 'cms-dashboard-widget-offer';
        $widget->save();

        /*$widget = new \App\DashboardWidget();
        $widget->name = 'filter-stats';
        $widget->angular_component = 'cms-dashboard-widget-filter';
        $widget->save();*/

        $widget = new \App\DashboardWidget();
        $widget->name = 'translations';
        $widget->angular_component = 'cms-dashboard-widget-translations';
        $widget->save();
    }
}
