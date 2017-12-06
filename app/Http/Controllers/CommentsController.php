<?php

namespace App\Http\Controllers;

use App\Comments;
use App\Http\Translate\Translate;
use App\Post;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function index()
	{
		if (Auth::user()->is_admin == 1) {
			$comments = Comments::with('getPost')->get();
		} else {
			$comments = Comments::with(['getPost', function($q) {
				$q->where('user_id', Auth::user()->id);
			}])->get();
		}
		return view('admin.comments.index', compact('comments'));
	}

	public function create()
	{
		if (Auth::user()->is_admin == 1) {
			$posts = Post::pluck('title_lang_key', 'id');
		} else {
			$posts = Post::where('user_id', Auth::user()->id)->pluck('title_lang_key', 'id');
		}
		$statuses = Status::where('is_comment', 1)->pluck('name', 'id');

		$p = [];
		foreach ($posts as $key => $val) {
			$p[$key] = Translate::getValue($val);
		}
		return view('admin.comments.create', compact('p', 'statuses'));
	}

	public function store(Request $request)
	{
		$comm = Comments::create([
			'post_id'   => $request->input('post'),
			'status_id' => $request->input('status'),
			'writer_name'   => $request->input('writer-name'),
			'writer_email'   => $request->input('writer-email'),
			'content'   => $request->input('content')
		]);

		if ($request->input('status') == 2) {
			$comm->submited_at = date('Y-m-d H:i:s', time());
			$comm->save();
		}

		return redirect('admin/comments')->with('success', 'Comment created.');
	}

	public function edit($id, Request $request)
	{
		$comment    = Comments::find($id);
		$statuses   = Status::where('is_comment', 1)->pluck('name', 'id');
		if (Auth::user()->is_admin == 1) {
			$posts = Post::pluck('title_lang_key', 'id');
		} else {
			$posts = Post::where('user_id', Auth::user()->id)->pluck('title_lang_key', 'id');
		}
		$p = [];
		foreach ($posts as $key => $val) {
			$p[$key] = Translate::getValue($val);
		}
		return view('admin.comments.edit', compact('comment', 'statuses', 'p'));
	}

	public function update($id, Request $request)
	{
		$comment = Comments::find($id);

		if ($comment->post_id != $request->input('post')) {
			$comment->post_id = $request->input('post');
		}

		if ($request->input('status') == 2) {
			$comment->submited_at = date('Y-m-d H:i:s', time());
			$comment->status_id = $request->input('status');
		} else {
			$comment->submited_at = NULL;
			$comment->status_id = $request->input('status');
		}

		if ($comment->writer_name != $request->input('writer-name')) {
			$comment->writer_name = $request->input('writer-name');
		}
		if ($comment->writer_email != $request->input('writer-email')) {
			$comment->writer_email = $request->input('writer-email');
		}
		if ($comment->content != $request->input('content')) {
			$comment->content = $request->input('content');
		}
		$comment->save();

		return redirect('admin/comments')->with('success', 'Comment was changed and saved.');
	}

	public function getModalDelete($id = null)
	{
		$error          = '';
		$model          = '';
		$confirm_route  =  route('comments.delete',['id'=>$id]);
		return View('admin/layouts/modal_confirmation', compact('error','model', 'confirm_route'));
	}

	public function getDelete($id = null)
	{
		Comments::where('id', $id)->delete();
		return redirect('admin/comments')->with('success', 'Comment was deleted success.');
	}
}
