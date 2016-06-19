<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request,
    App\Http\Controllers\Controller,
    App\Http\Requests,
    Auth;


class DashboardController extends Controller
{
    public function widgets()
    {
        $widgets = \App\DashboardWidget::all();
        return response()->success(compact('widgets'));
    }

    public function userWidgets()
    {
        /**
         * @var \App\User $user
         */
        $user = Auth::user();

        $userDashboardWidgets = \App\UserDashboardWidget::where('user_id', $user->id)
            ->with('dashboardWidget')->get();

        return response()->success(['dashboard' => $userDashboardWidgets]);
    }

    public function saveUserWidget(Request $request)
    {
        $this->validate($request, [
            'widget' => 'required|exists:dashboard_widgets,id',
            'slot' => 'required|string|min:1|max:255',
        ]);

        /**
         * @var \App\DashboardWidget $widget
         */
        $widget = \App\DashboardWidget::findOrFail((int)$request->get('widget'));

        /**
         * @var \App\User $user
         */
        $user = Auth::user();

        $userDashboardWidgets = \App\UserDashboardWidget::where('user_id', $user->id)
            ->where('slot', $request->get('slot'))->get();

        foreach ($userDashboardWidgets as $uW) {
            /**
             * @var \App\UserDashboardWidget $uW
             */
            $uW->delete();
        }
        
        $userDashboardWidget = new \App\UserDashboardWidget();
        $userDashboardWidget->slot = $request->get('slot');
        $userDashboardWidget->user_id = $user->id;
        $userDashboardWidget->dashboard_widget_id = $widget->id;
        $userDashboardWidget->save();
        $userDashboardWidget->load('dashboardWidget');

        return response()->success(compact('userDashboardWidget'));
    }
}
