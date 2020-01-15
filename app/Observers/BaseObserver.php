<?php

namespace App\Observers;

use Log;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActionLog;

class BaseObserver extends AbstractObserver
{

    public $ignore_arr;

    public function __construct()
    {
        $this->ignore_arr = [
            'id', 'created_at', 'updated_at', 'deleted_at', 'remember_token', 'password', 'completiondate'
        ];
    }

    public function created($model)
    {
        try
        {
            $tbl_name = $model->getTable();

            $message = array();
            $attr    = $model->getAttributes();
            $type    = 'created';

            $model_fkeys = $model->getFkeys();

            foreach ($attr as $key => $attr_val)
            {
                if (!in_array($key, $this->ignore_arr))
                {
                    if (isset($model_fkeys[$key]))
                    {
                        $mod_for_ref = 'App\\Models\\' . $model_fkeys[$key]['model'];

                        $lang       = $model_fkeys[$key]['lang'];
                        $field_name = $model_fkeys[$key]['field'];

                        if ($lang)
                        {
                            $field_name_en = $field_name . 'en';
                            $field_name_es = $field_name . 'es';
                        }
                        $new_value = $mod_for_ref::find($attr_val);
                        $message[] = [
                            'fieldlabel'     => $key,
                            'fk'             => true,
                            'oldvalue'       => '',
                            'newValueLbl_en' => $new_value ? ($lang ? $new_value->$field_name_en : $new_value->$field_name) : 'N/A',
                            'newValueLbl_es' => $new_value ? ($lang ? $new_value->$field_name_es : $new_value->$field_name) : 'N/A',
                            'newvalue'       => $attr_val,
                            'type'           => $type
                        ];
                    }
                    else
                    {
                        $message[] = array('fieldlabel' => $key, 'fk' => false, 'oldvalue' => '', 'newvalue' => $attr_val, 'type' => $type);
                    }
                }
            }

            $userlog              = new UserActionLog;
            $userlog->user_id     = auth()->user() ? auth()->user()->id : 1;
            $userlog->action_type = 1;
            $userlog->extra       = json_encode($message);
            $userlog->model_name  = class_basename($model);
            $userlog->tbl_name    = $tbl_name;
            $userlog->tbl_id      = $model->id;
            $userlog->save();
        }
        catch (\Exception $ex)
        {
            Log::error('base_oberserver: created ' . $ex->getMessage(), $model);
        }
    }

    public function updated($model)
    {
        try
        {
            $changed  = $model->isDirty() ? $model->getDirty() : false;
            $original = $model->getOriginal();
            $tbl_name = $model->getTable();

            $model_fkeys = $model->getFkeys();

            if ($changed)
            {
                $message = array();
                $type    = 'edit';

                foreach ($changed as $key => $val)
                {
                    if (!in_array($key, $this->ignore_arr))
                    {
                        if (isset($model_fkeys[$key]))
                        {
                            $mod_for_ref = 'App\\Models\\' . $model_fkeys[$key]['model'];

                            $lang       = $model_fkeys[$key]['lang'];
                            $field_name = $model_fkeys[$key]['field'];

                            if ($lang)
                            {
                                $field_name_en = $field_name . 'en';
                                $field_name_es = $field_name . 'es';
                            }

                            $old_value = $mod_for_ref::find($original[$key]);
                            $new_value = $mod_for_ref::find($val);
                            $message[] = [
                                'fieldlabel'     => $key,
                                'fk'             => true,
                                'oldvalue'       => $original[$key],
                                'oldValueLbl_en' => $old_value ? ($lang ? $old_value->$field_name_en : $old_value->$field_name) : 'N/A',
                                'oldValueLbl_es' => $old_value ? ($lang ? $old_value->$field_name_es : $old_value->$field_name) : 'N/A',
                                'newValueLbl_en' => $new_value ? ($lang ? $new_value->$field_name_en : $new_value->$field_name) : 'N/A',
                                'newValueLbl_es' => $new_value ? ($lang ? $new_value->$field_name_es : $new_value->$field_name) : 'N/A',
                                'newvalue'       => $val,
                                'type'           => $type
                            ];
                        }
                        else
                        {
                            $message[] = array('fieldlabel' => $key, 'fk' => false, 'oldvalue' => $original[$key], 'newvalue' => $val, 'type' => $type);
                        }
                    }
                }

                if (!empty($message))
                {
                    $userlog              = new UserActionLog;
                    $userlog->user_id     = auth::user()->id;
                    $userlog->action_type = 2;
                    $userlog->extra       = json_encode($message);
                    $userlog->model_name  = class_basename($model);
                    $userlog->tbl_name    = $tbl_name;
                    $userlog->tbl_id      = $original['id'];
                    $userlog->save();
                }
            }
        }
        catch (\Exception $ex)
        {
            Log::error('base_oberserver: updated ' . $ex->getMessage(), $model);
        }
    }

    public function deleted($model)
    {
        try
        {
            $tbl_name = $model->getTable();

            $message = array();
            $attr    = $model->getAttributes();
            $type    = 'deleted';

            $model_fkeys = $model->getFkeys();

            foreach ($attr as $key => $attr_val)
            {
                if (!in_array($key, $this->ignore_arr))
                {
                    if (isset($model_fkeys[$key]))
                    {
                        $mod_for_ref = 'App\\Models\\' . $model_fkeys[$key]['model'];

                        $lang       = $model_fkeys[$key]['lang'];
                        $field_name = $model_fkeys[$key]['field'];

                        if ($lang)
                        {
                            $field_name_en = $field_name . 'en';
                            $field_name_es = $field_name . 'es';
                        }
                        $new_value = $mod_for_ref::find($attr_val);
                        $message[] = [
                            'fieldlabel'     => $key,
                            'fk'             => true,
                            'oldvalue'       => '',
                            'newValueLbl_en' => $new_value ? ($lang ? $new_value->$field_name_en : $new_value->$field_name) : 'N/A',
                            'newValueLbl_es' => $new_value ? ($lang ? $new_value->$field_name_es : $new_value->$field_name) : 'N/A',
                            'newvalue'       => $attr_val,
                            'type'           => $type
                        ];
                    }
                    else
                    {
                        $message[] = array('fieldlabel' => $key, 'fk' => false, 'oldvalue' => '', 'newvalue' => $attr_val, 'type' => $type);
                    }
                }
            }
            $userlog              = new UserActionLog;
            $userlog->user_id     = Auth::user()->id;
            $userlog->action_type = 3;
            $userlog->extra       = json_encode($message);
            $userlog->model_name  = class_basename($model);
            $userlog->tbl_name    = $tbl_name;
            $userlog->tbl_id      = $model->id;
            $userlog->save();
        }
        catch (\Exception $ex)
        {
            Log::error('base_oberserver: deleted ' . $ex->getMessage(), $model);
        }
    }

}
