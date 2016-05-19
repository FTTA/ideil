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
        $lData = array_only($_POST, ['text', 'article_id']);

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

    public function blocking()
    {
        if (empty($_POST['comment_id']) || !is_numeric($_POST['comment_id']))
            die(Status::error_json('Invalid comment ID'));

        $lData['is_blocked'] = empty($_POST['is_blocked']) ? false : true;

        CommentsModel::edit($lData, $_POST['comment_id']);
        die(Status::success_json());
    }
}
