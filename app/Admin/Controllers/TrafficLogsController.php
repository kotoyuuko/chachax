<?php

namespace App\Admin\Controllers;

use App\Models\Node;
use App\Models\Service;
use App\Models\TrafficLog;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class TrafficLogsController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('流量记录列表')
            ->description(' ')
            ->body($this->grid());
    }

    protected function grid()
    {
        $grid = new Grid(new TrafficLog);

        $grid->id('#')->sortable();
        $grid->service_id('服务 ID');
        $grid->node_id('节点')->display(function ($node_id) {
            $node = Node::find($node_id);
            return '#' . $node->id . ' ' . $node->name;
        });
        $grid->uplink('上行流量')->display(function ($uplink) {
            return $uplink . ' MiB';
        });
        $grid->downlink('下行流量')->display(function ($downlink) {
            return $downlink . ' MiB';
        });
        $grid->traffic('结算流量')->display(function ($traffic) {
            return $traffic . ' MiB';
        });
        $grid->created_at('记录时间')->sortable();

        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            $filter->equal('service_id', '服务 ID');
            $filter->equal('node_id', '节点 ID');
            $filter->between('created_at', '记录时间')->datetime();
        });

        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        return $grid;
    }
}
