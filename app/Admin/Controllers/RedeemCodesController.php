<?php

namespace App\Admin\Controllers;

use App\Models\RedeemCode;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class RedeemCodesController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('兑换码列表')
            ->description(' ')
            ->body($this->grid());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑兑换码')
            ->description(' ')
            ->body($this->form()->edit($id));
    }

    public function create(Content $content)
    {
        return $content
            ->header('创建兑换码')
            ->description(' ')
            ->body($this->form());
    }

    protected function grid()
    {
        $grid = new Grid(new RedeemCode);

        $grid->id('#')->sortable();
        $grid->code('兑换码');
        $grid->usable('可用数')->sortable();
        $grid->amount('面额')->sortable();
        $grid->created_at('创建时间')->sortable();
        $grid->updated_at('最后使用')->sortable();

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            $filter->like('code', '兑换码');
            $filter->between('created_at', '创建时间')->datetime();
        });

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new RedeemCode);

        $form->text('code', '兑换码');
        $form->number('usable', '可用数');
        $form->decimal('amount', '面额');

        $form->saving(function (Form $form) {
            if (!$form->code) {
                $form->code = RedeemCode::findAvailableCode();
            }
        });

        return $form;
    }
}
