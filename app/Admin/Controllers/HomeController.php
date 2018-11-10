<?php

namespace App\Admin\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Service;
use App\Models\TrafficLog;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('首页')
            ->description(' ')
            ->row(function (Row $row) {
                $row->column(4, function (Column $column) {
                    $column->append(new InfoBox('用户量', 'users', 'aqua', '/admin/users', User::count()));
                });

                $row->column(4, function (Column $column) {
                    $column->append(new InfoBox('服务量', 'cubes', 'blue', '/admin/services', Service::count()));
                });

                $row->column(4, function (Column $column) {
                    $traffic = TrafficLog::where('created_at', '>', Carbon::parse('-1 day'))->sum('downlink');
                    $column->append(new InfoBox('最近一天下行流量', 'adjust', 'gray', '/admin/traffic_logs', $traffic . ' MiB'));
                });
            })
            ->row(function (Row $row) {
                $row->column(8, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $body  = '<p><b>版本</b><span class="pull-right">ChaChaX ' . CHACHAX_VERSION . '</span></p>';
                    $body .= '<p><b>作者</b><span class="pull-right"><a href="https://artifact.moe" target="_blank">kotoyuuko</a></span></p>';
                    $body .= '<p><b>框架</b><span class="pull-right">Laravel ' . app()::VERSION . '</span></p>';
                    $body .= '<p><b>协议</b><span class="pull-right">MIT</span></p>';
                    $column->append(new Box('关于 ChaChaX', $body));
                });
            });
    }
}
