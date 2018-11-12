<?php

namespace App\Admin\Controllers;

use App\Models\Node;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class NodesController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('节点列表')
            ->description(' ')
            ->body($this->grid());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑节点信息')
            ->description(' ')
            ->body($this->form()->edit($id));
    }

    public function create(Content $content)
    {
        return $content
            ->header('创建节点')
            ->description(' ')
            ->body($this->form());
    }

    protected function grid()
    {
        $grid = new Grid(new Node);

        $grid->id('#')->sortable();
        $grid->name('节点名称');
        $grid->address('连接地址');
        $grid->port('端口');
        $grid->network('协议')->display(function ($network) {
            return Node::networks()[$network];
        });
        $grid->tls('TLS')->display(function ($tls) {
            return $tls ? '开' : '关';
        });
        $grid->created_at('创建时间')->sortable();

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            $filter->like('name', '节点名称');
            $filter->like('address', '连接地址');
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
        $form = new Form(new Node);

        $form->text('name', '节点名称');
        $form->textarea('description', '节点描述');
        $form->text('token', '连接令牌');
        $form->text('address', '连接地址');
        $form->number('port', '端口');
        $form->select('network', '协议')->options(Node::networks());
        $form->textarea('settings', '附加配置');
        $form->switch('tls', 'TLS');

        $form->saving(function (Form $form) {
            if (!$form->token) {
                $form->token = Node::findAvailableToken();
            }
        });

        return $form;
    }
}
