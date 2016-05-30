<?php namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Facades\Validator;
use App\AuthModule;
use App\Models\CommentsModel;
use App\Status;
use DB;

class CommentsAjaxController extends ParentajaxController
{
    public function add()
    {
        $lData = Request::only('title', 'article_id');

        $lFilters = [
            'text'       => 'required|min:5',
            'article_id' => 'integer'
        ];

        $lValidator = Validator::make($lData, $lFilters);

        if ($lValidator->fails()) {

            $lErrors = $lValidator->messages();

            $lPreparedErrors = implode(' ', $lErrors->all());

            die(Status::error_json($lPreparedErrors));
        }
        $lData['user_id']       = $this->current_user->id;
        $lData['date_creation'] = date('Y-m-d H:i:s');

        CommentsModel::add($lData);
        die(Status::success_json());
    }

    public function blocking($aCommetnId)
    {
        if (empty($aCommetnId) || !is_numeric($aCommetnId))
            die(Status::error_json('Invalid comment ID'));

        $lData['is_blocked'] = Request::input('is_blocked', false);

        CommentsModel::edit($lData, $aCommetnId);
        die(Status::success_json());
    }
}
