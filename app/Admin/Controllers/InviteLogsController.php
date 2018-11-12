<?php

namespace App\Admin\Controllers;

use App\Models\InviteLog;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class InviteLogsController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('邀请记录列表')
            ->description(' ')
            ->body($this->grid());
    }

    protected function grid()
    {
        $grid = new Grid(new InviteLog);

        $grid->id('#');
        $grid->invite_code_id('邀请码 ID');
        $grid->user_id('用户 ID');
        $grid->created_at('使用时间');

        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            $filter->equal('user_id', '用户 ID');
            $filter->equal('invite_code_id', '邀请码 ID');
            $filter->between('created_at', '使用时间')->datetime();
        });

        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        return $grid;
    }
}
