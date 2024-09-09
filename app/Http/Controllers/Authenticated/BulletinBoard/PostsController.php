<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Auth;

class PostsController extends Controller
{
    public function show(Request $request){
        // dd($request->keyword);
        $posts = Post::with('user', 'postComments')->get();
       $categories = MainCategory::with('subCategories')->get();
       $like = new Like;
       $post_comment = new Post;
       $query = Post::with('user', 'postComments', 'subCategories');



        if(!empty($request->keyword)){
            $keyword =$request->keyword;
            $posts = Post::with('user', 'postComments', 'subCategories')

            ->where('post_title', 'like', '%'.$request->keyword.'%')
            ->orWhere('post', 'like', '%'.$request->keyword.'%')
            ->orWhereHas('subCategories', function ($query) use ($keyword) {
            $query->where('sub_category', $keyword); // サブカテゴリーの完全一致検索
        })->get();
        }else if($request->category_word){
            $sub_category = $request->category_word;
            // dd($sub_category);
            $posts = Post::with('user', 'postComments')->
            whereHas('subCategories', function ($query) use ($sub_category) {
                $query->where('sub_category', $sub_category);
            })->get();
            // ->where
        }else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->get();
        }else if($request->my_posts){
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
        }

        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        // $likes_count = $post->likes()->count();
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    public function postCreate(PostFormRequest $request){
        // dd($request);
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        // dd($post);

         // 中間テーブルにサブカテゴリーを保存
        $post->subCategories()->attach($request->post_category_id);




        return redirect()->route('post.show');
    }



    public function postEdit(Request $request){

        $request->validate(
        [
            'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:5000',
        ],
        [
            'post_title.required' => 'タイトルは必須項目です。',
            'post_title.string' => 'タイトルは文字列で入力してください。',
            'post_title.max' => 'タイトルは100文字以内で入力してください。',
            'post_body.required' => '本文は必須項目です。',
            'post_body.string' => '本文は文字列で入力してください。',
            'post_body.max' => '本文は5000文字以内で入力してください。',
        ]
    );
        $post = Post::findOrFail($request->post_id);

        // 自分の投稿かどうかを確認
        if ($post->user_id != Auth::id()) {
            return redirect()->route('post.detail', ['id' => $request->post_id])->with('error', 'Unauthorized Access');
        }

        // 投稿の更新
        $post->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);

        return redirect()->route('post.detail', ['id' => $post->id]);
    }


    public function postDelete($id){
       $post = Post::findOrFail($id);

        // 自分の投稿かどうかを確認
        if ($post->user_id != Auth::id()) {
            return redirect()->route('post.show')->with('error', 'Unauthorized Access');
        }

        // 投稿の削除
        $post->delete();

        return redirect()->route('post.show')->with('success', 'Post deleted successfully');
    }

    public function mainCategoryCreate(Request $request){
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

     public function subCategoryCreate(Request $request){
        // dd($request);
        SubCategory::create([
            'main_category_id' => $request->main_category_id,
            'sub_category'     => $request->sub_category_name,
        ]);
        return redirect()->route('post.input');
     }

    public function commentCreate(Request $request){
         // バリデーションルールの追加
        $request->validate(
        [
            'comment' => 'required|string|max:250',
        ],
        [
            'comment.required' => 'コメントは必須項目です。',
            'comment.string' => 'コメントは文字列で入力してください。',
            'comment.max' => 'コメントは250文字以内で入力してください。',
        ]
    );

        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }




    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }
}
