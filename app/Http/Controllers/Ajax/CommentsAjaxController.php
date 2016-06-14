<?php namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Facades\Validator;
use App\AuthModule;
use Request;
use App\Status;
use DB;

use App\Models\Comment;

class CommentsAjaxController extends ParentajaxController
{
    public function add()
    {
        $lData = Request::only('text', 'article_id');

        $lFilters = [
            'text'       => 'required|min:5',
            'article_id' => 'integer'
        ];

        $lValidator = Validator::make($lData, $lFilters);

        if ($lValidator->fails()) {

            $lErrors = $lValidator->messages();

            $lPreparedErrors = implode(' ', $lErrors->all());

            return Status::error_json($lPreparedErrors);
        }
        $lData['user_id']       = $this->current_user->id;
        $lData['date_creation'] = date('Y-m-d H:i:s');

        Comment::create($lData);
        return Status::success_json();
    }

    public function blocking($aCommetnId)
    {
        if (empty($aCommetnId) || !is_numeric($aCommetnId))
            return Status::error_json('Invalid comment ID');

        $lData['is_blocked'] = Request::input('is_blocked', false);

        Comment::where('id', '=', $aCommetnId)
            ->update($lData);

        return Status::success_json();
    }
}
