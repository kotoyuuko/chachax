<?php

namespace App\Admin\Controllers;

use App\Models\InviteCode;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class InviteCodesController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('邀请码列表')
            ->description(' ')
            ->body($this->grid());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑邀请码')
            ->description(' ')
            ->body($this->form()->edit($id));
    }

    public function create(Content $content)
    {
        return $content
            ->header('创建邀请码')
            ->description(' ')
            ->body($this->form());
    }

    protected function grid()
    {
        $grid = new Grid(new InviteCode);

        $grid->id('#')->sortable();
        $grid->code('邀请码');
        $grid->usable('可用')->sortable();
        $grid->created_at('创建时间')->sortable();

        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });

        $grid->filter(function ($filter) {
            $filter->like('code', '邀请码');
            $filter->between('created_at', '创建时间')->datetime();
        });

        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new InviteCode);

        $form->text('code', '邀请码');
        $form->number('usable', '可用');

        $form->saving(function (Form $form) {
            if (!$form->code) {
                $form->code = InviteCode::findAvailableCode();
            }
        });

        return $form;
    }
}
