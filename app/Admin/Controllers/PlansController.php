<?php

namespace App\Admin\Controllers;

use App\Models\Node;
use App\Models\Plan;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PlansController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('套餐列表')
            ->description(' ')
            ->body($this->grid());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑套餐')
            ->description(' ')
            ->body($this->form()->edit($id));
    }

    public function create(Content $content)
    {
        return $content
            ->header('创建套餐')
            ->description(' ')
            ->body($this->form());
    }

    protected function grid()
    {
        $grid = new Grid(new Plan);

        $grid->id('#')->sortable();
        $grid->name('套餐名称');
        $grid->level('Level');
        $grid->traffic('流量')->display(function ($traffic) {
            return $traffic . ' MiB';
        })->sortable();
        $grid->price('价格')->sortable();
        $grid->stock('库存')->sortable();
        $grid->created_at('创建时间')->sortable();

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            $filter->like('name', '套餐名称');
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
        $form = new Form(new Plan);

        $form->text('name', '套餐名称');
        $form->textarea('description', '简介');
        $form->number('level', 'Level');
        $form->decimal('traffic', '流量');
        $form->decimal('price', '价格');
        $form->number('stock', '库存');
        $form->multipleSelect('nodes', '节点列表')
            ->options(Node::all()->pluck('name', 'id'));

        return $form;
    }
}
