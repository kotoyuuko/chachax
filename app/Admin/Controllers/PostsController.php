<?php

namespace App\Admin\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PostsController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('文章列表')
            ->description(' ')
            ->body($this->grid());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑文章')
            ->description(' ')
            ->body($this->form()->edit($id));
    }

    public function create(Content $content)
    {
        return $content
            ->header('创建文章')
            ->description(' ')
            ->body($this->form());
    }

    protected function grid()
    {
        $grid = new Grid(new Post);

        $grid->id('#');
        $grid->slug('标识');
        $grid->title('标题');
        $grid->priority('权重')->display(function ($priority) {
            if ($priority < 0) {
                return '不显示';
            }
            return $priority;
        });
        $grid->created_at('创建时间');

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            $filter->like('slug', '标识');
            $filter->like('title', '标题');
            $filter->between('created_at', '创建时间')->datetime();
        });

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Post);

        $form->text('slug', '标识');
        $form->text('title', '标题');
        $form->textarea('body', '内容');
        $form->number('priority', '权重');

        return $form;
    }
}
