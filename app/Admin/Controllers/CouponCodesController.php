<?php

namespace App\Admin\Controllers;

use App\Models\CouponCode;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CouponCodesController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('优惠券列表')
            ->description(' ')
            ->body($this->grid());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑优惠券')
            ->description(' ')
            ->body($this->form()->edit($id));
    }

    public function create(Content $content)
    {
        return $content
            ->header('创建优惠券')
            ->description(' ')
            ->body($this->form());
    }

    protected function grid()
    {
        $grid = new Grid(new CouponCode);

        $grid->id('#')->sortable();
        $grid->code('优惠码');
        $grid->description('描述');
        $grid->column('usage', '用量')->display(function ($value) {
            return "{$this->used} / {$this->total}";
        });
        $grid->not_before('开始时间');
        $grid->not_after('结束时间');
        $grid->enabled('可用')->display(function ($value) {
            return $value ? '是' : '否';
        });
        $grid->created_at('创建时间')->sortable();

        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });

        $grid->filter(function ($filter) {
            $filter->like('code', '优惠码');
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
        $form = new Form(new CouponCode);

        $form->text('code', '优惠码')->rules(function($form) {
            if ($id = $form->model()->id) {
                return 'nullable|unique:coupon_codes,code,' . $id . ',id';
            } else {
                return 'nullable|unique:coupon_codes';
            }
        });
        $form->radio('type', '类型')->options(CouponCode::types())->rules('required');
        $form->text('value', '折扣')->rules(function ($form) {
            if ($form->type === 'percent') {
                return 'required|numeric|between:1,99';
            } else {
                return 'required|numeric|min:0.01';
            }
        });
        $form->number('limit', '最少购买月数')->default(1);
        $form->number('total', '总量')->rules('required|numeric|min:1');
        $form->datetime('not_before', '开始时间');
        $form->datetime('not_after', '结束时间');
        $form->switch('enabled', '启用')->default(true);

        $form->saving(function (Form $form) {
            if (!$form->code) {
                $form->code = CouponCode::findAvailableCode();
            }
        });

        return $form;
    }
}
