<?php

namespace App\Admin\Controllers;

use App\Models\Package;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PackagesController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('流量包列表')
            ->description(' ')
            ->body($this->grid());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑流量包')
            ->description(' ')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('创建流量包')
            ->description(' ')
            ->body($this->form());
    }

    protected function grid()
    {
        $grid = new Grid(new Package);

        $grid->id('#')->sortable();
        $grid->traffic('流量')->display(function ($traffic) {
            return $traffic . 'MiB';
        })->sortable();
        $grid->price('价格')->sortable();

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Package);

        $form->decimal('traffic', '流量');
        $form->decimal('price', '价格');

        return $form;
    }
}
