<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\PaymentLog;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PaymentLogsController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('交易记录列表')
            ->description(' ')
            ->body($this->grid());
    }

    public function show($id, Content $content)
    {
        return $content
            ->header('交易记录详情')
            ->description(' ')
            ->body($this->detail($id));
    }

    protected function grid()
    {
        $grid = new Grid(new PaymentLog);

        $grid->id('#')->sortable();
        $grid->user_id('用户')->display(function ($user_id) {
            return User::find($user_id)->name;
        });
        $grid->type('类型')->display(function ($type) {
            return $type == 'recharge' ? '充值' : '消费';
        });
        $grid->payment('支付方式')->display(function ($payment) {
            switch ($payment) {
                case 'balance':
                    return '余额';
                case 'youzan':
                    return '有赞';
                case 'redeem':
                    return '兑换码';
                default:
                    return '未知';
            }
        });
        $grid->payment_id('支付网关 ID');
        $grid->amount('金额')->sortable();
        $grid->paid_at('支付时间')->display(function ($paid_at) {
            return $paid_at ? $paid_at : '未支付';
        })->sortable();
        $grid->created_at('创建时间')->sortable();

        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            $filter->in('type', '类型')->checkbox([
                'recharge' => '充值',
                'pay' => '消费',
            ]);
            $filter->in('payment', '支付方式')->checkbox([
                'balance' => '余额',
                'youzan' => '有赞',
                'redeem' => '兑换码',
            ]);
            $filter->between('paid_at', '支付时间')->datetime();
            $filter->between('created_at', '创建时间')->datetime();
        });

        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        return $grid;
    }
}
