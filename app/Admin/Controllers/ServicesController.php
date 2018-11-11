<?php

namespace App\Admin\Controllers;

use App\Models\Node;
use App\Models\Plan;
use App\Models\Service;
use App\Models\CouponCode;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ServicesController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('服务列表')
            ->description(' ')
            ->body($this->grid());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑服务')
            ->description(' ')
            ->body($this->form()->edit($id));
    }

    public function create(Content $content)
    {
        return $content
            ->header('创建服务')
            ->description(' ')
            ->body($this->form());
    }

    protected function grid()
    {
        $grid = new Grid(new Service);

        $grid->id('#')->sortable();
        $grid->plan_id('套餐')->display(function ($plan_id) {
            return Plan::find($plan_id)->name;
        });
        $grid->uuid('UUID');
        $grid->alter_id('Alter ID');
        $grid->security('加密方式')->display(function ($security) {
            return Service::securities()[$security];
        });
        $grid->traffic('剩余流量')->display(function ($traffic) {
            return $traffic . ' MiB';
        })->sortable();
        $grid->expired_at('过期时间')->sortable();
        $grid->created_at('开通时间')->sortable();

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            $filter->between('expired_at', '过期时间')->datetime();
            $filter->between('created_at', '开通时间')->datetime();
        });

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Service);

        $form->select('plan_id', '套餐')
            ->options(Plan::all()->pluck('name', 'id'));
        $form->text('uuid', 'UUID');
        $form->number('alter_id', 'Alter ID');
        $form->select('security', '加密方式')->options(Service::securities());
        $form->decimal('traffic', '剩余流量');
        $form->select('coupon_code_id', '优惠券')
            ->options(CouponCode::all()->pluck('code', 'id'));
        $form->datetime('expired_at', '过期时间')->default(date('Y-m-d H:i:s'));

        $form->saving(function (Form $form) {
            if (!$form->uuid) {
                $form->uuid = \Uuid::generate(4)->string;
            }
        });

        return $form;
    }
}
