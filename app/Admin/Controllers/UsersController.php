<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UsersController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('用户列表')
            ->description(' ')
            ->body($this->grid());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑用户资料')
            ->description(' ')
            ->body($this->form()->edit($id));
    }

    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->id('#')->sortable();
        $grid->name('昵称');
        $grid->email('E-Mail');
        $grid->balance('余额');
        $grid->verified_at('验证')->display(function ($verified_at) {
            return $verified_at ? '是' : '否';
        })->sortable();
        $grid->created_at('注册时间')->sortable();

        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            $filter->like('name', '昵称');
            $filter->like('email', 'E-Mail');
            $filter->between('created_at', '注册时间')->datetime();
        });

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new User);

        $form->text('name', '昵称');
        $form->email('email', 'E-Mail');
        $form->decimal('balance', '余额')->default(0.00);
        $form->datetime('verified_at', '验证时间')->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
