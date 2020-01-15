<?php

namespace App\Http\Controllers\Web;

use App\Support\Util;
use App\Util\HelperUtil;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            if (auth()->user())
            {
                $data = Notification::select('id', 'short_message')->where(['user_id' => auth()->user()->id, 'is_read' => 0])->orderBy('created_at', 'desc')->get();

                $html_data = '<ul>';

                if ($data && count($data) > 0)
                {
                    $current_lang = HelperUtil::get_currentlang();

                    foreach ($data as $index => $notification)
                    {
                        $html_data .= '<li class="preview"><a href="' . url('/user/notifications/' . HelperUtil::encode($notification->id)) . '">'
                                . '<strong>' . __("frontsistema.notifications.notification_lbl") . ' ' . ($index + 1) . '</strong> ' . __('sistema.notifications.short_message.' . $notification->short_message) . '</a></li>';
                    }
                }
                else
                {
                    $html_data .= '<li><strong class="text-center">' . __("frontsistema.notifications.no_data") . '</strong></li>';
                }
                $html_data .= '</ul>';

                return response()->json(['data' => $html_data, 'flag' => 1], 200);
            }
            else
            {
                $html_data = '<ul>';
                $html_data .= '<li><strong class="text-center">' . __("frontsistema.notifications.no_data") . '</strong></li>';
                $html_data .= '</ul>';

                return response()->json(['data' => $html_data, 'flag' => 1], 200);
            }
        }
        catch (\Exception $ex)
        {
            $html_data = '<ul>';
            $html_data .= '<li><strong class="text-center">' . __("frontsistema.notifications.no_data") . '</strong></li>';
            $html_data .= '</ul>';

            return response()->json(['data' => $html_data, 'flag' => 1], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show($notification_id)
    {
        $user = auth()->user();

        if ($user)
        {
            $id           = HelperUtil::decode($notification_id);

            
            $notification = Notification::where(['id' => $id, 'user_id' => $user->id])->first();

            if (!$notification)
            {
                abort(404);
            }

            //dd($notification->template_name);

            $current_lang = HelperUtil::get_currentlang();
            $view         = \View::make('notifications.' . $current_lang . ".$notification->template_name", ['data' => json_decode($notification->parameters, true)]);
            $page_content = $view->render();

            $notification->is_read = 1;
            $notification->save();
            
            $lstMenus = Util::generateFrontMenu(1);
            return view('notification', compact('page_content'))
                            ->with('notification', $notification)
                            ->with('elmenu', ['elmenu' => $lstMenus]);
        }
        else
        {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }

}
